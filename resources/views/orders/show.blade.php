@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto py-8">

    <h2 class="text-xl font-bold mb-4">Detail Pesanan #{{ $order->id }}</h2>

    <div class="p-4 border rounded">
        <p><strong>Produk:</strong> {{ $order->product_name }}</p>
        <p><strong>Total:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at }}</p>
    </div>

</div>
@endsection
