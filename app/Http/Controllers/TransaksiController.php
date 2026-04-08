<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaksi;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    // VALIDASI DASAR
    $request->validate([
        'product_id'     => 'required|exists:products,id',
        'total_price'    => 'required|numeric|min:1',
        'payment_method' => 'required|in:qris,transfer,cod',
    ]);

    // AMBIL DATA PRODUCT
    $product = \App\Models\Product::findOrFail($request->product_id);

    // VALIDASI TANGGAL
    if ($product->rent_type == 'hour') {

        $request->validate([
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        $start = $request->start_time;
        $end   = $request->end_time;

    } else {

        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;
    }

    // 🔥 TAMBAHKAN INI (WAJIB)
    $invoice = 'INV-' . date('Ymd') . '-' . rand(1000,9999);

    $transaksi = Transaksi::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id,
        'invoice_code' => $invoice,
        'start_date' => $start,
        'end_date' => $end,
        'total_price' => $request->total_price,
        'payment_method' => $request->payment_method,
        'payment_status' => 'pending',
    ]);

    // BARU REDIRECT
    return redirect()->route('transaksi.invoice', $transaksi->invoice_code);
}

public function invoice($invoice_code)
{
    $transaksi = Transaksi::with('product','user')
        ->where('invoice_code', $invoice_code)
        ->firstOrFail();

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