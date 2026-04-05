@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Kategori: <span class="text-blue-600">{{ $category->name }}</span>
        </h1>
        <p class="text-gray-500 mt-1">
            Pilih kamera terbaik untuk kebutuhanmu 📸
        </p>
        <div class="w-20 h-1 bg-blue-600 mt-3 rounded"></div>
    </div>


    <!-- GRID PRODUK -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7">

@forelse($products as $product)

<div class="group bg-white rounded-3xl shadow-md 
            hover:shadow-2xl hover:-translate-y-2 
            transition duration-500 overflow-hidden 
            border border-gray-100 flex flex-col">

    <!-- FOTO -->
    <a href="{{ route('products.show',$product->id) }}" class="relative">

        <!-- STATUS STOK -->
        <span class="absolute top-3 right-3 z-10
            text-xs px-3 py-1 rounded-full shadow
            {{ $product->stock > 0 
                ? 'bg-emerald-500 text-white' 
                : 'bg-red-500 text-white' }}">
            {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
        </span>

        <img src="{{ asset('storage/'.$product->image) }}"
             class="w-full aspect-square object-cover
                    group-hover:scale-110 transition duration-700">
    </a>

    <div class="p-4 flex flex-col flex-grow">

        <!-- NAMA -->
        <h2 class="font-semibold text-lg text-gray-800 
                   group-hover:text-blue-600 transition line-clamp-2">
            {{ $product->name }}
        </h2>

        <!-- HARGA -->
        <div class="mt-2">
            <p class="font-bold text-blue-600 text-lg">
                Rp {{ number_format($product->price) }}
                <span class="text-sm text-gray-400 font-normal">/ 24 jam</span>
            </p>

            <p class="text-sm text-gray-500">
                Rp {{ number_format($product->price_hour) }} / jam
            </p>
        </div>

        <!-- STOK -->
        <p class="text-sm mt-2">
            📦 
            <span class="font-semibold 
                {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                {{ $product->stock > 0 
                    ? 'Sisa '.$product->stock.' unit' 
                    : 'Stok habis' }}
            </span>
        </p>

        <!-- BUTTON AREA -->
        <div class="mt-auto pt-4 space-y-3">

          @if($product->stock > 0)
<a href="{{ route('transaksi.create',$product->id) }}"
   class="w-full flex items-center justify-center
          py-3 rounded-2xl font-bold
          backdrop-blur-md
          bg-white/60
          border border-white/40
          shadow-lg
          
          hover:bg-white hover:shadow-xl
          transition duration-300">

     PINJAM SEKARANG
</a>
@endif

            <!-- SECONDARY BUTTON -->
            <div class="flex gap-3">

                <!-- KERANJANG -->
                <a href="{{ route('cart.index') }}"
                   class="w-12 h-12 flex items-center justify-center
                          border-2 border-yellow-400 
                          rounded-full
                          text-yellow-500
                          hover:bg-yellow-400 hover:text-white
                          transition">

                    <!-- ICON CART -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-5 w-5" 
                         fill="none" viewBox="0 0 24 24" 
                         stroke="currentColor">
                        <path stroke-linecap="round" 
                              stroke-linejoin="round" 
                              stroke-width="2" 
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7h13M9 21a1 1 0 102 0 1 1 0 00-2 0zm8 0a1 1 0 102 0 1 1 0 00-2 0z" />
                    </svg>
                </a>

                <!-- DETAIL -->
             <a href="{{ route('products.show',$product->id) }}"
   class="flex-1 text-center border-2 border-gray-300 py-2 rounded-xl font-semibold
          text-gray-700
          bg-blue-100
          hover:bg-blue-200 hover:text-blue-600 hover:border-blue-400
          transition-all duration-300 shadow-sm">
    Detail
</a>
            </div>

        </div>

    </div>
</div>

@empty
<p class="text-gray-500">Tidak ada produk di kategori ini</p>
@endforelse

    </div>

</div>

@endsection