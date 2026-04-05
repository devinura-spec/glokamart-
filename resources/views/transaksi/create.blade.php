@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-gray-100 py-16">

<div class="max-w-6xl mx-auto px-6">

<!-- HEADER -->
<div class="text-center mb-14">
<h2 class="text-4xl font-bold text-gray-800">
🧾 Konfirmasi Transaksi
</h2>

<p class="text-gray-500 mt-3">
Periksa kembali detail penyewaan sebelum melakukan pembayaran
</p>
</div>


<div class="grid lg:grid-cols-2 gap-10">


<!-- ================= -->
<!-- DETAIL PRODUK -->
<!-- ================= -->

<div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

@if($product->image)
<div class="relative">

<img src="{{ asset('storage/'.$product->image) }}" 
class="w-full h-56 object-cover">

<div class="absolute top-4 right-4 bg-black/70 text-white px-4 py-2 rounded-xl text-sm backdrop-blur">

@if($product->rent_type == 'hour')
📷 Rp {{ number_format($product->price,0,',','.') }} / Jam
@else
📷 Rp {{ number_format($product->price,0,',','.') }} / Hari
@endif

</div>

</div>
@endif


<div class="p-8">

<h3 class="text-2xl font-bold text-gray-800 mb-3">
{{ $product->name }}
</h3>

@if($product->rent_type == 'hour')
<p class="text-gray-500 text-sm">Harga Sewa Kamera Per Jam</p>
@else
<p class="text-gray-500 text-sm">Harga Sewa Kamera Per Hari</p>
@endif

<p class="text-4xl font-bold text-blue-600 mt-2">
Rp {{ number_format($product->price,0,',','.') }}
</p>

<div class="mt-6 border-t pt-4 text-sm text-gray-500">

Tipe sewa :
<strong class="text-gray-700">
{{ $product->rent_type == 'hour' ? 'Per Jam' : 'Per Hari' }}
</strong>

</div>

</div>
</div>


<!-- ================= -->
<!-- FORM TRANSAKSI -->
<!-- ================= -->

<div class="bg-white rounded-3xl shadow-2xl p-8">

<form action="{{ route('transaksi.store') }}" method="POST">
@csrf

<input type="hidden" name="product_id" value="{{ $product->id }}">


@if($product->rent_type == 'hour')

<div class="grid md:grid-cols-2 gap-5 mb-6">

<div>
<label class="block text-sm font-semibold text-gray-700 mb-2">
Waktu Mulai
</label>

<input type="datetime-local"
name="start_time"
id="start_time"
class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-400 outline-none">
</div>


<div>
<label class="block text-sm font-semibold text-gray-700 mb-2">
Waktu Selesai
</label>

<input type="datetime-local"
name="end_time"
id="end_time"
class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-400 outline-none">
</div>

</div>

@else

<div class="grid md:grid-cols-2 gap-5 mb-6">

<div>
<label class="block text-sm font-semibold text-gray-700 mb-2">
Waktu Mulai
</label>

<input type="datetime-local"
name="start_date"
id="start_date"
class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-400 outline-none">
</div>

<div>
<label class="block text-sm font-semibold text-gray-700 mb-2">
Waktu Selesai
</label>

<input type="datetime-local"
name="end_date"
id="end_date"
class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-400 outline-none">
</div>

</div>

@endif


<!-- DURASI -->

<!-- DURASI PENYEWAAN -->

<div class="mb-5">

<label class="block text-sm font-semibold text-gray-700 mb-2">
Durasi Penyewaan
</label>

<input 
type="text"
id="duration"
name="duration_display"
class="w-full border rounded-xl px-4 py-3 bg-gray-100 text-gray-700 font-semibold"
placeholder="Durasi akan otomatis dihitung"
readonly>

</div>

<!-- TOTAL -->

<div class="mb-7">

<label class="block text-sm font-semibold text-gray-700 mb-2">
Total Pembayaran
</label>

<input type="text"
id="total_display"
class="w-full border rounded-xl px-4 py-3 bg-blue-50 font-bold text-blue-600 text-lg"
readonly>

<input type="hidden"
name="total_price"
id="total">

</div>



<!-- METODE PEMBAYARAN -->

<div class="mb-7">

<label class="block font-semibold text-gray-700 mb-4">
Metode Pembayaran
</label>

<div class="space-y-3">

<label class="payment flex gap-3 border-2 rounded-2xl p-4 cursor-pointer hover:border-blue-400 transition">

<input type="radio" name="payment_method" value="qris">

<div>
<p class="font-semibold">QRIS</p>
<p class="text-sm text-gray-500">
GoPay, DANA, OVO, ShopeePay
</p>
</div>

</label>


<label class="payment flex gap-3 border-2 rounded-2xl p-4 cursor-pointer hover:border-blue-400 transition">

<input type="radio" name="payment_method" value="transfer">

<div>
<p class="font-semibold">Transfer Bank</p>
<p class="text-sm text-gray-500">
BCA • BRI • Mandiri
</p>
</div>

</label>


<label class="payment flex gap-3 border-2 rounded-2xl p-4 cursor-pointer hover:border-blue-400 transition">

<input type="radio" name="payment_method" value="cod">

<div>
<p class="font-semibold">Bayar di Tempat</p>
<p class="text-sm text-gray-500">
Cash / COD
</p>
</div>

</label>

</div>
</div>



<button type="submit"
class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:scale-105 transition transform text-white py-4 rounded-2xl font-semibold shadow-lg">
✅ Konfirmasi Transaksi
</button>

</form>
</div>

</div>
</div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

let price = {{ $product->price }};

function hitung(){

let startInput = document.getElementById("start_time") || document.getElementById("start_date");
let endInput = document.getElementById("end_time") || document.getElementById("end_date");

if(!startInput || !endInput) return;

let startVal = startInput.value;
let endVal = endInput.value;

if(!startVal || !endVal) return;

let start = new Date(startVal);
let end = new Date(endVal);

let diffMs = end - start;

if(diffMs <= 0) return;

let diffHours = diffMs / (1000 * 60 * 60);
let diffDays = diffMs / (1000 * 60 * 60 * 24);

let duration;
let label;

if(diffHours < 24){
duration = Math.ceil(diffHours);
label = "Jam";
}else{
duration = Math.ceil(diffDays);
label = "Hari";
}

document.getElementById("duration").value = duration + " " + label;

let total = duration * price;

document.getElementById("total_display").value =
"Rp " + total.toLocaleString("id-ID");

document.getElementById("total").value = total;

}

// ambil semua input tanggal
["start_date","end_date","start_date","end_date"].forEach(function(id){

let el = document.getElementById(id);

if(el){
el.addEventListener("input", hitung);
el.addEventListener("change", hitung);
}

});

});

</script>

@endsection