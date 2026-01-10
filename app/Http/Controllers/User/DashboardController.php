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
        $today = Carbon::today();

        $purchasedEbookIds = TransactionItem::whereHas('transaction', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('payment_status', 'paid');
        })->pluck('ebook_id');

        $data = [
            'today'         => Carbon::now()->isoFormat('dddd, D MMMM Y'),
            'myBooksCount'  => $purchasedEbookIds->count(),
            'ebookCount'    => Ebook::count(),
            'mySpending'    => Transaction::where('user_id', $user->id)
                                ->where('payment_status', 'paid')
                                ->sum('total_amount'),
            'latestEbooks'  => Ebook::with('photos')->latest()->take(5)->get(),
            'myCollections' => Ebook::with('photos')
                                ->whereIn('id', $purchasedEbookIds)
                                ->latest()
                                ->take(4)
                                ->get(),
        ];

        return view('user.dashboard.index', $data)->with('sb', 'Dashboard');
    }
}