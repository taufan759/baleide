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
        ];

        return view('admin.dashboard.index', $data)->with('sb', 'Dashboard');
    }
}