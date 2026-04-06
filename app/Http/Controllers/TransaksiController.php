<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaksi;
use App\Models\Order; 
use Illuminate\Http\Request;

class TransaksiController extends Controller
{


    // ==========================
    // FORM TRANSAKSI
    // ==========================
    public function create($id)
    {
        $product = Product::findOrFail($id);
        return view('transaksi.create', compact('product'));
    }

    // ==========================
    // SIMPAN TRANSAKSI + QR CODE
    // ==========================
    public function store(Request $request)
    {
        // 1️⃣ Validasi input
  $request->validate([
    'product_id'     => 'required|exists:products,id',
    'total_price'    => 'required|numeric|min:1',
    'payment_method' => 'required|in:qris,transfer,cod',
]);

        // 2️⃣ Ambil tanggal dari form (opsional)
        $start = $request->start_date ?? $request->start_time ?? null;
        $end   = $request->end_date ?? $request->end_time ?? null;

        // 3️⃣ Generate invoice
        $invoice = 'INV-' . date('Ymd') . '-' . rand(1000,9999);

        // 4️⃣ Tentukan status default
        $payment_status = 'pending'; // ini bisa dibaca oleh admin/petugas

       $transaksi = Transaksi::create([
    'user_id' => auth()->id(), // 🔥 WAJIB
    'product_id' => $request->product_id,
    'invoice_code' => $invoice,
    'start_date' => $start,
    'end_date' => $end,
    'total_price' => $request->total_price,
    'payment_method' => $request->payment_method,
    'payment_status' => $payment_status,
]);



        // 7️⃣ Redirect ke invoice
        return redirect()->route('transaksi.invoice', $transaksi->id);
    }

    // ==========================
    // HALAMAN INVOICE
    // ==========================
    public function invoice($id)
    {
        $transaksi = Transaksi::with('product','user')->findOrFail($id);
        return view('transaksi.invoice', compact('transaksi'));
    }


     // ==========================
    // SCAN INVOICE / QR CODE
    // ==========================
    public function scan($kode)
    {
        $trx = Transaksi::with('product')->where('invoice_code', $kode)->first();

        if (!$trx) {
            return response("Data tidak ditemukan", 404);
        }

        return view('struk', compact('trx'));
    }
    


    
}