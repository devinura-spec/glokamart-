<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Checkout
        </h2>
    </x-slot>

    @php
        $cart = session('cart', []);
        $checkoutItems = session('checkout_items', []);
        $subtotal = 0;
        $shipping = 10000; // ongkir dummy
    @endphp

    <div class="max-w-6xl mx-auto py-8">

        @if(empty($checkoutItems))
            <div class="bg-red-100 text-red-700 p-4 rounded-xl">
                Tidak ada produk yang dipilih.  
                <a href="{{ route('cart.index') }}" class="underline font-semibold">
                    Kembali ke Keranjang
                </a>
            </div>
        @else

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- ================= LEFT ================= -->
                <div class="md:col-span-2 space-y-6">

                    <!-- Alamat -->
                    

   <div class="bg-white shadow rounded-xl p-5 border-l-4 border-orange-500">
    <h2 class="font-semibold text-lg mb-3 text-orange-600">
        📍 Data Peminjaman & Alamat
    </h2>

    <!-- Info user lama -->
    <p class="font-semibold">{{ auth()->user()->name }}</p>

    <!-- Input Tanggal Peminjaman -->
    <div class="mb-3">
        <label for="borrow_date">Tanggal Peminjaman</label>
        <input type="date" name="borrow_date" id="borrow_date"
               value="{{ old('borrow_date') }}"
               class="w-full border rounded px-3 py-2" required>
    </div>

    

   

                    <!-- Produk -->
                    <div class="bg-white shadow rounded-xl p-5">
                        <h2 class="font-semibold text-lg mb-4">Produk Dipesan</h2>

                        @foreach ($checkoutItems as $id)
                            @php
                                $item = $cart[$id];
                                $itemSubtotal = $item['price'] * $item['qty'];
                                $subtotal += $itemSubtotal;
                            @endphp

                            <div class="flex justify-between border-b py-3">
                                <div>
                                    <p class="font-semibold">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $item['qty'] }} x Rp {{ number_format($item['price'],0,',','.') }}
                                    </p>
                                </div>
                                <p class="font-semibold">
                                    Rp {{ number_format($itemSubtotal,0,',','.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pembayaran -->
                    <div class="bg-white shadow rounded-xl p-5">
                        <h2 class="font-semibold text-lg mb-3">Metode Pembayaran</h2>

                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:border-orange-500">
                                <input type="radio" name="payment" value="bank" checked>
                                <span>🏦 Transfer Bank</span>
                            </label>

                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:border-orange-500">
                                <input type="radio" name="payment" value="ewallet">
                                <span>📱 E-Wallet (Dana / OVO / Gopay)</span>
                            </label>

                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:border-orange-500">
                                <input type="radio" name="payment" value="cod">
                                <span>🚚 COD (Bayar di Tempat)</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- ================= RIGHT ================= -->
                <div class="space-y-6">

                    <div class="bg-white shadow rounded-xl p-5 sticky top-5">
                        <h2 class="font-semibold text-lg mb-3">
                            Ringkasan Pembayaran
                        </h2>

                        <div class="space-y-2 text-sm border-b pb-3">
                            <div class="flex justify-between">
                                <span>Subtotal Produk</span>
                                <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span>Ongkos Kirim</span>
                                <span>Rp {{ number_format($shipping,0,',','.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between text-lg font-bold mt-3">
                            <span>Total</span>
                            <span class="text-orange-600">
                                Rp {{ number_format($subtotal + $shipping,0,',','.') }}
                            </span>
                        </div>

                        <button
                            type="submit"
                            class="mt-5 w-full bg-orange-500 hover:bg-orange-600
                                   text-white py-3 rounded-xl font-semibold text-lg">
                            Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}"
                           class="block text-center text-sm text-gray-500 mt-3 hover:underline">
                            ← Kembali ke Keranjang
                        </a>
                    </div>

                </div>

            </div>
        </form>
        @endif
    </div>
</x-app-layout>
