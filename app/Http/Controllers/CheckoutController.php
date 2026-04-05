<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // ============================
    // TAMPILKAN HALAMAN CHECKOUT
    // ============================
    public function index()
    {
        $cart = session('cart', []);

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        return view('checkout', compact('cart', 'total'));
    }

    // ============================
    // PROSES CHECKOUT
    // ============================
    public function process(Request $request)
    {
        $request->validate([
            'payment' => 'required'
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        // Simpan data order terakhir (sementara pakai session)
        session([
            'last_order' => [
                'items'   => $cart,
                'total'   => $total,
                'payment' => $request->payment
            ]
        ]);

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('checkout.success');
    }
}
