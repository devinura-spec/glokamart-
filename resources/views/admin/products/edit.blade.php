@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-3xl font-bold mb-6">✏️ Edit Produk</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1">Nama Produk</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name',$product->name) }}" required>
        </div>

        <div>
            <label class="block mb-1">Kategori</label>
            <select name="category_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id',$product->category_id)==$category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">Harga</label>
            <input type="number" name="price" class="w-full border p-2 rounded" value="{{ old('price',$product->price) }}" required>
        </div>

        <div>
            <label class="block mb-1">Stok</label>
            <input type="number" name="stock" class="w-full border p-2 rounded" value="{{ old('stock',$product->stock) }}" required>
        </div>

        <div>
            <label class="block mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border p-2 rounded">{{ old('description',$product->description) }}</textarea>
        </div>

        <div>
            <label class="block mb-1">Gambar Produk</label>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="h-20 w-20 object-cover mb-2 rounded">
            @endif
            <input type="file" name="image" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Update Produk</button>
        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</a>
    </form>

</div>
@endsection
