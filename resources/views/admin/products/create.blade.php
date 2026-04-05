@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-3xl font-bold mb-6">🎥 Tambah Produk Rental</h1>

    <!-- Tampilkan Error -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah Produk -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Nama Produk -->
        <div>
            <label class="block mb-1 font-semibold">Nama Produk</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name') }}" required>
        </div>

        <!-- Kategori -->
        <div>
            <label class="block mb-1 font-semibold">Kategori</label>
            <select name="category_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
<!-- Brand -->
<div>
    <label class="block mb-1 font-semibold">Brand</label>
    <select name="brand_id" class="w-full border p-2 rounded" required>
        <option value="">-- Pilih Brand --</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
</div>

        <!-- Harga Harian -->
        <div>
            <label class="block mb-1 font-semibold">Harga Sewa / Hari</label>
            <input type="number" name="price" class="w-full border p-2 rounded" value="{{ old('price') }}" required>
        </div>

        <!-- Harga Per Jam -->
        <div>
            <label class="block mb-1 font-semibold">Harga Sewa / Jam</label>
            <input type="number" name="price_hour" class="w-full border p-2 rounded" value="{{ old('price_hour') }}">
        </div>

        <!-- Jumlah Unit / Stock -->
        <div>
            <label class="block mb-1 font-semibold">Jumlah Unit</label>
            <input type="number" name="stock" class="w-full border p-2 rounded" value="{{ old('stock') }}" required>
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block mb-1 font-semibold">Deskripsi</label>
            <textarea name="description" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
        </div>

        <!-- Peraturan Rental -->
        <div>
            <label class="block mb-1 font-semibold">Peraturan Rental</label>
            <textarea name="rules" class="w-full border p-2 rounded" placeholder="Contoh: Wajib KTP, Denda telat 20rb/jam, dll">{{ old('rules') }}</textarea>
        </div>

        <!-- Upload Gambar -->
        <div>
            <label class="block mb-1 font-semibold">Foto Produk</label>
            <input type="file" name="image" class="w-full border p-2 rounded">
        </div>

        <!-- Tombol Simpan / Batal -->
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Simpan Produk
            </button>

            <a href="{{ route('admin.products.index') }}" class="px-5 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>

    </form>

</div>
@endsection
