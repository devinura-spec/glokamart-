<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{

public function index()
{
    // Ambil semua transaksi beserta relasi user dan product
    $orders = Transaksi::with(['user', 'product'])->latest()->get();

    return view('admin.orders.index', compact('orders'));
}
}