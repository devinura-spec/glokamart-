<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Petugas Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100">

<div x-data="{ open: true }" class="flex min-h-screen">

    <!-- ================= SIDEBAR ================= -->
    <aside 
        :class="open ? 'w-64' : 'w-20'" 
        class="bg-white shadow-xl border-r transition-all duration-300 flex flex-col">

        <!-- HEADER -->
        <div class="flex items-center justify-between p-4 border-b">
            <span x-show="open" class="font-bold text-blue-600">
                🛠 Panel
            </span>

            <button @click="open = !open"
                class="bg-gray-100 p-2 rounded hover:bg-gray-200">
                ☰
            </button>
        </div>

        <!-- MENU -->
        <nav class="p-4 space-y-2 text-sm flex-1">

            <a href="{{ route('petugas.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100">
                📊 <span x-show="open">Dashboard</span>
            </a>

            <a href="{{ route('petugas.orders') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100">
                📦 <span x-show="open">Pesanan</span>
            </a>

            <a href="{{ route('petugas.laporan') }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100">
    📈 <span x-show="open">Laporan</span>
</a>

            <a href="{{ route('petugas.chat.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100">
                💬 <span x-show="open">Chat</span>
            </a>

        </nav>

        <!-- FOOTER -->
        <div class="p-4 border-t text-xs text-gray-400 text-center">
            <span x-show="open">© Petugas</span>
        </div>

    </aside>

    <!-- ================= CONTENT ================= -->
    <div class="flex-1 flex flex-col">

        <!-- NAVBAR (SIMPLE) -->
        <div class="bg-white border-b px-6 py-4 flex justify-end items-center relative z-50">

            <!-- DROPDOWN -->
            <div x-data="{ openDropdown: false }" class="relative">

                <button @click="openDropdown = !openDropdown"
                    class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-xl hover:bg-gray-200 transition">
                    👤 {{ auth()->user()->name ?? 'User' }} ▼
                </button>

                <div x-show="openDropdown"
                     x-transition
                     @click.outside="openDropdown = false"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg z-[9999] overflow-hidden">

                    <a href="{{ route('petugas.dashboard') }}"
                       class="block px-4 py-2 hover:bg-gray-100">
                        🛠 Dashboard
                    </a>

                    <a href="{{ route('petugas.chat.index') }}"
                       class="block px-4 py-2 hover:bg-gray-100">
                        💬 Chat
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100">
                            🚪 Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>