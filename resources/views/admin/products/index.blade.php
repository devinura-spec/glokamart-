@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 overflow-x-auto">

    <h1 class="text-3xl font-bold mb-6">🛍 Produk</h1>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol Tambah Produk --}}
    <a href="{{ route('admin.products.create') }}"
       class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        ➕ Tambah Produk
    </a>

    {{-- Table Produk --}}
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">ID</th>
                <th class="border p-2">Gambar</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Kategori</th>
                <th class="border p-2">Harga</th>
                <th class="border p-2">Stok</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="border p-2">{{ $product->id }}</td>
                <td class="border p-2">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="h-16 w-16 object-cover rounded">
                    @else
                        <span class="text-gray-400">Tidak ada</span>
                    @endif
                </td>
                <td class="border p-2">{{ $product->name }}</td>
                <td class="border p-2">{{ $product->category->name ?? '-' }}</td>
                <td class="border p-2">
                    Rp {{ number_format($product->price,0,',','.') }}
                </td>
                <td class="border p-2">{{ $product->stock ?? '-' }}</td>
                <td class="border p-2 flex gap-2">
                    

                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Edit
                    </a>

                    <form action="{{ route('admin.products.destroy', $product) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center p-4 text-gray-500">
                    Belum ada produk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
