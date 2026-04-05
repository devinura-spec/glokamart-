<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Glokamart') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-[Urbanist] bg-gray-50 text-gray-800 antialiased">

<!-- NAVBAR -->
<nav class="bg-white shadow-sm sticky top-0 z-50 border-b">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">


    



        <!-- LOGO -->
        <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-900">
            🛒 Glokamart
        </a>

        <div class="flex items-center gap-4">

            @auth
            

                <!-- ADMIN BUTTON -->
               @if(auth()->user()->role_id == 3)
    <a href="{{ route('petugas.dashboard') }}"
       class="text-white bg-green-500 px-3 py-1 rounded-lg hover:bg-green-600 transition">
       🛠 Dashboard Petugas
    </a>
@endif

                <!-- DROPDOWN -->
<div x-data="{ open: false }" class="relative">

    <!-- BUTTON -->
    <button @click="open = !open"
        class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-lg hover:bg-gray-200 transition font-semibold text-blue-900">
        
        👤 {{ Auth::user()->name }}
        <span class="text-xs">▼</span>
    </button>

    <!-- MENU -->
    <div x-show="open"
         x-transition
         @click.away="open = false"
         class="absolute right-0 mt-3 w-56 bg-white border rounded-xl shadow-xl overflow-hidden text-sm z-50">

        <!-- ROLE -->
        <div class="px-4 py-2 text-xs text-gray-400 border-b">
            Login sebagai:
            <span class="font-semibold text-gray-700">
                {{ auth()->user()->role_id }}
            </span>
        </div>

        <!-- ADMIN -->
        @if(auth()->user()->role_id == 1)

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 px-4 py-2 hover:bg-yellow-50 text-yellow-600 font-semibold">
                ⚙️ Dashboard Admin
            </a>

        <!-- PETUGAS -->
        @elseif(auth()->user()->role_id == 3)

            <a href="{{ route('petugas.dashboard') }}"
               class="flex items-center gap-2 px-4 py-2 hover:bg-green-50 text-green-600 font-semibold">
                🛠 Dashboard Petugas
            </a>

            <a href="{{ route('petugas.chat.index') }}"
               class="flex items-center gap-2 px-4 py-2 hover:bg-green-50">
                💬 Chat Pelanggan
            </a>

        <!-- USER -->
        @else

            <a href="{{ route('orders.index') }}"
               class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                📦 Pesanan Saya
            </a>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                ⚙️ Akun Saya
            </a>

        @endif

                        <!-- LOGOUT -->
                        <div class="border-t"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                🚪 Logout
                            </button>
                        </form>

                    </div>
                </div>

            @else

                <!-- GUEST -->
                <a href="{{ route('login') }}" class="text-blue-900 font-semibold hover:underline">
                    Masuk
                </a>

                <a href="{{ route('register') }}"
                   class="bg-blue-900 text-white px-4 py-2 rounded-full hover:opacity-90 transition">
                    Daftar
                </a>

            @endauth

        </div>
    </div>
</nav>

<!-- NOTIF -->
@php $successMessage = session('success'); @endphp
@if($successMessage)
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg z-50">
    {{ $successMessage }}
</div>
@endif

<!-- CONTENT -->

<!-- ================= ADMIN LAYOUT ================= -->
@if(auth()->check() && auth()->user()->role_id == 1)

<div x-data="{ open: true }" class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside :class="open ? 'w-64' : 'w-20'"
           class="bg-white shadow-lg p-4 border-r transition-all duration-300">

        <!-- TOGGLE -->
        <button @click="open = !open"
            class="mb-6 bg-gray-100 p-2 rounded-lg w-full hover:bg-gray-200">
            ☰
        </button>

        <!-- MENU -->
        <nav class="space-y-2 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white' : 'hover:bg-blue-100' }}">
                📊 <span x-show="open">Dashboard</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('admin.products.*') ? 'bg-blue-500 text-white' : 'hover:bg-blue-100' }}">
                📦 <span x-show="open">Produk</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('admin.categories.*') ? 'bg-blue-500 text-white' : 'hover:bg-blue-100' }}">
                🗂 <span x-show="open">Kategori</span>
            </a>

            <a href="{{ route('admin.banner') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('admin.banner') ? 'bg-blue-500 text-white' : 'hover:bg-blue-100' }}">
                🎬 <span x-show="open">Banner</span>
            </a>

            <a href="{{ route('admin.orders') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('admin.orders') ? 'bg-blue-500 text-white' : 'hover:bg-blue-100' }}">
                📑 <span x-show="open">Orders</span>
            </a>

        </nav>

    </aside>

    <!-- CONTENT -->
    <main class="flex-1 bg-gray-50 p-6">
        



        @yield('content')
    </main>

</div>




@else
<!-- ================= USER LAYOUT ================= -->
<div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    
    {{ $slot ?? '' }}
    @yield('content')
</main>

@endif

<!-- FOOTER -->
<footer class="text-center text-gray-600 py-6 text-sm border-t bg-white">
    © 2026 <span class="font-semibold text-blue-900">devi dwi nuraini</span>
</footer>

<!-- ALPINE (CUMA SEKALI!) -->
<script src="//unpkg.com/alpinejs" defer></script>

<!-- SEARCH SCRIPT -->
<script>
function searchComponent(){
  return{
    searchQuery:'',
    products:[
      'Kamera Canon','Kamera Sony','Lensa Wide Angle',
      'Tripod Kamera','Lighting Studio','Microphone Wireless',
      'Drone Kamera','Action Cam'
    ],
    filteredProducts:[],
    filterProducts(){
      if(this.searchQuery===''){
        this.filteredProducts=[]
        return
      }
      this.filteredProducts=this.products.filter(product =>
        product.toLowerCase().includes(this.searchQuery.toLowerCase())
      )
    },
    selectProduct(product){
      this.searchQuery=product
      this.filteredProducts=[]
    }
  }
}
</script>




<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrCode;

function startScanner() {
    document.getElementById('scanner').classList.remove('hidden');

    html5QrCode = new Html5Qrcode("preview");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        (decodedText) => {
            console.log("Hasil scan:", decodedText); // 🔥 cek console
            stopScanner();

            let kode = decodedText.split('/').pop().trim(); // ambil invoice_code kalau QR URL

            fetch(`/scan/${kode}`)
                .then(res => res.text())
                .then(html => {
                    document.body.innerHTML = html; // tampilkan struk
                    window.print(); // auto print
                });
        }
    );
}

function stopScanner() {
    document.getElementById('scanner').classList.add('hidden');
    if (html5QrCode) {
        html5QrCode.stop();
    }
}
</script>


</body>
</html>