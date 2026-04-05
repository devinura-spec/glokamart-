@extends('layouts.app')

@section('content')
<div x-data="productPage()" class="p-4 bg-blue-50 min-h-screen">

    <!-- Header + Keranjang -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-blue-700">Produk Elektronik</h1>

        <!-- Keranjang Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="relative bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-full font-bold flex items-center gap-2 shadow-md">
                🛒 Keranjang 
                <span class="bg-white text-yellow-600 px-2 py-0.5 rounded-full text-sm font-semibold" x-text="cart.length"></span>
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-72 bg-blue-50 shadow-lg rounded-lg p-3 z-50">
                <template x-if="cart.length === 0">
                    <p class="text-gray-500 text-sm">Keranjang kosong</p>
                </template>
                <template x-for="item in cart" :key="item.id">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <img :src="item.image" alt="" class="w-10 h-10 object-cover rounded">
                            <div>
                                <p class="font-semibold text-sm" x-text="item.name"></p>
                                <p class="text-xs text-gray-700">Qty: <span x-text="item.qty"></span></p>
                            </div>
                        </div>
                        <p class="font-bold text-sm text-blue-700" x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')"></p>
                    </div>
                </template>
                <div class="mt-2">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded shadow-md" @click="checkoutCart()">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Produk -->
    <div x-data="shopeeFilter()" class="p-4">


  <div class="flex items-center justify-between mb-4">
 
    <div class="flex overflow-x-auto gap-3 scrollbar-hide">
      <button 
        @click="toggleFilter('promo')"
        :class="filters.includes('promo') ? 'bg-yellow-200 text-yellow-800 shadow-lg' : 'bg-yellow-100 text-yellow-700'"
        class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-semibold shadow-md hover:scale-105 hover:shadow-xl transform transition duration-300">
        🔥 Promo
      </button>

      <button 
        @click="toggleFilter('terlaris')"
        :class="filters.includes('terlaris') ? 'bg-blue-200 text-blue-800 shadow-lg' : 'bg-blue-100 text-blue-700'"
        class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-semibold shadow-md hover:scale-105 hover:shadow-xl transform transition duration-300">
        ⭐ Terlaris
      </button>

      <button 
        @click="toggleFilter('gratisOngkir')"
        :class="filters.includes('gratisOngkir') ? 'bg-green-200 text-green-800 shadow-lg' : 'bg-green-100 text-green-700'"
        class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-semibold shadow-md hover:scale-105 hover:shadow-xl transform transition duration-300">
        🚚 Gratis Ongkir
      </button>
    </div>

    <!-- Sort Dropdown -->
    <div class="relative ml-2">
      <select x-model="sortBy" @change="sortProducts" 
              class="appearance-none text-sm border border-gray-300 rounded-lg px-4 py-2 bg-white text-gray-800 shadow-md hover:shadow-lg transition duration-300 pr-8">
        <option value="default">Urutkan</option>
        <option value="termurah">Termurah</option>
        <option value="terlaris">Terlaris</option>
      </select>
      <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
    </div>
  </div>

    <!-- Daftar Produk -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <template x-for="product in filteredProducts()" :key="product.id">
            <div class="bg-blue-100 rounded-lg shadow-md p-4 flex flex-col hover:shadow-xl transition duration-300">
                <img :src="product.image" :alt="product.name" class="w-full h-36 object-cover mb-2 rounded">
                <h3 class="font-semibold text-lg mb-1 text-blue-800" x-text="product.name"></h3>
                <p class="text-blue-700 text-sm mb-1" x-text="product.desc"></p>
                <p class="text-blue-900 font-bold mb-2" x-text="'Rp ' + product.price.toLocaleString('id-ID')"></p>
                
                <div class="flex gap-1 flex-wrap mb-2">
                    <template x-if="product.promo">
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">🔥 Promo</span>
                    </template>
                    <template x-if="product.terlaris">
                        <span class="text-xs px-2 py-1 bg-blue-200 text-blue-900 rounded-full">⭐ Terlaris</span>
                    </template>
                    <template x-if="product.gratisOngkir">
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">🚚 Gratis Ongkir</span>
                    </template>
                </div>

                <button 
                    class="mt-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded shadow-md transform transition duration-300 hover:scale-105"
                    @click="addToCart(product)">
                    🛒 Tambah ke Keranjang
                </button>
            </div>
        </template>
    </div>

</div>

<script>
function productPage() {
    return {
        cart: JSON.parse(localStorage.getItem('cart') || '[]'),
        filters: [],
        sortBy: 'default',
        products: [
            {id: 1, name: 'TV LED 42 inch', desc: 'Layar jernih dan hemat listrik', price: 2500000, image: 'https://via.placeholder.com/200', promo: true, terlaris: false, gratisOngkir: true},
            {id: 2, name: 'Laptop Gaming', desc: 'Core i7, RAM 16GB, SSD 512GB', price: 7500000, image: 'https://via.placeholder.com/200', promo: false, terlaris: true, gratisOngkir: false},
            {id: 3, name: 'Headphone Wireless', desc: 'Suara jernih, bass mantap', price: 350000, image: 'https://via.placeholder.com/200', promo: true, terlaris: true, gratisOngkir: false},
        ],
        addToCart(product) {
            let existing = this.cart.find(item => item.id === product.id);
            if(existing) existing.qty += 1;
            else this.cart.push({...product, qty:1});
            localStorage.setItem('cart', JSON.stringify(this.cart));
            alert(product.name + ' berhasil ditambahkan ke keranjang!');
        },
        checkoutCart() {
            alert('Total item: ' + this.cart.length + '. Lanjut ke checkout!');
        },
        toggleFilter(filter) {
            if(this.filters.includes(filter)) this.filters = this.filters.filter(f=>f!==filter);
            else this.filters.push(filter);
        },
        filteredProducts() {
            let result = this.products;
            if(this.filters.length>0) result = result.filter(p=>this.filters.every(f=>p[f]));
            if(this.sortBy==='termurah') result = result.slice().sort((a,b)=>a.price-b.price);
            if(this.sortBy==='terlaris') result = result.slice().sort((a,b)=> (b.terlaris - a.terlaris) || (a.price-b.price));
            return result;
        },
        sortProducts() { this.filteredProducts(); }
    }
}
</script>

<style>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
