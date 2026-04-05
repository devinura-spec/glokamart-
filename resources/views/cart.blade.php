<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛒 Keranjang Belanja
        </h2>
    </x-slot>

    @php
        $cart = session('cart', []);
        $total = 0;
    @endphp

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- KERANJANG KOSONG --}}
                    @if(empty($cart))
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Keranjang masih kosong. Yuk belanja dulu!
                        </p>

                        <a href="{{ route('home') }}"
                           class="px-5 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow">
                           ← Kembali ke Beranda
                        </a>
                    @else

                    {{-- FORM CHECKOUT PRODUK TERPILIH --}}
                    <form action="{{ route('cart.checkoutSelected') }}" method="POST">
                        @csrf

                        <table class="w-full mb-6">
                            <thead>
                                <tr class="border-b border-gray-300 dark:border-gray-700">
                                    {{-- CHECKBOX PILIH SEMUA --}}
                                    <th class="py-3 text-center">
                                        <input type="checkbox" id="select-all" class="w-5 h-5 text-yellow-500">
                                    </th>
                                    <th class="py-3 text-left">Produk</th>
                                    <th class="py-3 text-center">Harga</th>
                                    <th class="py-3 text-center">Qty</th>
                                    <th class="py-3 text-center">Subtotal</th>
                                    <th class="py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cart as $id => $item)
                                    @php
                                        $subtotal = $item['price'] * $item['qty'];
                                        $total += $subtotal;
                                    @endphp
                                <tr>
                                    <td class="py-3 text-center">
                                        <input type="checkbox"
                                            name="cart_ids[]"
                                            value="{{ $id }}"
                                            class="w-5 h-5 text-yellow-500 item-checkbox"
                                            checked>
                                    </td>

                                    <td class="py-3">{{ $item['name'] }}</td>

                                    <td class="py-3 text-center">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </td>

                                    <td class="py-3 text-center">{{ $item['qty'] }}</td>

                                    <td class="py-3 text-center">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>

                                    <td class="py-3 text-center">
                                        <button
                                            type="submit"
                                            formaction="{{ route('cart.remove', $id) }}"
                                            formmethod="POST"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            @csrf
                                            @method('DELETE')
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- TOTAL + TOMBOL CHECKOUT --}}
                        <div class="flex justify-between items-center p-4 bg-gray-100 rounded-lg mt-4">
                            <h3 class="text-xl font-bold text-gray-900">
                                💰 Total: Rp {{ number_format($total, 0, ',', '.') }}
                            </h3>

                            <button type="submit"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow font-semibold">
                                Checkout Produk Terpilih →
                            </button>
                        </div>

                    </form>

                    {{-- SCRIPT PILIH SEMUA --}}
                    <script>
                        const selectAll = document.getElementById('select-all');
                        const itemCheckboxes = document.querySelectorAll('.item-checkbox');

                        selectAll.addEventListener('change', function() {
                            itemCheckboxes.forEach(cb => cb.checked = selectAll.checked);
                        });
                    </script>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
