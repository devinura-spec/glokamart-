<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class OrderController extends Controller
{
    // SIMPAN PESANAN
    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung total
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        // 1. SIMPAN ORDER UTAMA
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // 2. SIMPAN DETAIL ORDER (ORDER ITEMS)
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,   // relasi ke orders
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['qty'],
            ]);
        }

        // 3. HAPUS KERANJANG
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    // TAMPILKAN DETAIL PESANAN
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

   public function index() // untuk petugas
{
    // Ambil semua pesanan terbaru
    $orders = Order::latest()->paginate(10);

    // Tampilkan ke blade khusus petugas
    return view('petugas.orders.index', compact('orders'));
}

public function adminOrders()
{
    $orders = Order::with('user', 'product')->orderBy('created_at', 'desc')->get();

    return view('admin.orders.index', compact('orders'));
}

public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Status berhasil diperbarui');
}


}
