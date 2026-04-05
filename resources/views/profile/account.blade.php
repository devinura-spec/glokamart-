<x-app-layout>

    <div class="max-w-6xl mx-auto py-10 px-4">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 rounded-full overflow-hidden shadow">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                     class="w-full h-full object-cover">
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Halo, {{ Auth::user()->name }} 👋</h1>
                <p class="text-gray-500 text-sm">Kelola akun dan informasi pribadi Anda</p>
            </div>
        </div>

        {{-- Grid Besar --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            {{-- Sidebar Menu --}}
            <div class="bg-white p-4 rounded-xl shadow h-fit border">

                <p class="font-bold text-gray-700 mb-3">Menu Akun</p>

                <ul class="space-y-2 text-gray-600 text-sm">
                    <li>
                        <a href="{{ route('profile.edit') }}"
                           class="block px-3 py-2 rounded-md hover:bg-orange-100 hover:text-orange-600">
                            ✏️ Edit Profil
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('orders.index') }}"
                           class="block px-3 py-2 rounded-md hover:bg-orange-100 hover:text-orange-600">
                            📦 Pesanan Saya
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cart.index') }}"
                           class="block px-3 py-2 rounded-md hover:bg-orange-100 hover:text-orange-600">
                            🛒 Keranjang
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('wishlist') }}"
                           class="block px-3 py-2 rounded-md hover:bg-orange-100 hover:text-orange-600">
                            ❤️ Wishlist
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-3 py-2 rounded-md text-red-500 font-semibold hover:bg-red-100">
                            ⛔ Logout
                        </a>
                    </li>
                </ul>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

            </div>

            {{-- Main Card --}}
            <div class="md:col-span-3 bg-white p-6 rounded-xl shadow border">

                <h2 class="text-xl font-bold mb-4">Informasi Akun</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kiri --}}
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>

                        <hr class="my-4">

                        <p class="text-gray-600 text-sm mb-1">Email</p>
                        <p class="font-semibold text-gray-800">{{ Auth::user()->email }}</p>

                        <hr class="my-4">

                        <p class="text-gray-600 text-sm mb-1">Nomor Telepon</p>
                        <p class="font-semibold text-gray-800">
                            {{ Auth::user()->phone ?? 'Belum diisi' }}
                        </p>
                    </div>

                    {{-- Kanan --}}
                    <div class="flex flex-col items-center">

                        <p class="font-semibold mb-3">Foto Profil</p>

                        <div class="w-32 h-32 rounded-full overflow-hidden shadow mb-4">
                            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                                class="w-full h-full object-cover">
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                            Ubah Profil
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
