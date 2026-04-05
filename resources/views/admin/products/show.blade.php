@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="grid md:grid-cols-2 gap-10">

        <div>
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="w-full rounded-2xl shadow-xl object-cover">
        </div>

        <div>
            <h1 class="text-3xl font-bold mb-4">
                {{ $product->name }}
            </h1>

            <p class="text-2xl font-bold text-blue-600 mb-6">
                Rp {{ number_format($product->price) }} / 24 jam
            </p>

            <div class="text-gray-600 mb-6 leading-relaxed">
                {{ $product->description }}
            </div>

            <a href="{{ route('transaksi.create', $product->id) }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-xl inline-block hover:bg-blue-700 font-semibold">
                Pinjam Sekarang
            </a>

        </div>

    </div>

</div>

@endsection