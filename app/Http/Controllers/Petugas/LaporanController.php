<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class LaporanController extends Controller
{
    public function index(Request $request)
    {
      $query = Order::with('user','product');
        // Filter tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter status
        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // Ringkasan
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('payment_status','dikembalikan')->count();
        $cancelledOrders = $orders->where('payment_status','batal')->count();
        $totalRevenue = $orders->sum('total_amount');
       $totalItems = $orders->count();


       $topProducts = DB::table('transaksis')
    ->join('products', 'transaksis.product_id', '=', 'products.id')
    ->select('products.name', DB::raw('COUNT(transaksis.id) as total'))
    ->when($request->start_date, fn($q) => $q->whereDate('transaksis.created_at', '>=', $request->start_date))
    ->when($request->end_date, fn($q) => $q->whereDate('transaksis.created_at', '<=', $request->end_date))
    ->groupBy('products.name')
    ->orderByDesc('total')
    ->limit(3)
    ->get();

    $topUser = DB::table('transaksis')
    ->join('users', 'transaksis.user_id', '=', 'users.id')
    ->select('users.name', DB::raw('COUNT(transaksis.id) as total'))
    ->when($request->start_date, fn($q) => $q->whereDate('transaksis.created_at', '>=', $request->start_date))
    ->when($request->end_date, fn($q) => $q->whereDate('transaksis.created_at', '<=', $request->end_date))
    ->groupBy('users.name')
    ->orderByDesc('total')
    ->first();

        return view('petugas.laporan', compact(
            'orders','totalOrders','completedOrders','cancelledOrders','totalRevenue','totalItems','topProducts','topUser'
        ));
    }
}