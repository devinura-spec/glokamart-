<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Glokamart</title>
    @vite('resources/css/app.css')
    <style>
        /* Tambahan styling khusus form register */
        .register-form {
            max-width: 400px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .register-form h2 {
            text-align: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: #0A2472;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <div class="navbar">
        <img src="{{ asset('images/glokamart-logo.png') }}" alt="Glokamart Logo" style="width: 150px;">

        <div class="search-box">
            <input type="text" placeholder="Cari produk terbaik di Glokamart...">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </button>
        </div>

        <div class="actions">
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        </div>
    </div>

    <!-- Form Register -->
    <div class="register-form">
        <h2>Daftar Akun Glokamart</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Nama')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-sm"/>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-sm"/>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"/>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-sm"/>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-sm"/>
            </div>

            <!-- Submit -->
            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Sudah punya akun? Masuk</a>
                <x-primary-button class="ml-3">
                    Daftar
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-600 text-sm">
        © 2025 <span class="font-bold text-blue-900">Glokamart</span> — Semua ada, semua mudah.
    </footer>

</body>
</html>
