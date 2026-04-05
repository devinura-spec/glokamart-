@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    {{-- ===================== --}}
    {{-- DAFTAR PRODUK        --}}
    {{-- ===================== --}}
    @if(empty($cart))
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">
            Keranjang kosong.
        </div>
    @else
        @php $total = 0; @endphp

        @foreach($cart as $item)
            @php
                $subtotal = $item['price'] * $item['qty'];
                $total += $subtotal;
            @endphp

            <div class="bg-white rounded-lg shadow p-4 mb-3 flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $item['name'] }}</p>
                    <p class="text-sm text-gray-600">
                        Rp {{ number_format($item['price'],0,',','.') }}
                        × {{ $item['qty'] }}
                    </p>
                </div>
                <div class="font-bold">
                    Rp {{ number_format($subtotal,0,',','.') }}
                </div>
            </div>
        @endforeach

        {{-- ===================== --}}
        {{-- TOTAL                --}}
        {{-- ===================== --}}
        <div class="flex justify-between items-center bg-gray-100 rounded-lg p-4 mt-4">
            <span class="text-lg font-semibold">Total</span>
            <span class="text-lg font-bold">
                Rp {{ number_format($total,0,',','.') }}
            </span>
        </div>

        {{-- ===================== --}}
        {{-- TOMBOL BUAT PESANAN   --}}
        {{-- ===================== --}}
        <form action="{{ route('checkout.process') }}" method="POST" class="mt-6">
            @csrf
            <button
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold"
            >
                Buat Pesanan
            </button>
        </form>
    @endif

</div>
@endsection
