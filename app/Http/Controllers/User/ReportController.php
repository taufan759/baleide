<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman laporan
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ambil parameter filter
        $reportType = $request->input('type', 'all'); // all, transaction, spending, category
        $period = $request->input('period', '6months'); // 6months, 1year, all
        $categoryId = $request->input('category_id');
        
        // Hitung range tanggal
        $startDate = $this->getStartDate($period);
        $endDate = Carbon::now();
        
        // Data dasar
        $transactions = Transaction::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->when($categoryId, function($q) use ($categoryId) {
                $q->whereHas('items.ebook', fn($q2) => $q2->where('category_id', $categoryId));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik
        $stats = [
            'total_transactions' => $transactions->count(),
            'total_spending' => $transactions->sum('total_amount'),
            'total_books' => $transactions->sum(fn($t) => $t->items->count()),
            'avg_transaction' => $transactions->count() > 0 ? $transactions->avg('total_amount') : 0,
        ];

        // Data untuk grafik berdasarkan tipe laporan
        $chartData = $this->getChartData($user, $reportType, $period, $categoryId);
        
        // Kategori untuk filter
        $categories = Category::orderBy('name')->get();
        
        // Breakdown per kategori
        $categoryBreakdown = $this->getCategoryBreakdown($user, $startDate, $endDate);
        
        return view('user.reports.index', [
            'sb' => 'Laporan',
            'transactions' => $transactions,
            'stats' => $stats,
            'chartData' => $chartData,
            'categories' => $categories,
            'categoryBreakdown' => $categoryBreakdown,
            'filters' => [
                'type' => $reportType,
                'period' => $period,
                'category_id' => $categoryId,
            ]
        ]);
    }

    /**
     * Export laporan ke PDF (HTML print view)
     */
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $period = $request->input('period', '6months');
        $categoryId = $request->input('category_id');
        
        $startDate = $this->getStartDate($period);
        $endDate = Carbon::now();
        
        $transactions = Transaction::with('items.ebook.category')
            ->where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->when($categoryId, function($q) use ($categoryId) {
                $q->whereHas('items.ebook', fn($q2) => $q2->where('category_id', $categoryId));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_transactions' => $transactions->count(),
            'total_spending' => $transactions->sum('total_amount'),
            'total_books' => $transactions->sum(fn($t) => $t->items->count()),
            'period' => $this->getPeriodLabel($period),
        ];

        $categoryBreakdown = $this->getCategoryBreakdown($user, $startDate, $endDate);

        // Return HTML view yang bisa di-print jadi PDF
        return view('user.reports.pdf', [
            'user' => $user,
            'transactions' => $transactions,
            'stats' => $stats,
            'categoryBreakdown' => $categoryBreakdown,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Get start date based on period
     */
    private function getStartDate($period)
    {
        return match($period) {
            '1month' => Carbon::now()->subMonth(),
            '3months' => Carbon::now()->subMonths(3),
            '6months' => Carbon::now()->subMonths(6),
            '1year' => Carbon::now()->subYear(),
            'all' => null,
            default => Carbon::now()->subMonths(6),
        };
    }

    /**
     * Get period label
     */
    private function getPeriodLabel($period)
    {
        return match($period) {
            '1month' => '1 Bulan Terakhir',
            '3months' => '3 Bulan Terakhir',
            '6months' => '6 Bulan Terakhir',
            '1year' => '1 Tahun Terakhir',
            'all' => 'Semua Periode',
            default => '6 Bulan Terakhir',
        };
    }

    /**
     * Get chart data based on report type
     */
    private function getChartData($user, $reportType, $period, $categoryId)
    {
        $startDate = $this->getStartDate($period);
        $months = $period === '1year' ? 12 : ($period === 'all' ? 12 : 6);
        
        $labels = [];
        $spendingData = [];
        $transactionCountData = [];
        $bookCountData = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->isoFormat('MMM Y');
            
            $query = Transaction::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month);
                
            if ($categoryId) {
                $query->whereHas('items.ebook', fn($q) => $q->where('category_id', $categoryId));
            }
            
            $monthTransactions = $query->get();
            $spendingData[] = (float) $monthTransactions->sum('total_amount');
            $transactionCountData[] = $monthTransactions->count();
            $bookCountData[] = $monthTransactions->sum(fn($t) => $t->items->count());
        }
        
        return [
            'labels' => $labels,
            'spending' => $spendingData,
            'transaction_count' => $transactionCountData,
            'book_count' => $bookCountData,
        ];
    }

    /**
     * Get category breakdown
     */
    private function getCategoryBreakdown($user, $startDate, $endDate)
    {
        $purchasedEbookIds = TransactionItem::whereHas('transaction', function ($query) use ($user, $startDate, $endDate) {
            $query->where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->when($endDate, fn($q) => $q->where('created_at', '<=', $endDate));
        })->pluck('ebook_id');

        $breakdown = Ebook::with('category')
            ->whereIn('id', $purchasedEbookIds)
            ->get()
            ->groupBy('category.name')
            ->map(function($items) {
                return [
                    'count' => $items->count(),
                    'total_price' => $items->sum('price'),
                ];
            })
            ->sortByDesc('count');

        return $breakdown;
    }
}
