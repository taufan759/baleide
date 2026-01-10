<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            
            $data = Transaction::with(['transactionItems.ebook'])
                ->where('user_id', $user->id)
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('books', function ($row) {
                    return $row->transactionItems->map(function ($item) {
                        return '<span class="badge badge-light">' . ($item->ebook->title ?? 'Buku Tidak Ditemukan') . '</span>';
                    })->implode(' ');
                })
                ->editColumn('total_amount', function ($row) {
                    return 'Rp ' . number_format($row->total_amount, 0, ',', '.');
                })
                ->editColumn('payment_status', function ($row) {
                    if ($row->payment_status == 'paid') {
                        return '<span class="badge badge-success">Berhasil</span>';
                    } elseif ($row->payment_status == 'pending') {
                        return '<span class="badge badge-warning">Menunggu</span>';
                    } else {
                        return '<span class="badge badge-danger">Gagal / Dibatalkan</span>';
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('D MMMM Y, HH:mm');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . url('dashboard/transactions/' . $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                })
                ->rawColumns(['books', 'payment_status', 'action'])
                ->make(true);
        }

        return view('user.transactions.index', [
            'sb' => 'Transaction'
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $transaction = Transaction::with(['transactionItems.ebook.photos'])
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('user.transactions.show', [
            'transaction' => $transaction,
            'sb' => 'Transaction'
        ]);
    }
}