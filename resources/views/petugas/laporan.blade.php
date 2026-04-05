@extends('layouts.petugas')

@section('content')

<div class="w-full min-h-screen bg-gray-100 p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📊 Laporan Pesanan</h1>
        <p class="text-gray-500 text-sm">
            Lihat laporan transaksi lengkap per periode
        </p>

        <!-- PERIODE -->
        @if(request('start_date') && request('end_date'))
        <p class="text-xs text-blue-500 mt-2">
            Periode: {{ request('start_date') }} s/d {{ request('end_date') }}
        </p>
        @endif
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded-2xl shadow mb-6 flex flex-col sm:flex-row sm:items-end gap-4">
        <form action="{{ route('petugas.laporan') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full">
            <div>
                <label class="text-sm text-gray-600">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="border rounded px-3 py-2 text-sm w-full">
            </div>
            <div>
                <label class="text-sm text-gray-600">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="border rounded px-3 py-2 text-sm w-full">
            </div>
            <div>
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="border rounded px-3 py-2 text-sm w-full">
                    <option value="">Semua</option>
                    <option value="pending" @selected(request('status')=='pending')>Pending</option>
                    <option value="confirmed" @selected(request('status')=='confirmed')>Confirmed</option>
                    <option value="diambil" @selected(request('status')=='diambil')>Diambil</option>
                    <option value="dikembalikan" @selected(request('status')=='dikembalikan')>Dikembalikan</option>
                    <option value="batal" @selected(request('status')=='batal')>Batal</option>
                </select>
            </div>
            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- RINGKASAN -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 mb-6">
        <div class="bg-white p-4 rounded-2xl shadow text-center">
            <h3 class="text-sm text-gray-500">Total Transaksi</h3>
            <p class="text-2xl font-bold">{{ $totalOrders ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow text-center">
            <h3 class="text-sm text-gray-500">Transaksi Selesai</h3>
            <p class="text-2xl font-bold">{{ $completedOrders ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow text-center">
            <h3 class="text-sm text-gray-500">Pendapatan</h3>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue ?? 0,0,',','.') }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow text-center">
            <h3 class="text-sm text-gray-500">Transaksi Batal</h3>
            <p class="text-2xl font-bold">{{ $cancelledOrders ?? 0 }}</p>
        </div>

        <!-- 🔥 TAMBAHAN -->
        <div class="bg-white p-4 rounded-2xl shadow text-center">
            <h3 class="text-sm text-gray-500">Total Barang</h3>
            <p class="text-2xl font-bold">{{ $totalItems ?? 0 }}</p>
        </div>
    </div>

    <!-- 🔥 PRODUK TERLARIS -->
    <div class="bg-white p-4 rounded-2xl shadow mb-6">
        <h3 class="font-semibold mb-2">🔥 Produk Terlaris</h3>

        @forelse($topProducts as $product)
            <p class="text-sm">
                {{ $product->name }} → {{ $product->total }}x
            </p>
        @empty
            <p class="text-gray-400 text-sm">Belum ada data</p>
        @endforelse
    </div>

    <!-- 👑 USER PALING AKTIF -->
    <div class="bg-white p-4 rounded-2xl shadow mb-6">
        <h3 class="font-semibold mb-2">👑 User Paling Aktif</h3>

        @if($topUser)
            <p class="text-sm">
                {{ $topUser->name }} → {{ $topUser->total }} transaksi
            </p>
        @else
            <p class="text-gray-400 text-sm">Belum ada data</p>
        @endif
    </div>


   <div class="flex justify-end mb-4 print:hidden">
    <button onclick="window.print()" 
        class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm shadow">
        🖨 Print Laporan
    </button>
</div>

    <!-- TABEL -->
    <div class="bg-white rounded-2xl p-6 shadow">
        <h2 class="font-semibold mb-4">📋 Detail Pesanan</h2>

        @if($orders->count())
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="border-b bg-gray-50 text-gray-600">
                        <th class="px-4 py-2">#ID</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
    <!-- ID -->
    <td class="px-4 py-2">{{ $order->id }}</td>

    <!-- USER -->
    <td class="px-4 py-2">
        {{ $order->user->name ?? '-' }}
    </td>

    <!-- BARANG -->
    <td class="px-4 py-2 text-xs">
        {{ $order->product->name ?? '-' }}
    </td>

    <!-- TANGGAL -->
    <td class="px-4 py-2 text-xs">
        {{ $order->created_at->format('d M Y H:i') }}
    </td>

    <!-- TOTAL -->
    <td class="px-4 py-2">
        Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
    </td>

    <!-- STATUS -->
    <td class="px-4 py-2">
        <span class="text-xs px-2 py-1 rounded-full
            {{ $order->payment_status=='pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
            {{ $order->payment_status=='confirmed' ? 'bg-blue-100 text-blue-600' : '' }}
            {{ $order->payment_status=='diambil' ? 'bg-purple-100 text-purple-600' : '' }}
            {{ $order->payment_status=='dikembalikan' ? 'bg-green-100 text-green-600' : '' }}
            {{ $order->payment_status=='batal' ? 'bg-red-100 text-red-600' : '' }}">
            {{ $order->payment_status }}
        </span>
    </td>
</tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="text-center text-gray-400 py-6">Belum ada pesanan</div>
        @endif
    </div>
<div class="text-xs text-gray-400 mt-6">
    * Data berdasarkan filter periode yang dipilih
</div>
</div>

@endsection