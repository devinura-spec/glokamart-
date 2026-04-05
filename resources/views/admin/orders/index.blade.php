@extends('layouts.app')

@section('content')

<div class="p-10 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8 bg-blue-900 rounded-xl p-6 shadow-lg text-white">
        <div>
            <h1 class="text-3xl font-bold flex items-center gap-2">
                📦 Orders Admin
            </h1>
            <p class="text-blue-200 text-sm mt-1">
                Daftar semua pesanan yang dilakukan oleh user.
            </p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mt-6">
        <table class="w-full text-sm border-collapse">
            <thead class="text-blue-900 uppercase text-xs tracking-wider">
                <tr class="bg-gradient-to-r from-blue-400 via-blue-200 to-blue-400 shadow-inner">
                    <th class="p-4 text-left">User</th>
                    <th class="p-4 text-left">Produk</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-left">Total</th>
                    <th class="p-4 text-left">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($orders as $order)
                <tr class="transition transform hover:scale-101 hover:bg-blue-50">
                    {{-- USER --}}
                    <td class="p-4 font-semibold text-gray-700">
                        {{ $order->user->name ?? 'User tidak ditemukan' }}
                    </td>

                    {{-- PRODUK --}}
                    <td class="p-4 text-gray-600">
                        <div class="bg-blue-50 px-2 py-1 rounded-lg inline-block">
                            {{ $order->product->name ?? 'Produk tidak ditemukan' }}
                        </div>
                    </td>

                    {{-- TANGGAL --}}
                    <td class="p-4 text-gray-500">
                        {{ $order->created_at->format('d M Y') }}
                    </td>

                    {{-- TOTAL --}}
                    <td class="p-4 font-bold text-blue-900">
                        Rp {{ number_format($order->total_price ?? 0,0,',','.') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="p-4">
                        @if($order->payment_status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Pending
                            </span>
                        @elseif(in_array($order->payment_status, ['confirmed','diambil']))
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        @elseif($order->payment_status == 'dikembalikan')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Dikembalikan
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Batal
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-10 text-gray-400">
                        📭 Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection