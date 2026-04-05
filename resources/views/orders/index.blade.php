@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-md border border-gray-100">

    <h1 class="text-2xl font-bold text-blue-900 mb-6 flex items-center gap-2">
        📦 Daftar Pesanan Saya
    </h1>

    {{-- Jika tidak ada pesanan --}}
    @if($orders->isEmpty())
        <div class="text-center text-gray-500 py-12">
            <p class="text-lg">Belum ada pesanan.</p>

            <a href="{{ url('/') }}"
               class="mt-4 inline-block bg-blue-900 text-white px-5 py-2 rounded-full hover:bg-blue-800 transition">
                Belanja Sekarang
            </a>
        </div>

    @else
        {{-- Jika ada pesanan --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-blue-900 text-white text-sm uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Kode</th>
                        <th class="px-6 py-3 text-left">Produk</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- Kode Pesanan --}}
                            <td class="px-6 py-3 font-medium">
                                {{ $order->order_code }}
                            </td>

                            {{-- Produk (ambil nama dari JSON items) --}}
                            <td class="px-6 py-3">
                                @php
                                    $items = json_decode($order->items, true);
                                @endphp

                                @foreach ($items as $item)
                                    <div>{{ $item['name'] }} (x{{ $item['qty'] }})</div>
                                @endforeach
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-3">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            {{-- Total --}}
                            <td class="px-6 py-3 font-semibold text-gray-800">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-3">
                                @switch($order->status)
                                    @case('pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                            Menunggu Pembayaran
                                        </span>
                                        @break

                                    @case('processing')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                            Diproses
                                        </span>
                                        @break

                                    @case('completed')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                            Selesai
                                        </span>
                                        @break

                                    @default
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                            Dibatalkan
                                        </span>
                                @endswitch
                            </td>

                            {{-- Detail --}}
                            <td class="px-6 py-3">
                                <a href="{{ route('orders.show', $order->id) }}"
                                   class="text-blue-900 font-semibold hover:underline">
                                    Detail
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endif

</div>
@endsection
