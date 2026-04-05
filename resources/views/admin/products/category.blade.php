<div class="group bg-white rounded-3xl 
            shadow-lg hover:shadow-2xl 
            hover:-translate-y-2 
            transition-all duration-500 
            overflow-hidden border border-gray-100">

    <!-- FOTO (tetap h-48) -->
    @if($product->image)
        <div class="overflow-hidden relative">
            <img src="{{ asset('storage/'.$product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-48 object-cover 
                        transition duration-700 
                        group-hover:scale-110">

            <!-- Overlay halus -->
            <div class="absolute inset-0 bg-black/0 
                        group-hover:bg-black/10 
                        transition duration-500"></div>
        </div>
    @else
        <div class="w-full h-48 bg-gradient-to-br 
                    from-gray-100 to-gray-200 
                    flex items-center justify-center text-gray-400">
            No Image
        </div>
    @endif

    <div class="p-5 space-y-3">

        <!-- Nama -->
        <h2 class="text-lg font-semibold text-gray-800 
                   group-hover:text-blue-700 
                   transition">
            {{ $product->name }}
        </h2>

        <!-- Harga -->
        <div>
            <p class="text-blue-700 font-bold text-xl tracking-tight">
                Rp {{ number_format($product->price,0,',','.') }}
                <span class="text-sm text-gray-400 font-normal">/ hari</span>
            </p>

            @if($product->price_hour)
                <p class="text-sm text-gray-500 mt-1">
                    Rp {{ number_format($product->price_hour,0,',','.') }} / jam
                </p>
            @endif
        </div>

        <!-- Stock -->
        <p class="text-sm">
            Stok:
            <span class="font-semibold 
                {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                {{ $product->stock > 0 ? 'Tersedia '.$product->stock.' unit' : 'Stok Habis' }}
            </span>
        </p>

        <!-- ACTION -->
        <div class="flex gap-2 pt-2">

            <!-- Keranjang -->
            <form action="{{ route('cart.add',$product->id) }}" method="POST" class="w-1/5">
                @csrf
                <button class="w-full bg-gray-100 hover:bg-gray-200 
                               py-2 rounded-xl 
                               transition text-sm">
                    🛒
                </button>
            </form>

            <!-- Detail -->
            <a href="{{ route('products.show', $product->id) }}"
               class="w-2/5 text-center border border-gray-200 
                      py-2 rounded-xl text-sm 
                      hover:bg-gray-50 
                      hover:border-blue-500 
                      transition">
                Detail
            </a>

            <!-- Pinjam -->
            @if($product->stock > 0)
                <a href="{{ route('transaksi.create', $product->id) }}"
                   class="w-2/5 text-center bg-gradient-to-r 
                          from-blue-600 to-blue-700
                          text-white py-2 rounded-xl 
                          font-semibold 
                          hover:from-blue-700 
                          hover:to-blue-800
                          transition">
                    Pinjam
                </a>
            @else
                <button disabled
                    class="w-2/5 bg-gray-300 text-gray-500 
                           py-2 rounded-xl font-semibold cursor-not-allowed">
                    Habis
                </button>
            @endif

        </div>

    </div>
</div>