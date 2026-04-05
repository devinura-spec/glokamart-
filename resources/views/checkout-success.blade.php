@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto text-center py-20">

    <div class="bg-white p-10 shadow rounded-2xl space-y-4">
        <h1 class="text-2xl font-bold text-green-600">Pesanan Berhasil!</h1>
        <p class="text-gray-600">
            Terima kasih, pesanan kamu sudah dibuat.
        </p>

        <!-- Ringkasan Pesanan -->
        @if(session('last_order'))
            <div class="text-left bg-gray-50 p-4 rounded-xl mt-4">
                <h2 class="font-semibold mb-2">Ringkasan Pesanan:</h2>

                @foreach(session('last_order.items') as $item)
                    <div class="flex justify-between mb-1">
                        <span>{{ $item['name'] }} (x{{ $item['qty'] }})</span>
                        <span>Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}</span>
                    </div>
                @endforeach

                <div class="flex justify-between font-bold mt-2 border-t pt-2">
                    <span>Total</span>
                    <span>Rp {{ number_format(session('last_order.total'),0,',','.') }}</span>
                </div>

                <p class="mt-2 text-sm text-gray-500">Metode Pembayaran: {{ session('last_order.payment') }}</p>
            </div>
        @endif

        <!-- Tombol aksi -->
        <div class="mt-6 flex justify-center gap-3 flex-wrap">
            <a href="/" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl">
                Kembali ke Beranda
            </a>
            <a href="{{ route('orders.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-xl">
                Lihat Pesanan Saya
            </a>
        </div>
    </div>

</div>
@endsection
