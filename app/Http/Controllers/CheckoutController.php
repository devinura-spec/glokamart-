<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

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
            'payment' => 'required',
             
            
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
      $order = Order::create([
    'user_id'        => auth()->id(),
    'total_price'    => $total + 10000, // ongkir
    'payment_status' => 'pending',       // default status
    'payment_method' => $request->payment,
   
]);


foreach ($cart as $id => $item) {
    OrderDetail::create([
        'order_id'   => $order->id,
        'product_id' => $id,
        'qty'        => $item['qty'],
        'price'      => $item['price'],
    ]);
};
      

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('checkout.success');
    }
}
