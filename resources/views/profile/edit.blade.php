<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- BAGIAN KIRI (FORM-FORM) --}}
                    <div class="md:col-span-2 space-y-6">

                        {{-- Update Informasi Profil --}}
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        {{-- Update Password --}}
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                            @include('profile.partials.update-password-form')
                        </div>

                        {{-- Hapus Akun --}}
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                            @include('profile.partials.delete-user-form')
                        </div>

                    </div>

                    {{-- BAGIAN KANAN (FOTO PROFIL) --}}
                    <div class="flex flex-col items-center bg-white dark:bg-gray-800 p-6 rounded-lg shadow">

                        <h3 class="font-semibold mb-4 text-lg">Foto Profil</h3>

                        {{-- PREVIEW FOTO --}}
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-4 shadow">
                            <img 
                                src="{{ Auth::user()->photo 
                                    ? asset('storage/' . Auth::user()->photo) 
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                alt="Foto Profil"
                                class="w-full h-full object-cover"
                            >
                        </div>

                        {{-- FORM UPLOAD FOTO --}}
                        <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="w-full text-center">
                            @csrf
                            <input 
                                type="file" 
                                name="photo" 
                                class="block w-full text-sm mb-3"
                                accept="image/*"
                                required
                            >
                            
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md w-full">
                                Upload Foto
                            </button>
                        </form>

                        {{-- INFO --}}
                        <p class="text-xs text-gray-500 mt-3 text-center">
                            Maksimum 1 MB<br>
                            Format: JPG, PNG
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
