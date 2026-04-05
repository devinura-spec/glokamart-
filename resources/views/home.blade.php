<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glokamart</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        :root {
            --primary: #0A2472;
            --secondary: #0A2472;
            --accent: #F5C542;
            --light-bg: #F9FAFB;
        }

        body {
            font-family: 'Urbanist', sans-serif;
            background: var(--light-bg);
            margin: 0;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar img {
            height: 45px;
        }

        .search-box {
            display: flex;
            background: #f1f5f9;
            border-radius: 2rem;
            overflow: hidden;
            width: 40%;
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 0.7rem 1rem;
            flex: 1;
            font-size: 0.95rem;
            background: transparent;
        }

        .search-box button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.7rem 1.2rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .search-box button:hover {
            background: var(--secondary);
        }

        .actions a {
            color: var(--primary);
            font-weight: 600;
            margin-left: 1rem;
            text-decoration: none;
        }

        /* Hero */
        .hero {
            position: relative;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-align: center;
            padding: 6rem 1rem 5rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .hero p {
            font-size: 1rem;
            color: #E0E7FF;
        }

        /* Carousel Banner */
        
        .carousel {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 2rem auto;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .carousel-images {
            display: flex;
            width: 300%;
            animation: slide 15s infinite;
        }

        .carousel-images img {
            width: 100%;
            object-fit: cover;
        }

        @keyframes slide {
            0% { transform: translateX(0); }
            33% { transform: translateX(-100%); }
            66% { transform: translateX(-200%); }
            100% { transform: translateX(0); }
        }

        /* Categories */
        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 1.5rem;
            padding: 2rem 1rem;
            max-width: 900px;
            margin: auto;
        }

        .category {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            cursor: pointer;
            text-align: center;
            transition: 0.3s;
        }

        .category:hover {
            transform: translateY(-5px);
            background: var(--accent);
            color: #0A2472;
            font-weight: 700;
        }

        .category svg {
            width: 28px;
            height: 28px;
            margin-bottom: 0.75rem;
            color: var(--primary);
        }

        /* Produk */
        .products {
            padding: 2rem 1.5rem 4rem;
            max-width: 1200px;
            margin: auto;
        }

        .products h3 {
            text-align: center;
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2.5rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--accent);
            color: #0A2472;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 0.25rem 0.6rem;
            border-radius: 1rem;
        }

        .product-info {
            padding: 1rem;
            text-align: center;
        }

        .product-info h4 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .product-info p {
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Footer */
        footer {
            background: #fff;
            border-top: 1px solid #E2E8F0;
            text-align: center;
            padding: 2rem 1rem;
            color: #64748B;
            font-size: 0.9rem;
        }

        footer span {
            color: var(--primary);
            font-weight: 600;
        }

              /* =========================
           SHOPEE-LIKE SEARCH HEADER
           ========================= */
        .gloka-header {
            background: linear-gradient(90deg, #0A2472,  #0A2472);
            padding: 12px 24px;
        }

        .gloka-logo {
            font-size: 24px;
            font-weight: 800;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gloka-search {
            display: flex;
            background: white;
            border-radius: 999px;
            overflow: hidden;
        }
    </style>
</head>
<body>

<!-- Popup Modal Smooth (Near Clicked Item) -->
<div id="popup" onclick="closePopup()" style="
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.25);
  z-index:9999;
  opacity:0;
  pointer-events:none;
  transition:opacity .25s ease;
">
  <div id="popup-box" onclick="event.stopPropagation()" style="
    position:absolute;
    background:white;
    width:280px;
    border-radius:14px;
    padding:18px;
    text-align:left;
    transform:scale(.9) translateY(10px);
    opacity:0;
    transition:all .25s ease;
    box-shadow:0 16px 32px rgba(0,0,0,.25);
  ">
    <h3 id="popup-title" style="font-size:16px; font-weight:700; margin-bottom:6px;"></h3>
    <p id="popup-content" style="font-size:13px; color:#555; margin-bottom:14px; line-height:1.6;"></p>

    <button onclick="closePopup()" style="
      background:#0E2877;
      color:white;
      border:none;
      padding:6px 14px;
      border-radius:8px;
      cursor:pointer;
      font-size:12px;
    ">Tutup</button>
  </div>
</div>

<script>
function openPopup(type, el) {
  const title = document.getElementById('popup-title');
  const content = document.getElementById('popup-content');
  const popup = document.getElementById('popup');
  const box = document.getElementById('popup-box');

if (type === 'tentang') {
  title.innerText = 'Peraturan Sewa';
  content.innerHTML = `
  <div style="max-height:300px; overflow-y:auto; line-height:1.6; font-size:14px; padding-right:8px;">
    
    <p><b>1. Syarat Penyewa</b></p>
    <ul>
      <li>Wajib memberikan jaminan KTP/Kartu Pelajar</li>
      <li>Mengisi data penyewaan dengan benar</li>
      <li>Wajib memiliki akun Glokamart</li>
    </ul>

    <p><b>2. Durasi & Biaya Sewa</b></p>
    <ul>
      <li>Sewa dihitung per hari & jam</li>
      <li>Keterlambatan dikenakan denda per hari</li>
      <li>Diskon berlaku sesuai periode promo</li>
    </ul>

    <p><b>3. Pengambilan & Pengembalian</b></p>
    <ul>
      <li>Barang diambil sesuai jadwal yang disepakati</li>
      <li>Wajib mengecek kondisi barang saat diterima</li>
      <li>Barang dikembalikan lengkap seperti awal</li>
    </ul>

    <p><b>4. Tanggung Jawab Penyewa</b></p>
    <ul>
      <li>Penyewa bertanggung jawab atas kerusakan atau kehilangan</li>
      <li>Dilarang memindah tangankan barang ke pihak lain</li>
      <li>Biaya perbaikan/kehilangan ditanggung penyewa</li>
    </ul>

    <p><b>5. Pembatalan & Perubahan Jadwal</b></p>
    <ul>
      <li>Pembatalan mendadak dapat dikenakan biaya</li>
      <li>Perubahan jadwal harus dikonfirmasi sebelumnya</li>
    </ul>

    <p><b>6. Metode Pembayaran</b></p>
    <ul>
      <li>Bisa melalui pembayaran online atau offline</li>
      <li>Pembayaran online bisa tf bank, Qris </li>
      <li>Pembayaran offline dilakukan saat pengambilan barang</li>
    </ul>

  </div>
  `;

} else if (type === 'produk') {
  title.innerText = 'Tersedia';
  content.innerText = 'Kamera • Lensa • Paket Sewa.';

} else if (type === 'app') {
  title.innerText = 'Cara Sewa';
  content.innerHTML = `
  <div style="max-height:260px; overflow-y:auto; line-height:1.8; font-size:15px; padding-right:8px;">

    <p><b>1.</b> Pilih produk atau tambah ke keranjang</p>
    <p><b>2.</b> Checkout / Pinjam langsung</p>
    <p><b>3.</b> Pilih metode pembayaran (Online / Offline)</p>
    <p><b>4.</b> Dapat kode pesanan / barcode</p>
    <p><b>5.</b> Ambil barang serta menunjukan barcode transaksi ke kasir ruko</p>

  </div>
  `;
}



  const rect = el.getBoundingClientRect();

  popup.style.pointerEvents = 'auto';
  popup.style.opacity = '1';

  box.style.left = (rect.left + window.scrollX) + 'px';
  box.style.top  = (rect.bottom + window.scrollY + 8) + 'px';

  requestAnimationFrame(() => {
    box.style.transform = 'scale(1) translateY(0)';
    box.style.opacity = '1';
  });
}

function closePopup() {
  const popup = document.getElementById('popup');
  const box = document.getElementById('popup-box');

  box.style.transform = 'scale(.9) translateY(10px)';
  box.style.opacity = '0';
  popup.style.opacity = '0';

  setTimeout(() => {
    popup.style.pointerEvents = 'none';
  }, 200);
}
</script>

<!-- Top Bar Electric Blue Solid -->
<div style="background:#0E2877; color:white; font-size:13px; position:relative; z-index:200;">

  <div style="max-width:1280px; margin:auto; display:flex; justify-content:space-between; align-items:center; padding:6px 24px;">
    
    <div style="display:flex; gap:16px;">
      <a href="javascript:void(0)" onclick="openPopup('tentang', this)" style="color:white; text-decoration:none;">Peraturan Sewa</a>
      <a href="javascript:void(0)" onclick="openPopup('produk', this)" style="color:white; text-decoration:none;">Peralatan Sewa</a>
      <a href="javascript:void(0)" onclick="openPopup('app', this)" style="color:white; text-decoration:none;">Cara Sewa</a>
      <span style="opacity:.85;">Ikuti kami di</span>
    </div>

   <div style="display:flex; gap:16px; align-items:center;">
  <a href="#" style="color:white; text-decoration:none;">Notifikasi</a>
  <a href="#" style="color:white; text-decoration:none;">Bantuan</a>
  <a href="#" style="color:white; text-decoration:none;">Bahasa Indonesia</a>
  <span style="opacity:.5;">|</span>

  @auth
<div x-data="{ open: false }" class="relative">
  <button @click="open = !open" style="color:white; font-weight:600;">
    👤 {{ Auth::user()->name }}
    @if(auth()->user()->role_id == 1)
      (ADMIN)
    @endif
  </button>

  <div x-show="open" @click.away="open = false"
       class="w-44 bg-white border border-gray-200 rounded-lg shadow-lg text-sm"
       style="position:absolute; right:0; top:100%; margin-top:6px; z-index:9999; color:#111;">

    @if(auth()->user()->role_id == 1)

  <!-- ADMIN -->
  <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">
    ⚙️ Dashboard Admin
  </a>

@elseif(auth()->user()->role_id == 3)

  <!-- PETUGAS -->
  <a href="{{ route('petugas.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 text-green-600 font-semibold">
    🛠 Dashboard Petugas
  </a>

  <a href="{{ route('petugas.chat.index') }}" class="block px-4 py-2 hover:bg-gray-100">
    💬 Chat Pelanggan
  </a>

@else

  <!-- USER -->
  <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
    👤 Akun Saya
  </a>

  <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100">
    📦 Pesanan Saya
  </a>

  <a href="{{ route('chat.user') }}" 
   class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
    💬 Chat Petugas
</a>

@endif

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
            🚪 Logout
          </button>
        </form>
      </div>
    </div>
  @else
    <a href="{{ route('login') }}" style="color:white; text-decoration:none; font-weight:600;">Login</a>
    <a href="{{ route('register') }}" style="
      color:#0E2877;
      background:white;
      padding:3px 10px;
      border-radius:999px;
      text-decoration:none;
      font-weight:600;
    ">Daftar</a>
  @endauth
</div>



  </div>
</div>




<!-- 🌟 Navbar Glokamart Final -->
<!-- 🌟 Navbar Glokamart Shopee-style Biru Elektrik -->
<nav x-data="shoppeSearch()" class="sticky top-0 z-50 gloka-header">

  <div class="max-w-7xl mx-auto flex items-center gap-6 px-6 py-3">

   <!-- 🛍️ Logo Navbar Final – Sedikit Lebih Besar -->
<a href="{{ url('/') }}" class="flex items-center gap-2 ml-2">
    <!-- Logo -->
    <img src="{{ asset('images/logo.png') }}" alt="Glokamart" class="w-14 h-14 sm:w-29 sm:h-29 object-contain">
    <!-- Nama -->
    <span class="text-white font-semibold text-base sm:text-lg">Glokamart</span>
</a>



</a>


    <!-- 🔍 SEARCH BOX MEMANJANG + REKOMENDASI KECIL -->
    <div class="flex-1 flex flex-col">

      <!-- Search Box -->
      <!-- 🔍 SEARCH BOX -->
<div x-data="searchComponent()" class="flex-1 flex flex-col relative">

  <div class="flex items-center bg-white rounded-full overflow-hidden shadow-md">

    <input
      type="text"
      x-model="searchQuery"
      @input="filterProducts()"
      placeholder="Cari produk terbaik di Glokamart..."
      class="flex-1 px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0A6DD0]"
    >

    <button
      @click="filterProducts()"
      class="bg-[#0A6DD0] hover:bg-[#084FA5] px-5 py-2 text-white font-semibold transition"
    >
      🔍
    </button>

  </div>

  <!-- Dropdown hasil pencarian -->
  <div
    x-show="filteredProducts.length > 0"
    class="absolute top-12 left-0 w-full bg-white rounded-xl shadow-lg mt-2 z-50"
  >

    <template x-for="product in filteredProducts" :key="product">
      <div
        @click="selectProduct(product)"
        class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm"
        x-text="product"
      ></div>
    </template>

  </div>

</div>
    </div>

    <!-- ⚙️ ACTIONS -->
    <div class="flex items-center gap-6">
      <!-- 🛒 <!-- ⚙️ Actions -->
<div class="flex items-center space-x-6">
<!-- 🛒 Keranjang -->
<a href="javascript:void(0)" onclick="toggleCart()" class="relative group">

    <div class="relative">

        <!-- Icon Keranjang -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-7 h-7 text-yellow-500 group-hover:text-yellow-600 transition transform group-hover:scale-110"
             fill="currentColor" viewBox="0 0 24 24">
            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm0-2h13v-2H8.42l-.93-2H20V8H7.21l-.94-2H2v2h2l3.6 7.59L5.25 17A1.003 1.003 0 0 0 6 18h13v-2H7z"/>
        </svg>
      <!-- 👤 USER / LOGIN -->
    </div>

  </div>
</nav>




<!-- Contoh Produk List -->
 <!--div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
  <template x-for="product in filteredProducts()" :key="product.id">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden flex flex-col transition hover:shadow-xl">
      <img :src="product.image || 'https://via.placeholder.com/300x300?text=Produk'" alt="" class="w-full h-48 object-cover">
      <div class="p-4 flex flex-col flex-1">
        <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-md mb-2" x-text="product.name"></h3>
        <p class="text-red-500 font-bold text-lg mb-2" x-text="'Rp ' + product.price.toLocaleString('id-ID')"></p>
        <div class="flex gap-2 flex-wrap mb-3">
          <template x-if="product.promo">
            <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">🔥 Promo</span>
          </template>
          <template x-if="product.terlaris">
            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">⭐ Terlaris</span>
          </template>
          <template x-if="product.gratisOngkir">
            <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">🚚 Gratis Ongkir</span>
          </template>
        </div>
        <button class="mt-auto bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition" 
                @click="addToCart(product)">
          🛒 Tambah ke Keranjang
        </button>
      </div>
    </div>
  </template>
</div>-->

<!-- <script>
function shoppeSearch() {
  return {
    searchQuery: '',
    products: [
      {id: 1, name: 'Produk A', price: 10000, promo: true, terlaris: false, gratisOngkir: true, image: '', rating: 4.5},
      {id: 2, name: 'Produk B', price: 25000, promo: false, terlaris: true, gratisOngkir: false, image: '', rating: 4.8},
      {id: 3, name: 'Produk C', price: 18000, promo: true, terlaris: true, gratisOngkir: false, image: '', rating: 4.2},
      {id: 4, name: 'Produk D', price: 5000, promo: false, terlaris: false, gratisOngkir: true, image: '', rating: 3.9},
      {id: 5, name: 'Produk E', price: 30000, promo: false, terlaris: true, gratisOngkir: true, image: '', rating: 4.7},
    ],
    filteredProducts() {
      if(!this.searchQuery) return this.products;
      return this.products.filter(p => p.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
    },
    filterProducts() {
      this.filteredProducts(); // trigger reactivity
    },
    addToCart(product) {
      alert(`"${product.name}" ditambahkan ke keranjang!`);
    }
  }
}
</script>
-->






        <!-- 🔴 Badge Dinamis AJAX -->
@php
    $cartCount = collect(session('cart', []))->sum('qty');
@endphp

<span id="cart-count"
      class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full
             {{ $cartCount > 0 ? 'block' : 'hidden' }}">
    {{ $cartCount }}
</span>


    </div>

    <!-- Tooltip -->
    <div class="absolute hidden group-hover:block bg-gray-900 text-white text-xs rounded-md px-2 py-1 top-8 right-0 shadow-md">
        Keranjang Saya
    </div>
</a>


           

            <!-- 👤 User Auth -->
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 font-semibold text-blue-900 focus:outline-none">
                        
                       
                        
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                  
<!-- Dropdown Menu -->
<!--<div class="flex items-center gap-4">
   
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="font-semibold text-blue-900 focus:outline-none">
                👤 {{ Auth::user()->name }}
            </button>

            <!-- Dropdown Menu 
            <div x-show="open" @click.away="open = false"
                 class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-lg text-sm z-50">

                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                    👤 Akun Saya
                </a>

                <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    📦 Pesanan Saya
                </a>

                @if(Auth::user()->role === 'seller' || Auth::user()->is_admin)
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">
                        ⚙️ Dashboard
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>-->
    
    @endauth
</div>


        </div>
    </div>
</nav>


</div>

    </div>
<!-- 🛒 Mini Cart Drawer -->
<div id="mini-cart"
     class="fixed right-0 w-80 bg-white shadow-xl transition duration-300 rounded-l-2xl"
     style="top:48px; height:calc(100% - 48px); transform: translateX(100%); z-index:9999;">

    
  <div class="p-4 border-b flex justify-between items-center">
    <h3 class="font-bold text-lg">Keranjang</h3>
    <button onclick="toggleCart()" class="text-gray-500">✕</button>
  </div>

  <div class="p-4 text-sm text-gray-600 space-y-3">
    @foreach(session('cart', []) as $item)
      <div class="flex gap-3">
        <img src="{{ $item['image'] ?? 'https://picsum.photos/50' }}"
             class="w-12 h-12 rounded object-cover">
        <div>
          <p class="font-medium">{{ $item['name'] }}</p>
          <p class="text-yellow-600">Rp{{ number_format($item['price']) }}</p>
        </div>
      </div>
    @endforeach

    @if(empty(session('cart')))
      <p class="text-center text-gray-400 mt-10">Keranjang kosong</p>
    @endif
  </div>

  <div class="p-4 border-t">
    <a href="{{ route('cart.index') }}"
       class="block text-center bg-yellow-500 text-white py-3 rounded-lg font-semibold">
      Sewa
    </a>
  </div>
</div>

    <!-- Hero -->
    <!--<section class="hero">
        <h1>Temukan Segalanya di Glokamart</h1>
        <p>Belanja cerdas, kualitas terbaik, harga bersahabat.</p>
        <div class="mt-6 flex justify-center gap-6 text-sm text-blue-100">
  <span>🚚 Gratis Ongkir</span>
  <span>💳 Bayar di Tempat</span>
  <span>🔒 Aman & Terpercaya</span>
</div>-->

    </section>


    
<div class="max-w-6xl mx-auto px-4 mt-8">

    <!-- CONTAINER BANNER -->
<div x-data="bannerSlider({{ $banners->take(3)->count() }})"
     class="relative rounded-3xl overflow-hidden shadow-2xl border border-gray-200 bg-black">

    <!-- SLIDES -->
    <div class="flex transition-transform duration-500 ease-in-out"
         :style="'transform: translateX(-' + current * 100 + '%)'">

        @foreach($banners->take(3) as $banner)
            <div class="w-full flex-shrink-0 h-[220px] sm:h-[300px] md:h-[380px]">

                {{-- 🎬 VIDEO --}}
                @if($banner->type == 'video')
                    <video autoplay muted playsinline
                           class="w-full h-full object-cover">
                        <source src="{{ asset('storage/'.$banner->file) }}">
                    </video>

                {{-- 🖼️ FOTO --}}
                @else
                    <img src="{{ asset('storage/'.$banner->file) }}"
                         class="w-full h-full object-cover">
                @endif

            </div>
        @endforeach

    </div>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>

    <!-- BUTTON -->
    <button @click="prev()"
        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-blue text-black px-3 py-2 rounded-full shadow">
        ‹
    </button>

    <button @click="next()"
        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-blue text-black px-3 py-2 rounded-full shadow">
        ›
    </button>

    <!-- DOT -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        @foreach($banners->take(3) as $index => $banner)
            <div @click="goTo({{ $index }})"
                 :class="current === {{ $index }} ? 'bg-white scale-110' : 'bg-white/50'"
                 class="w-3 h-3 rounded-full cursor-pointer transition">
            </div>
        @endforeach
    </div>

</div>


<!-- SCRIPT -->
<script>
function bannerSlider(total) {
    return {
        current: 0,
        total: total,

        next() {
            this.current = (this.current + 1) % this.total;
        },

        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
        },

        goTo(i) {
            this.current = i;
        }
    }
}
</script>


<!-- 🌟 KATEGORI SECTION SCROLL KE KANAN -->
<!-- Categories -->
<div class="categories flex justify-around items-center flex-wrap gap-4 p-6 bg-white rounded-xl shadow-sm">
    @foreach($categories as $category)
        <a href="{{ url('kategori/'.$category->slug) }}" 
           class="category text-center block hover:scale-105 transition-transform">

            <img src="{{ asset('images/'.$category->slug.'.png') }}" 
                 alt="{{ $category->name }}" 
                 class="h-14 w-14 mx-auto object-contain mb-2">

            <p class="font-medium text-gray-700">
                {{ $category->name }}
            </p>

        </a>
    @endforeach
</div>


  <!-- 🔥 Filter Buttons -->
  <!--<div x-data="shopeeFilter()" class="p-4">
  
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
    </div>-->

    <!-- Sort Dropdown -->
     <!--<div class="relative ml-2">
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
  </div> -->

  <!-- 🔹 Produk List -->
  <!-- div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
    <template x-for="product in filteredProducts()" :key="product.id">
      <div class="bg-white rounded-lg shadow-md p-3 flex flex-col">
        <div class="flex-1">
          <h3 class="font-semibold text-sm mb-1" x-text="product.name"></h3>
          <p class="text-red-500 font-bold mb-1" x-text="'Rp ' + product.price.toLocaleString('id-ID')"></p>
        </div>
        <div class="flex gap-1 flex-wrap">
          <template x-if="product.promo">
            <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">🔥 Promo</span>
          </template>
          <template x-if="product.terlaris">
            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">⭐ Terlaris</span>
          </template>
          <template x-if="product.gratisOngkir">
            <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">🚚 Gratis Ongkir</span>
          </template>
        </div>
      </div>
    </template>
  </div>-->

  <!-- 🔹 Total Produk -->
  <!-- <div class="mt-4 text-right font-semibold text-gray-800">
    Total Produk: <span x-text="filteredProducts().length"></span>
  </div>

</div>

<script>
function shopeeFilter() {
  return {
    filters: [],
    sortBy: 'default',
    products: [
      {id: 1, name: 'Produk A', price: 10000, promo: true, terlaris: false, gratisOngkir: true},
      {id: 2, name: 'Produk B', price: 25000, promo: false, terlaris: true, gratisOngkir: false},
      {id: 3, name: 'Produk C', price: 18000, promo: true, terlaris: true, gratisOngkir: false},
      {id: 4, name: 'Produk D', price: 5000, promo: false, terlaris: false, gratisOngkir: true},
      {id: 5, name: 'Produk E', price: 30000, promo: false, terlaris: true, gratisOngkir: true},
    ],
    toggleFilter(filter) {
      if(this.filters.includes(filter)) {
        this.filters = this.filters.filter(f => f !== filter);
      } else {
        this.filters.push(filter);
      }
    },
    filteredProducts() {
      let result = this.products;
      if(this.filters.length > 0) {
        result = result.filter(p => this.filters.every(f => p[f]));
      }
      if(this.sortBy === 'termurah') {
        result = result.slice().sort((a,b)=>a.price-b.price);
      } else if(this.sortBy === 'terlaris') {
        result = result.slice().sort((a,b)=> (b.terlaris - a.terlaris) || (a.price-b.price));
      }
      return result;
    },
    sortProducts() {
      this.filteredProducts();
    }
  }
}
</script>

<style>
/* Hide scrollbar untuk Shopee style */
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>-->




<!-- Produk Section -->
<!--<s
  <div class="container mx-auto">
    <h3 class="text-2xl font-semibold mb-8 text-center">Produk Unggulan</h3>
    
    <section class="py-10 bg-white">
  <h3 class="text-xl font-bold mb-6 text-center">✨ Rekomendasi Untuk Kamu</h3>

  <div class="flex gap-4 overflow-x-auto px-6">
    @for($i=1;$i<=6;$i++)
      <div class="min-w-[160px] bg-gray-100 rounded p-3">
        <img src="https://picsum.photos/200?random={{$i+20}}" class="rounded mb-2">
        <p class="text-sm font-medium">Produk {{ $i }}</p>
        <p class="text-yellow-600 font-semibold text-sm">Rp {{ rand(10,99) }}K</p>
      </div>
    @endfor
  </div>
</section>-->


    <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div class="product-card bg-white border rounded shadow p-4 relative hover:shadow-lg transition">
      
        <span class="badge absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">Promo</span>
       

        
            

        <div class="product-info">
            
            <
            
                @csrf
                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition w-full">
                    Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>-->
   
</div>

    </div>
  </div>
</section>



<script>
document.addEventListener("DOMContentLoaded", () => {
  const cartBadge = document.querySelector("#cart-count");

  document.querySelectorAll(".add-to-cart-form").forEach(form => {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const productCard = form.closest(".product-card");
      const productImage = productCard.querySelector(".product-image");

      // Optimistic UI
      let currentCount = parseInt(cartBadge.textContent) || 0;
      cartBadge.textContent = currentCount + 1;
      cartBadge.classList.remove("hidden");

      // Clone image fly animation
      const flyingImage = productImage.cloneNode(true);
      const rect = productImage.getBoundingClientRect();
      flyingImage.style.position = "fixed";
      flyingImage.style.top = rect.top + "px";
      flyingImage.style.left = rect.left + "px";
      flyingImage.style.width = rect.width + "px";
      flyingImage.style.height = rect.height + "px";
      flyingImage.style.transition = "all 0.8s ease-in-out";
      flyingImage.style.zIndex = 1000;
      document.body.appendChild(flyingImage);

      const cartRect = cartBadge.getBoundingClientRect();
      requestAnimationFrame(() => {
        flyingImage.style.top = cartRect.top + "px";
        flyingImage.style.left = cartRect.left + "px";
        flyingImage.style.width = "20px";
        flyingImage.style.height = "20px";
        flyingImage.style.opacity = "0.5";
      });
      setTimeout(() => flyingImage.remove(), 800);

      // AJAX
      const formData = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": form.querySelector('input[name="_token"]').value,
            "X-Requested-With": "XMLHttpRequest"
          },
          body: formData
        });

        const data = await response.json();

        if (data.success) {
          cartBadge.textContent = data.cart_count;
        }
      } catch (err) {
        console.error("Gagal:", err);
      }
    });
  });
});
</script>






    <!-- Footer -->
    <footer>
        © 2026 <span>devi dwi nuraini </span> 
    </footer>

    <script src="//unpkg.com/alpinejs" defer></script>

    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- 🛒 SCRIPT MINI CART (TEMPEL DI SINI) -->
    <script>
  function toggleCart() {
    const cart = document.getElementById('mini-cart');

    if (cart.style.transform === 'translateX(0%)') {
      cart.style.transform = 'translateX(100%)'; // tutup
    } else {
      cart.style.transform = 'translateX(0%)'; // buka
    }
  }
</script>
<!-- 🔽 TARUH DI SINI -->
@if(session('openCart'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    toggleCart();
  });
</script>
@endif


</body>
</html>
