<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Ebook;
use App\Models\Voucher;
use App\Models\Category;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;

class GuestController extends Controller
{
    /**
     * 1. HOME: Menampilkan Top Categories, Populer, Baru, dan List Kategori
     */
    public function home()
    {
        // Semua kategori untuk navigasi/sidebar
        $categories = Category::all();

        // Section 1: Top Categories (Diambil 5 buku secara acak/random sebagai sorotan)
        $topBooks = Ebook::with(['photos', 'category'])
            ->inRandomOrder()
            ->take(5)
            ->get();

        // Section 2: Buku Populer (Diambil 6 buku)
        $popularBooks = Ebook::with(['photos', 'category'])
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Section 3: Buku Baru Dirilis (Berdasarkan created_at terbaru)
        $latestBooks = Ebook::with(['photos', 'category'])
            ->latest()
            ->take(6)
            ->get();

        return view('guest.home', compact('categories', 'topBooks', 'popularBooks', 'latestBooks'));
    }

    /**
     * 2. KATEGORI: Menampilkan buku berdasarkan kategori
     */
    public function showCategory($slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $books = Ebook::with(['photos', 'category'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('guest.category', compact('category', 'books', 'categories'));
    }

    /**
     * 3. BUKU: Menampilkan semua list buku dengan pagination & Search
     */
    public function allBooks(Request $request)
    {
        $categories = Category::all();
        $query = Ebook::with(['photos', 'category']);

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        $books = $query->latest()->paginate(12);

        return view('guest.books', compact('books', 'categories'));
    }

    /**
     * 4. DETAIL BUKU: Detail informasi dan Rekomendasi terkait
     */
    public function showEbook($slug)
    {
        $categories = Category::all();
        $book = Ebook::with(['photos', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $recommendations = Ebook::with(['photos'])
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('guest.detail-ebook', compact('book', 'recommendations', 'categories'));
    }

    /**
     * 5. CART: Hanya view (Data dihandle JavaScript/LocalStorage)
     */
    public function showCart()
    {
        $categories = Category::all();
        return view('guest.cart', compact('categories'));
    }

    public function fetchCart(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([]);
        }

        $ebooks = Ebook::whereIn('id', $ids)
            ->with(['photos', 'category'])
            ->get()
            ->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'title'     => $item->title,
                    'price'     => (float) $item->price,
                    'slug'      => $item->slug,
                    'category'  => $item->category ? $item->category->name : 'Uncategorized',
                    'cover_url' => $item->photos->first() 
                                    ? asset($item->photos->first()->photo) 
                                    : asset('assets/img/default-ebook.png'),
                ];
            });

        return response()->json($ebooks);
    }

    /**
     * 6. PAYMENT: Checkout Snap Midtrans
     */
    public function checkout(Request $request)
    {
        $ebookIds = $request->input('ebook_ids', []);
        $voucherCode = $request->input('voucher_code');
        
        if (empty($ebookIds)) {
            return response()->json(['message' => 'Keranjang kosong'], 400);
        }

        $grossAmount = 0;
        $itemDetails = [];
        $selectedEbooks = Ebook::whereIn('id', $ebookIds)->get();

        if ($selectedEbooks->isEmpty()) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        foreach ($selectedEbooks as $ebook) {
            $grossAmount += (int) $ebook->price;
        }

        $discountAmount = 0;
        $voucherId = null;
        
        if ($voucherCode) {
            $voucher = Voucher::where('code', strtoupper(trim($voucherCode)))
                ->where('status', 'active')
                ->first();
                
            if ($voucher) {
                $discountAmount = ($grossAmount * $voucher->discount_percent) / 100;
                $voucherId = $voucher->id;
            }
        }

        $finalAmount = max(0, $grossAmount - $discountAmount);

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total_amount' => $finalAmount, 
            'payment_status' => 'pending',
            'midtrans_order_id' => 'BALEIDE-' . time() . '-' . auth()->id(),
            'discount_amount' => $discountAmount,
            'voucher_code' => $voucherCode,
        ]);

        foreach ($selectedEbooks as $ebook) {
            $price = (int) $ebook->price;

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'ebook_id' => $ebook->id,
                'qty' => 1,
                'price' => $price,
                'subtotal' => $price,
            ]);

            $itemDetails[] = [
                'id' => (string) $ebook->id,
                'price' => $price,
                'quantity' => 1,
                'name' => substr($ebook->title, 0, 50),
            ];
        }

        if ($discountAmount > 0) {
            $itemDetails[] = [
                'id' => 'DISCOUNT',
                'price' => -$discountAmount,
                'quantity' => 1,
                'name' => 'Diskon Voucher: ' . $voucherCode,
            ];
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->midtrans_order_id,
                'gross_amount' => (int) $finalAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $transaction->midtrans_order_id
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function callback(Request $request)
    {
        $orderId = $request->order_id;
        $status = $request->transaction_status;

        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        if (in_array($status, ['settlement', 'capture'])) {
            $transaction->update([
                'payment_status' => 'paid',
                'midtrans_transaction_id' => $request->transaction_id ?? $transaction->midtrans_transaction_id
            ]);
        } elseif ($status == 'pending') {
            $transaction->update(['payment_status' => 'pending']);
        } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
            $transaction->update(['payment_status' => 'failed']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Status transaksi berhasil diperbarui',
            'current_status' => $transaction->payment_status
        ]);
    }

    public function buyNow($slug)
    {
        $ebook = Ebook::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        return view('guest.checkout_direct', compact('ebook', 'categories'));
    }

    public function processDirectCheckout(Request $request)
    {
        $ebookId = $request->input('ebook_id');
        $voucherCode = $request->input('voucher_code');
        
        $ebook = Ebook::findOrFail($ebookId);
        
        $grossAmount = (int) $ebook->price;
        $discountAmount = 0;
        
        if ($voucherCode) {
            $voucher = Voucher::where('code', strtoupper(trim($voucherCode)))
                ->where('status', 'active')
                ->first();
                
            if ($voucher) {
                $discountAmount = ($grossAmount * $voucher->discount_percent) / 100;
            }
        }
        
        $finalAmount = max(0, $grossAmount - $discountAmount);

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total_amount' => $finalAmount,
            'payment_status' => 'pending',
            'midtrans_order_id' => 'BALEIDE-' . time() . '-' . auth()->id(),
            'discount_amount' => $discountAmount,
            'voucher_code' => $voucherCode, 
        ]);

        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'ebook_id' => $ebook->id,
            'qty' => 1,
            'price' => $grossAmount,
            'subtotal' => $grossAmount,
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $itemDetails = [
            [
                'id' => (string) $ebook->id,
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => substr($ebook->title, 0, 50),
            ]
        ];

        if ($discountAmount > 0) {
            $itemDetails[] = [
                'id' => 'DISCOUNT',
                'price' => -(int)$discountAmount,
                'quantity' => 1,
                'name' => 'Voucher: ' . $voucherCode,
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->midtrans_order_id,
                'gross_amount' => (int) $finalAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $transaction->midtrans_order_id
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $categories = Category::all();
        $orderId = $request->query('order');
        $transaction = Transaction::where('midtrans_order_id', $orderId)
                        ->with('items.ebook')
                        ->firstOrFail();

        return view('guest.checkout-success', compact('transaction', 'categories'));
    }
    
    /**
     * 7. KONTAK
     */
    public function contact()
    {
        $categories = Category::all();
        return view('guest.contact', compact('categories'));
    }

    public function contactSend(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Mail::to('admin@example.com')->send(new ContactMail($request->all()));

        return back()->with('success', 'Pesan Anda telah berhasil dikirim!');
    }
}