@extends('layouts.app')

@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp


@section('content')


<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100 py-14">

<div class="max-w-5xl mx-auto px-6">

<div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

<!-- HEADER -->
<div class="bg-[#17337A] text-white p-8 flex justify-between items-start shadow-lg">
<div>
<h2 class="text-3xl font-bold">
🧾 Invoice Transaksi
</h2>

<p class="text-blue-100 mt-1">
Kode Invoice
</p>

<p class="font-semibold">
{{ $transaksi->invoice_code }}
</p>
</div>

<div>

@if($transaksi->payment_status == 'pending')

<span class="bg-yellow-400 text-yellow-900 px-5 py-2 rounded-full text-sm font-semibold shadow">
⏳ Menunggu Pembayaran
</span>

@else

<span class="bg-green-400 text-green-900 px-5 py-2 rounded-full text-sm font-semibold shadow">
✅ Pembayaran Lunas
</span>

@endif

</div>

</div>


<div class="p-10">

<!-- INFO GRID -->
<div class="grid md:grid-cols-2 gap-8 mb-10">

<div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition">

<h3 class="font-semibold text-blue-700 mb-3">
👤 Informasi Penyewa
</h3>

<p class="text-gray-700 font-medium">
{{ $transaksi->user->name }}
</p>

</div>

<div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition">

<h3 class="font-semibold text-indigo-700 mb-3">
📅 Detail Penyewaan
</h3>

<p class="text-gray-700">
Mulai : {{ $transaksi->start_date }}
</p>

<p class="text-gray-700">
Selesai : {{ $transaksi->end_date }}
</p>

</div>

</div>


<!-- TOTAL -->
<div class="bg-[#F0FDF4] border-2 border-emerald-200 rounded-2xl p-8 mb-10 shadow-sm">

<div class="flex justify-between mb-3">

<span class="text-gray-600">
Metode Pembayaran
</span>

<span class="font-semibold uppercase text-gray-800">
{{ $transaksi->payment_method }}
</span>

</div>

<div class="flex justify-between text-2xl font-bold text-emerald-600">

<span class="text-lg font-semibold text-gray-700">Total Pembayaran</span>

<span class="text-3xl font-bold text-emerald-600">
Rp {{ number_format($transaksi->total_price,0,',','.') }}
</span>

</div>

</div>


<!-- INSTRUKSI PEMBAYARAN -->

@if($transaksi->payment_method == 'qris')

<div class="bg-gradient-to-b from-blue-50 to-white border border-blue-100 rounded-2xl p-8 text-center">

<h3 class="font-semibold text-blue-700 mb-4">
📱 Scan QRIS
</h3>

<img src="{{ asset('images/qris.png') }}" class="mx-auto w-56 shadow-xl rounded-lg">

<p class="text-sm text-gray-500 mt-4">
Setelah pembayaran berhasil, petugas akan mengkonfirmasi pembayaran Anda.
</p>

</div>

@endif



@if($transaksi->payment_method == 'transfer')

<div class="bg-gradient-to-b from-indigo-50 to-white border border-indigo-100 rounded-2xl p-8 text-center">

<h3 class="font-semibold text-indigo-700 mb-4">
🏦 Transfer Bank
</h3>

<div class="bg-white border rounded-xl p-6 inline-block shadow">

<p class="font-semibold text-gray-700">
Bank BCA
</p>

<p class="text-xl font-bold text-gray-800">
1234567890
</p>

<p class="text-sm text-gray-500">
a.n Glokamart
</p>

</div>

</div>

@endif


@if($transaksi->payment_method == 'cod')

<div class="bg-[#FFF7ED] border border-orange-200 rounded-2xl p-8 text-center shadow-sm">

<h3 class="font-semibold text-yellow-700 mb-3">
💰 Pembayaran COD
</h3>

<p class="text-gray-600">
Silakan lakukan pembayaran langsung kepada petugas saat pengambilan barang.
</p>

</div>

@endif


<!-- QR CODE TRANSAKSI -->
<div class="mt-10 text-center">

<h3 class="font-semibold text-blue-700 mb-4">
📷 QR Code Transaksi
</h3>

<div class="inline-block p-4 bg-white border rounded-xl shadow">
{!! QrCode::size(180)->generate(route('transaksi.invoice',$transaksi->id)) !!}
</div>

<p class="text-sm text-gray-500 mt-3">
Tunjukkan QR ini kepada kasir saat pengambilan barang
</p>

</div>
<!-- FOOTER -->
<div class="mt-10 flex justify-between items-center">

<button onclick="history.back()"
class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg text-sm">
⬅ Kembali
</button>

<button onclick="window.print()"
class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm shadow">
🖨 Print Invoice
</button>

</div>
</div>

</div>

</div>

</div>

</div>

@endsection