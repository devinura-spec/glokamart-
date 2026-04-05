@extends('layouts.petugas')

@section('content')

<div class="w-full min-h-screen bg-gray-100 p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📦 Kelola Pesanan</h1>
        <p class="text-gray-500 text-sm">Cocokkan pesanan saat customer datang</p>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl p-6 shadow">

        @if($orders->count())

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">

                <!-- HEADER TABLE -->
                <thead>
                    <tr class="border-b bg-gray-50 text-gray-600">
                        <th class="px-4 py-3">#ID</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Barang</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody>

                    @foreach($orders as $order)
                    <tr class="border-b hover:bg-gray-50">

                        <!-- ID -->
                       <td class="px-4 py-3">
    <div class="font-semibold">
        {{ $order->product->name ?? '-' }}
    </div>

    <div class="text-xs text-gray-400">
        ID Produk: {{ $order->product_id }}
    </div>
</td>

                        <!-- USER -->
                        <td class="px-4 py-3">
                            {{ $order->user->name ?? '-' }}
                        </td>

                        <!-- BARANG -->
                        <td class="px-4 py-3 text-xs">
                            @if($order->items && $order->items->count())
                                @foreach($order->items as $item)
                                    <div>• {{ $item->product->name ?? '-' }}</div>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>

                        <!-- WAKTU SEWA -->
                        <td class="px-4 py-3 text-xs">
                            {{ $order->start_date ?? '-' }} <br>
                            {{ $order->end_date ?? '-' }}
                        </td>

                        <!-- TOTAL -->
                        <td class="px-4 py-3">
                            Rp {{ number_format($order->total_price ?? $order->total_amount ?? 0,0,',','.') }}
                        </td>

                        <!-- STATUS -->
                        <td class="px-4 py-3">
    <span class="text-xs px-3 py-1 rounded-full
        {{ $order->payment_status=='pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
        {{ $order->payment_status=='confirmed' ? 'bg-blue-100 text-blue-600' : '' }}
        {{ $order->payment_status=='diambil' ? 'bg-purple-100 text-purple-600' : '' }}
        {{ $order->payment_status=='dikembalikan' ? 'bg-green-100 text-green-600' : '' }}
        {{ $order->payment_status=='batal' ? 'bg-red-100 text-red-600' : '' }}">
        
        {{ $order->payment_status }}
    </span>
</td>

                        <!-- AKSI -->
                        <td class="px-4 py-3 space-y-1">
   @if($order->payment_status == 'pending')
<form action="{{ route('petugas.orders.updateStatus', $order->id) }}" method="POST">
    @csrf @method('PUT')
    <input type="hidden" name="status" value="confirmed">
    <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs w-full">
        ✔ Konfirmasi
    </button>
</form>
@endif

@if(in_array($order->payment_status, ['confirmed','diambil']))
<form action="{{ route('petugas.transaksi.updateStatus', $order->id) }}" method="POST">
    @csrf @method('PUT')
    <select name="status" class="bg-gray-100 border rounded px-2 py-1 text-xs w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="confirmed" {{ $order->payment_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="diambil" {{ $order->payment_status == 'diambil' ? 'selected' : '' }}>Diambil</option>
        <option value="dikembalikan" {{ $order->payment_status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
        <option value="batal" {{ $order->payment_status == 'batal' ? 'selected' : '' }}>Batal</option>
    </select>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs w-full mt-1">
        Update
    </button>
</form>
@endif
  
</td>
                         

                      

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

        @else
            <div class="text-center text-gray-400 py-10">
                Belum ada pesanan
            </div>
        @endif

    </div>

</div>

@endsection