<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ambil jumlah per status sesuai DB
        $pending = Transaksi::where('payment_status','pending')->count();
        $confirmed = Transaksi::where('payment_status','confirmed')->count();
        $diambil = Transaksi::where('payment_status','diambil')->count();
        $dikembalikan = Transaksi::where('payment_status','dikembalikan')->count();
        $batal = Transaksi::where('payment_status','batal')->count();

        $paymentStatus = [
            'Pending' => $pending,
            'Confirmed' => $confirmed,
            'Diambil' => $diambil,
            'Dikembalikan' => $dikembalikan,
            'Batal' => $batal,
        ];

        // Grafik pesanan per hari
        $orders = Transaksi::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $labels = $orders->pluck('date');
        $data = $orders->pluck('total');

        return view('admin.dashboard', compact(
            'paymentStatus',
            'labels',
            'data'
        ));
    }
}