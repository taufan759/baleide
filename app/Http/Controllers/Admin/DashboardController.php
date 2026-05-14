<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ebook;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Data grafik pendapatan 3 bulan terakhir (per minggu)
        $revenueLabels = [];
        $revenueChart  = [];
        $transactionChart = [];

        // Bagi 3 bulan jadi 12 minggu
        for ($i = 11; $i >= 0; $i--) {
            $weekStart = Carbon::now()->startOfWeek()->subWeeks($i);
            $weekEnd   = $weekStart->copy()->endOfWeek();
            $revenueLabels[]    = $weekStart->isoFormat('D MMM');
            $revenueChart[]     = (float) Transaction::whereBetween('created_at', [$weekStart, $weekEnd])
                                    ->where('payment_status', 'paid')
                                    ->sum('total_amount');
            $transactionChart[] = Transaction::whereBetween('created_at', [$weekStart, $weekEnd])
                                    ->where('payment_status', 'paid')
                                    ->count();
        }

        // Data grafik ebook per kategori (pie chart)
        $categoryLabels = [];
        $categoryData   = [];
        $ebooksByCategory = Ebook::with('category')
            ->get()
            ->groupBy(fn($e) => $e->category->name ?? 'Umum');
        foreach ($ebooksByCategory as $catName => $ebooks) {
            $categoryLabels[] = $catName;
            $categoryData[]   = $ebooks->count();
        }

        $data = [
            'today'            => Carbon::now()->isoFormat('dddd, D MMMM Y'),
            'userCount'        => User::where('role', 'user')->count(),
            'ebookCount'       => Ebook::count(),
            'transactionToday' => Transaction::whereDate('created_at', $today)
                                    ->where('payment_status', 'paid')
                                    ->count(),
            'incomeToday'      => Transaction::whereDate('created_at', $today)
                                    ->where('payment_status', 'paid')
                                    ->sum('total_amount'),
            'latestEbooks'     => Ebook::with('category')->latest()->take(5)->get(),
            'revenueLabels'    => json_encode($revenueLabels),
            'revenueChart'     => json_encode($revenueChart),
            'transactionChart' => json_encode($transactionChart),
            'categoryLabels'   => json_encode($categoryLabels),
            'categoryData'     => json_encode($categoryData),
        ];

        return view('admin.dashboard.index', $data)->with('sb', 'Dashboard');
    }
}
