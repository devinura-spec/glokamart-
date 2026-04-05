@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10">

    <h1 class="text-3xl font-bold mb-6">📂 Kategori Produk</h1>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tambah Kategori --}}
    <form action="{{ route('admin.categories.store') }}" method="POST" class="mb-6 flex gap-2">
        @csrf
        <input type="text" name="name" placeholder="Nama kategori baru"
               class="border p-2 rounded w-full" required>
        <button type="submit" class="bg-blue-600 text-white px-4 rounded">Tambah</button>
    </form>

    {{-- List Kategori --}}
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">ID</th>
                <th class="border p-2 text-left">Nama</th>
                <th class="border p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td class="border p-2">{{ $category->id }}</td>
                <td class="border p-2">
                    {{-- Form edit inline --}}
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex gap-2">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ $category->name }}" class="border p-1 rounded flex-1">
                        <button type="submit" class="bg-yellow-500 text-white px-3 rounded">Update</button>
                    </form>
                </td>
                <td class="border p-2">
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 rounded"
                                onclick="return confirm('Yakin ingin hapus kategori ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
