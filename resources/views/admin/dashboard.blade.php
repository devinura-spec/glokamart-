@extends('layouts.app')

@section('content')
<h1 class="text-4xl font-extrabold text-blue-700 mb-10 text-center
bg-blue-50 border border-blue-200
py-6 px-6 rounded-3xl shadow-sm">
    Admin Dashboard
</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

        <!-- Categories Card -->
        <a href="{{ route('admin.categories.index') }}"
           class="group block p-6 bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
            <div class="flex items-center space-x-4 bg-blue-50 px-4 py-3 rounded-2xl shadow-sm border border-blue-100 hover:bg-blue-100 transition">
                <div class="text-blue-500 text-5xl group-hover:scale-110 transition">📂</div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-500">
                        Categories
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Jenis utama: Kamera, Lensa, Paket
                    </p>
                </div>
            </div>
        </a>

        <!-- Brands Card -->
        <a href="{{ route('admin.brands.index') }}"
           class="group block p-6 bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
           <div class="flex items-center space-x-4 bg-gradient-to-r from-blue-50 to-sky-100 px-4 py-3 rounded-2xl border border-blue-100 shadow-sm">
                <div class="text-blue-500 text-5xl group-hover:scale-110 transition">🏷️</div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-500">
                        Brands
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Canon → Kamera, 85mm → Lensa
                    </p>
                </div>
            </div>
        </a>

        <!-- Products Card -->
        <a href="{{ route('admin.products.index') }}"
           class="group block p-6 bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
           <div class="flex items-center space-x-4 bg-gradient-to-r from-blue-50 to-sky-100 px-4 py-3 rounded-2xl border border-blue-100 shadow-sm">
                <div class="text-blue-500 text-5xl group-hover:scale-110 transition">🛒</div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-500">
                        Products
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Barang asli yang disewakan
                    </p>
                </div>
            </div>
        </a>

        <!-- Orders Card -->
      <a href="{{ route('admin.orders') }}"
           class="group block p-6 bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
           <div class="flex items-center space-x-4 bg-gradient-to-r from-blue-50 to-sky-100 px-4 py-3 rounded-2xl border border-blue-100 shadow-sm">
                <div class="text-blue-500 text-5xl group-hover:scale-110 transition">📦</div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-500">
                        Orders
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Pesanan dari user
                    </p>
                </div>
            </div>
        </a>


       <!-- Banner Card -->
<a href="{{ route('admin.banner') }}"
   class="group block p-6 bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300">

    <div class="flex items-center space-x-4 bg-gradient-to-r from-purple-50 to-pink-100 px-4 py-3 rounded-2xl border border-purple-100 shadow-sm">
        
        <div class="text-purple-500 text-5xl group-hover:scale-110 transition">🎬</div>
        
        <div>
            <h2 class="text-xl font-bold text-gray-800 group-hover:text-purple-500">
                Banner
            </h2>
            <p class="text-gray-500 text-sm">
                Foto & Video Homepage
            </p>
        </div>

    </div>
</a>

    </div>

    


{{-- Grafik Statistik --}}


    

    {{-- Grafik Statistik --}}
    <div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Grafik Pesanan --}}
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-lg font-bold text-gray-700 mb-4">📈 Statistik Pesanan</h2>
            <canvas id="ordersChart"></canvas>
        </div>

        {{-- Grafik Status Pembayaran --}}
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-lg font-bold text-gray-700 mb-4">💳 Status Pembayaran</h2>
            <canvas id="paymentChart"></canvas>
        </div>

    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ordersCtx = document.getElementById('ordersChart').getContext('2d');

new Chart(ordersCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labels) !!}, // Tanggal pesanan
        datasets: [{
            label: 'Jumlah Pesanan',
            data: {!! json_encode($data) !!}, // Jumlah pesanan tiap tanggal
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59,130,246,0.2)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

const paymentCtx = document.getElementById('paymentChart').getContext('2d');

new Chart(paymentCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($paymentStatus)) !!}, // Semua status
        datasets: [{
            data: {!! json_encode(array_values($paymentStatus)) !!}, // Jumlah tiap status
            backgroundColor: [
                '#FACC15', // Pending
                '#3B82F6', // Confirmed
                '#A855F7', // Diambil
                '#10B981', // Dikembalikan
                '#EF4444', // Batal
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>


@endsection
