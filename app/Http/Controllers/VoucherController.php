<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function checkVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $code = strtoupper(trim($request->code));
        $subtotal = $request->subtotal;

        // Cari voucher berdasarkan kode
        $voucher = Voucher::where('code', $code)
            ->where('status', 'active')
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak valid'
            ]);
        }

        // Hitung diskon berdasarkan persentase
        $discountPercent = $voucher->discount_percent;
        $discount = ($subtotal * $discountPercent) / 100;

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diterapkan! Diskon ' . $discountPercent . '%',
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'type' => 'percentage',
                'value' => $discountPercent,
                'max_discount' => null,
                'discount_amount' => $discount
            ]
        ]);
    }
}