{{-- resources/views/store.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $storeName ?? 'Glokamart Store' }} — Glokamart</title>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
  {{-- Vite - sesuaikan jika berbeda --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body { font-family: 'Urbanist', sans-serif; }
    /* subtle gradient for header */
    .gm-top {
      background: linear-gradient(90deg,#003366 0%, #1e90ff 100%);
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800">

  {{-- NAVBAR --}}
  <header class="gm-top text-white fixed inset-x-0 top-0 z-40 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center gap-4">
          <a href="/" class="flex items-center gap-3">
            <div class="bg-white/10 rounded-md p-2">
              <img src="{{ $logo ?? '/images/glokamart-logo-white.svg' }}" alt="Glokamart" class="h-8 w-auto">
            </div>
            <span class="font-semibold text-lg">Glokamart</span>
          </a>
        </div>

        <div class="hidden md:flex items-center gap-6">
          <nav class="flex gap-4">
            <a class="hover:underline" href="#">Beranda</a>
            <a class="hover:underline" href="#">Produk</a>
            <a class="hover:underline" href="#">Promo</a>
            <a class="hover:underline" href="#">Bantuan</a>
          </nav>

          <div class="flex items-center gap-3">
            <a href="/login" class="px-3 py-1 rounded-md border border-white/20 text-white/90 hover:bg-white/10">Masuk</a>
            <a href="/register" class="px-4 py-1 rounded-md bg-white text-blue-700 font-semibold hover:bg-slate-100">Daftar</a>
          </div>
        </div>

        {{-- mobile menu toggle --}}
        <div class="md:hidden">
          <button id="mobileToggle" class="p-2 rounded-md hover:bg-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    {{-- mobile nav --}}
    <div id="mobileNav" class="md:hidden hidden bg-white/5">
      <div class="px-4 pb-4">
        <a href="#" class="block py-2 text-white">Beranda</a>
        <a href="#" class="block py-2 text-white">Produk</a>
        <a href="#" class="block py-2 text-white">Promo</a>
        <a href="#" class="block py-2 text-white">Bantuan</a>
      </div>
    </div>
  </header>

  <main class="pt-20">
    {{-- STORE HEADER --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow-sm -mt-6 p-6">
        <div class="flex flex-col lg:flex-row gap-6">
          {{-- cover image --}}
          <div class="relative flex-shrink-0 w-full lg:w-2/5 h-44 lg:h-40 rounded-lg overflow-hidden bg-gradient-to-r from-sky-700 to-sky-500">
            <img src="{{ $cover ?? '/images/store-cover-placeholder.jpg' }}" alt="Cover"
                 class="absolute inset-0 w-full h-full object-cover opacity-90">
            <div class="absolute left-4 bottom-4 flex items-center gap-4">
              <img src="{{ $storeAvatar ?? '/images/store-avatar.jpg' }}" alt="Avatar"
                   class="h-20 w-20 rounded-full border-2 border-white object-cover">
              <div class="text-white">
                <h1 class="text-xl font-semibold">{{ $storeName ?? 'TimePhoria Official Store' }}</h1>
                <p class="text-sm opacity-90">Aktif {{ $lastActive ?? '3 menit lalu' }}</p>
              </div>
            </div>
          </div>

          {{-- store meta & actions --}}
          <div class="flex-1 flex flex-col justify-between py-2">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
              <div class="p-3 bg-slate-50 rounded-md">
                <div class="text-sm text-slate-500">Produk</div>
                <div class="text-lg font-semibold text-sky-700">{{ $stats['products'] ?? 26 }}</div>
              </div>
              <div class="p-3 bg-slate-50 rounded-md">
                <div class="text-sm text-slate-500">Pengikut</div>
                <div class="text-lg font-semibold text-sky-700">{{ $stats['followers'] ?? '305RB' }}</div>
              </div>
              <div class="p-3 bg-slate-50 rounded-md">
                <div class="text-sm text-slate-500">Penilaian</div>
                <div class="text-lg font-semibold text-sky-700">4.9 ★ ({{ $stats['ratings'] ?? '282,5RB' }})</div>
              </div>
              <div class="p-3 bg-slate-50 rounded-md">
                <div class="text-sm text-slate-500">Bergabung</div>
                <div class="text-lg font-semibold text-sky-700">{{ $stats['joined'] ?? '11 Bulan Lalu' }}</div>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <button class="px-4 py-2 rounded-md bg-sky-700 text-white font-semibold hover:bg-sky-800">+ Ikuti</button>
              <button class="px-4 py-2 rounded-md border border-sky-700 text-sky-700 hover:bg-sky-50">💬 Chat</button>
              <a href="{{ $website ?? '#' }}" class="ml-4 text-sm underline text-slate-600 hidden md:inline">Kunjungi Website</a>

              <div class="ml-auto flex items-center gap-3">
                <button title="Bagikan" class="p-2 rounded-md hover:bg-slate-100">
                  <svg class="w-5 h-5 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 12v7a1 1 0 001 1h14a1 1 0 001-1v-7M16 6l-4-4-4 4M12 2v14"></path>
                  </svg>
                </button>
              </div>
            </div>

            <div class="mt-4">
              <nav class="flex gap-6 border-b pb-3">
                <a href="#" class="text-sky-700 font-semibold border-b-2 border-sky-700 pb-2">Halaman Utama</a>
                <a href="#" class="text-slate-600 hover:text-slate-800">Produk</a>
                <a href="#" class="text-slate-600 hover:text-slate-800">Promo</a>
                <a href="#" class="text-slate-600 hover:text-slate-800">Ulasan</a>
                <a href="#" class="text-slate-600 hover:text-slate-800">Tentang</a>
              </nav>
            </div>

          </div>
        </div>
      </div>
    </section>

    {{-- PROMO / COUPON CARDS --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
      <div class="bg-white rounded-lg shadow-sm p-4 overflow-x-auto">
        <div class="flex gap-4">
          {{-- contoh kupon --}}
          @php
            $coupons = $coupons ?? [
              ['title' => 'Diskon Rp20RB', 'meta' => 'Min. Blj Rp239RB', 'used' => 'Terpakai 96%', 'ends' => '7 jam'],
              ['title' => 'Diskon Rp25RB', 'meta' => 'Min. Blj Rp0', 'used' => 'Terpakai 81%', 'ends' => '8 jam'],
              ['title' => 'Diskon 50%', 'meta' => 'Min. Blj Rp0 s/d Rp3RB', 'used' => 'Terpakai 72%', 'ends' => '7 jam'],
            ];
          @endphp

          @foreach($coupons as $c)
            <div class="min-w-[260px] flex-shrink-0 border rounded-lg p-4 bg-sky-50">
              <div class="text-sky-800 font-semibold text-lg">{{ $c['title'] }}</div>
              <div class="text-sm text-slate-600 mt-1">{{ $c['meta'] }}</div>
              <div class="mt-3 flex items-center justify-between">
                <div class="text-xs text-slate-500">{{ $c['used'] }}, Berakhir dlm: {{ $c['ends'] }}</div>
                <button class="px-3 py-1 rounded-md bg-sky-700 text-white font-medium">Klaim</button>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    {{-- CONTENT GRID: SIDEBAR + PRODUCTS --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
      {{-- SIDEBAR KATEGORI (kecil di mobile) --}}
      <aside class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm p-4">
          <h3 class="font-semibold text-sky-700 mb-3">Kategori Toko</h3>
          <ul class="space-y-2 text-sm">
            <li><a class="flex items-center gap-2 p-2 rounded hover:bg-slate-50" href="#"><span class="w-2 h-2 bg-sky-700 rounded-full"></span> Face</a></li>
            <li><a class="flex items-center gap-2 p-2 rounded hover:bg-slate-50" href="#"><span class="w-2 h-2 bg-sky-700 rounded-full"></span> Lips</a></li>
            <li><a class="flex items-center gap-2 p-2 rounded hover:bg-slate-50" href="#"><span class="w-2 h-2 bg-sky-700 rounded-full"></span> Eyes</a></li>
            <li><a class="flex items-center gap-2 p-2 rounded hover:bg-slate-50" href="#"><span class="w-2 h-2 bg-sky-700 rounded-full"></span> New</a></li>
            <li><a class="flex items-center gap-2 p-2 rounded hover:bg-slate-50" href="#"><span class="w-2 h-2 bg-sky-700 rounded-full"></span> All Products</a></li>
          </ul>
        </div>
      </aside>

      {{-- PRODUCTS GRID --}}
      <div class="lg:col-span-3">
        <div class="bg-white rounded-lg shadow-sm p-4">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-lg">Produk Unggulan</h3>
            <div class="text-sm text-slate-500">Menampilkan 24 produk</div>
          </div>

          {{-- Filter / Sort sederhana --}}
          <div class="flex items-center justify-between gap-4 mb-4">
            <div class="flex items-center gap-2">
              <input type="search" placeholder="Cari dalam toko..." class="px-3 py-2 rounded border text-sm">
              <select class="px-3 py-2 rounded border text-sm">
                <option>Terpopuler</option>
                <option>Terbaru</option>
                <option>Termurah</option>
                <option>Termahal</option>
              </select>
            </div>
            <div class="text-sm text-slate-500">Grid</div>
          </div>

          {{-- grid produk responsif --}}
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @for ($i = 1; $i <= 12; $i++)
              <div class="bg-white rounded-md border group">
                <div class="relative overflow-hidden">
                  <img src="https://picsum.photos/seed/g{{ $i }}/400/300" alt="Produk {{ $i }}" class="w-full h-44 object-cover transition-transform duration-300 group-hover:scale-105">
                  <span class="absolute top-2 left-2 bg-sky-700 text-white text-xs px-2 py-1 rounded">15% OFF</span>
                </div>
                <div class="p-3 text-center">
                  <h4 class="text-sm font-medium text-slate-800 mb-1">Produk Premium {{ $i }}</h4>
                  <div class="text-sky-700 font-semibold mb-2">Rp{{ number_format(99000 * ($i % 5 + 1),0,',','.') }}</div>
                  <div class="flex items-center justify-center gap-2">
                    <button class="px-3 py-1 rounded-md bg-sky-700 text-white text-sm hover:bg-sky-800">Beli</button>
                    <button class="px-3 py-1 rounded-md border text-slate-700 text-sm hover:bg-slate-50">Detail</button>
                  </div>
                </div>
              </div>
            @endfor
          </div>

          {{-- pagination simple --}}
          <div class="mt-6 flex justify-center">
            <nav class="inline-flex -space-x-px rounded-md shadow-sm">
              <a href="#" class="px-3 py-2 bg-white border text-slate-700">1</a>
              <a href="#" class="px-3 py-2 bg-white border text-slate-700">2</a>
              <a href="#" class="px-3 py-2 bg-white border text-slate-700">3</a>
              <a href="#" class="px-3 py-2 bg-white border text-slate-700">›</a>
            </nav>
          </div>

        </div>
      </div>
    </section>

    {{-- FOOTER --}}
    <footer class="mt-10 bg-sky-900 text-white">
      <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
          <div class="font-semibold">Glokamart</div>
          <div class="text-sm opacity-80">Belanja Dunia, Dukung Lokal — © 2025</div>
        </div>

        <div class="flex items-center gap-4 text-sm opacity-90">
          <a href="#" class="hover:underline">Tentang</a>
          <a href="#" class="hover:underline">Bantuan</a>
          <a href="#" class="hover:underline">Kontak</a>
        </div>
      </div>
    </footer>
  </main>

  {{-- small scripts --}}
  <script>
    // mobile toggle
    document.getElementById('mobileToggle').addEventListener('click', () => {
      const nav = document.getElementById('mobileNav');
      nav.classList.toggle('hidden');
    });
  </script>
</body>
</html>
