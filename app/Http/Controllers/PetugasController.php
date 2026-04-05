<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function dashboard()
    {
        // ================= DATA TERBARU =================
         $orders = Transaksi::with(['user','product'])
                    ->latest()
                    ->take(5)
                    ->get();
        // ================= STATISTIK =================
        $total = Transaksi::count();
        $pending = Transaksi::where('payment_status', 'pending')->count();
        $today = Transaksi::whereDate('created_at', today())->count();
        $selesai = Transaksi::where('payment_status', 'selesai')->count();
        $batal = Transaksi::where('payment_status', 'batal')->count();

        // ================= PROGRESS =================
        $progress = $total > 0 ? round(($selesai / $total) * 100) : 0;

        // ================= TOP USER =================
        $topUser = Transaksi::selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user')
            ->first();

        // ================= CHART =================
        $chart = Transaksi::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('petugas.dashboard', compact(
            'orders',
            'total',
            'pending',
            'today',
            'selesai',
            'batal',
            'progress',
            'topUser',
            'chart'
        ));
    }

    public function orders()
    {
        $orders = Transaksi::with('user')->latest()->get();

        return view('petugas.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
{
    // 1️⃣ Validasi input
    $request->validate([
        'status' => 'required|in:pending,confirmed,diambil,dikembalikan,batal'
    ]);

    // 2️⃣ Update payment_status → INI TEMPATNYA
    Transaksi::where('id', $id)->update([
        'payment_status' => $request->status
    ]);

    // 3️⃣ Redirect balik dengan pesan sukses
    return redirect()->back()->with('success', 'Status transaksi berhasil diupdate!');
}


public function laporan(Request $request)
{
    $query = Transaksi::with(['user','product']);

    if ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    if ($request->status && $request->status != 'Semua') {
        if ($request->status == 'selesai') {
            $query->whereIn('payment_status', ['confirmed','dikembalikan']);
        } else {
            $query->where('payment_status', $request->status);
        }
    }

    $data = $query->latest()->get();

    $total = $data->count();
    $selesai = $data->whereIn('payment_status',['confirmed','dikembalikan'])->count();
    $pending = $data->where('payment_status','pending')->count();
    $batal   = $data->where('payment_status','batal')->count();

    $pendapatan = $data
        ->whereIn('payment_status',['confirmed','dikembalikan'])
        ->sum('total_price');

    return view('petugas.laporan', compact(
        'data','total','selesai','pending','batal','pendapatan'
    ));
}
}