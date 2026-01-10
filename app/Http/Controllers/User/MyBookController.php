<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MyBookController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            $purchasedEbookIds = TransactionItem::whereHas('transaction', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('payment_status', 'paid');
            })->pluck('ebook_id');

            $data = Ebook::with(['photos', 'category'])
                ->whereIn('id', $purchasedEbookIds)
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('cover', function ($row) {
                    $firstPhoto = $row->photos->first();
                    $url = $firstPhoto ? asset($firstPhoto->photo) : asset('assets/img/default-ebook.png');
                    return '<img src="' . $url . '" width="50" class="img-thumbnail">';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->category->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . url('dashboard/my-books/' . $row->slug) . '" class="btn btn-primary btn-sm"><i class="fas fa-book-open"></i> Baca</a>';
                })
                ->rawColumns(['cover', 'action'])
                ->make(true);
        }

        return view('user.mybooks.index', [
            'sb' => 'MyBooks'
        ]);
    }

    public function show($slug)
    {
        $user = Auth::user();
        $ebook = Ebook::where('slug', $slug)->firstOrFail();

        $isPurchased = TransactionItem::where('ebook_id', $ebook->id)
            ->whereHas('transaction', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('payment_status', 'paid');
            })->exists();

        if (!$isPurchased) {
            return redirect('/dashboard')->with('error', 'Anda belum membeli buku ini.');
        }

        return view('user.mybooks.read', [
            'ebook' => $ebook,
            'sb' => 'MyBooks'
        ]);
    }
}