<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // =====================================
    // TAMPILKAN HALAMAN KERANJANG
    // =====================================
    public function index()
    {
        $cart = session('cart', []);

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        return view('cart.index', compact('cart', 'total'));
    }

    // =====================================
    // TAMBAH PRODUK KE KERANJANG
    // =====================================
    public function add(Request $request, $id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'id'    => $id,
                'name'  => "Produk #{$id}",
                'price' => rand(50000, 150000),
                'qty'   => 1,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()
    ->with('success', "Produk #{$id} ditambahkan ke keranjang!")
    ->with('openCart', true);
    }

    // =====================================
    // UPDATE JUMLAH PRODUK
    // =====================================
    public function update(Request $request, $id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            if ($request->qty < 1) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $request->qty;
            }
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index');
    }

    // =====================================
    // HAPUS SATU PRODUK
    // =====================================
    public function remove($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // =====================================
    // HAPUS SEMUA PRODUK
    // =====================================
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang dikosongkan.');
    }

    // =====================================
    // CHECKOUT PRODUK TERPILIH
    // =====================================
    public function checkoutSelected(Request $request)
    {
        // ambil ID produk yang dicentang
        $selectedIds = $request->input('selected', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.index')
                ->with('error', 'Pilih minimal satu produk untuk checkout.');
        }

        $cart = session('cart', []);
        $checkoutItems = [];
        $total = 0;

        foreach ($selectedIds as $id) {
            if (!isset($cart[$id])) continue;

            $item = $cart[$id];
            $subtotal = $item['price'] * $item['qty'];

            $checkoutItems[$id] = [
                'id'       => $id,
                'name'     => $item['name'],
                'price'    => $item['price'],
                'qty'      => $item['qty'],
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        // simpan ke session
        session([
            'checkout_items' => $checkoutItems,
            'checkout_total' => $total,
        ]);

        return redirect()->route('checkout.index');
    }
}
