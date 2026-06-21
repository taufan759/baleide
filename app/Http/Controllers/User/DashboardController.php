<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $purchasedEbookIds = TransactionItem::whereHas('transaction', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('payment_status', 'paid');
        })->pluck('ebook_id');

        // Kategori favorit user (berdasarkan pembelian)
        $favoriteCategories = Ebook::with('category')
            ->whereIn('id', $purchasedEbookIds)
            ->get()
            ->groupBy('category.name')
            ->map(fn($items) => $items->count())
            ->sortDesc()
            ->take(3);

        // Data grafik pengeluaran 6 bulan terakhir
        $spendingLabels = [];
        $spendingData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $spendingLabels[] = $month->isoFormat('MMM Y');
            $spendingData[]   = (float) Transaction::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
        }

        // Total transaksi sukses
        $totalTransactions = Transaction::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->count();

        $data = [
            'today'          => Carbon::now()->isoFormat('dddd, D MMMM Y'),
            'myBooksCount'   => $purchasedEbookIds->count(),
            'ebookCount'     => Ebook::count(),
            'totalTransactions' => $totalTransactions,
            'favoriteCategories' => $favoriteCategories,
            'mySpending'     => Transaction::where('user_id', $user->id)
                                ->where('payment_status', 'paid')
                                ->sum('total_amount'),
            'latestEbooks'   => Ebook::with('photos')->latest()->take(5)->get(),
            'myCollections'  => Ebook::with('photos')
                                ->whereIn('id', $purchasedEbookIds)
                                ->latest()
                                ->take(4)
                                ->get(),
            'spendingLabels' => json_encode($spendingLabels),
            'spendingData'   => json_encode($spendingData),
        ];

        return view('user.dashboard.index', $data)->with('sb', 'Dashboard');
    }
}
