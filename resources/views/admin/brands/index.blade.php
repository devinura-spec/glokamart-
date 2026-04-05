@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6">


<div class="mb-8">
    <h2 class="text-3xl font-bold text-blue-900">Kelola Brand Produk</h2>
    <p class="text-gray-500">Tambahkan dan kelola brand berdasarkan kategori produk</p>
</div>

{{-- Notifikasi sukses --}}
@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-4 shadow-sm">
    {{ session('success') }}
</div>
@endif

{{-- Notifikasi error --}}
@if($errors->any())
<div class="bg-red-100 border border-red-200 text-red-700 px-5 py-3 rounded-2xl mb-4 shadow-sm">
    <ul>
        @foreach($errors->all() as $error)
        <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{{-- FORM TAMBAH BRAND --}}
<div class="bg-white rounded-3xl shadow-lg mb-10 border border-gray-100">

    <div class="bg-blue-900 text-white px-6 py-4 rounded-t-3xl font-semibold text-lg">
        Tambah Brand Baru
    </div>

    <div class="p-6">

        <form action="{{ route('admin.brands.store') }}" method="POST">
            @csrf

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Pilih Kategori
                    </label>

                    <select name="category_id"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition"
                    required>

                        <option value="">-- Pilih Kategori --</option>

                        @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                        </option>
                        @endforeach

                    </select>
                </div>


                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Nama Brand
                    </label>

                    <input type="text"
                    name="name"
                    placeholder="Contoh: Canon, Sony"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition"
                    required>
                </div>

            </div>

            <button type="submit"
            class="mt-5 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-6 py-2 rounded-full shadow-md hover:scale-105 transition">
                + Tambah Brand
            </button>

        </form>

    </div>
</div>



{{-- LIST BRAND PER KATEGORI --}}
@foreach($categories as $category)

<div class="bg-white rounded-3xl shadow-md mb-6 border border-gray-100 overflow-hidden">

    <div class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center">

        <span class="font-semibold text-lg">
            {{ $category->name }}
        </span>

        <span class="bg-yellow-400 text-gray-900 text-sm px-4 py-1 rounded-full font-semibold">
            {{ $category->brands->count() }} Brand
        </span>

    </div>


    <div class="p-5">

        @if($category->brands->count() > 0)

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">

            @foreach($category->brands as $brand)

            <div class="flex justify-between items-center px-4 py-3 rounded-2xl shadow-sm transition
            bg-blue-50 border border-blue-100
            hover:scale-[1.02] hover:shadow-md

            [&:nth-child(2)]:bg-sky-50 [&:nth-child(2)]:border-sky-100
            [&:nth-child(3)]:bg-indigo-50 [&:nth-child(3)]:border-indigo-100
            [&:nth-child(4)]:bg-violet-50 [&:nth-child(4)]:border-violet-100
            [&:nth-child(5)]:bg-blue-100 [&:nth-child(5)]:border-blue-200
            ">

                <span class="font-medium text-gray-700">
                    {{ $brand->name }}
                </span>

                <form action="{{ route('admin.brands.destroy', $brand->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin hapus brand ini?');">

                    @csrf
                    @method('DELETE')

                    <button class="text-red-500 hover:text-red-700 text-sm font-semibold">
                        Hapus
                    </button>

                </form>

            </div>

            @endforeach

        </div>

        @else

        <p class="text-gray-500 text-sm">
            Belum ada brand pada kategori ini
        </p>

        @endif

    </div>

</div>

@endforeach

</div>

@endsection
