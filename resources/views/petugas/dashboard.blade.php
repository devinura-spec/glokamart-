@extends('layouts.petugas')

@php
use App\Models\Transaksi;

// Ambil data
$total = Transaksi::count();
$pending = Transaksi::where('payment_status','pending')->count();
$selesai = Transaksi::where('payment_status','diambil')->count(); // atau 'confirmed'
$batal = Transaksi::where('payment_status','batal')->count();
$today = Transaksi::whereDate('created_at', now()->toDateString())->count();
$progress = $total ? round(($selesai/$total)*100) : 0;

// Siapkan array stats untuk loop
$stats = [
    ['📦', 'Total', $total, 'purple'],
    ['⏳', 'Pending', $pending, 'red'],
    ['📅', 'Hari Ini', $today, 'green'],
    ['✅', 'Selesai', $selesai, 'blue'],
    ['❌', 'Batal', $batal, 'gray'],
];
@endphp

@section('content')
<!-- 🔥 FLOATING BUTTON SCAN -->
<button onclick="startScanner()"
    class="fixed bottom-6 right-6 bg-red-500 hover:bg-red-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-2xl z-50">
    📷
</button>

<!-- SCANNER MODAL -->
<div id="scanner" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center">
    <div id="preview" class="w-full max-w-md h-80 bg-black rounded"></div>

    <!-- tombol close -->
    <button onclick="stopScanner()" 
        class="absolute top-5 right-5 bg-white text-black px-3 py-1 rounded">
        ✖
    </button>
</div>

<!-- HTML5 QR Code Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrCode;

async function startScanner() {
    document.getElementById('scanner').classList.remove('hidden');

    // Ambil daftar kamera
    const cameras = await Html5Qrcode.getCameras();

    let cameraId;
    if(cameras.length === 0){
        alert("Tidak ada kamera terdeteksi!");
        return;
    }

    // Pilih kamera otomatis
    // Coba kamera belakang dulu
    cameraId = cameras.find(cam => /back|environment/i.test(cam.label))?.id
               || cameras[0].id; // fallback ke kamera pertama

    html5QrCode = new Html5Qrcode("preview");

    html5QrCode.start(
        cameraId,
        { fps: 10, qrbox: 300 },
        (decodedText) => {
            console.log("Hasil scan:", decodedText);
            stopScanner();

            // Kirim ke backend
            fetch(`/scan/${decodedText}`)
                .then(res => res.text())
                .then(html => {
                    document.body.innerHTML = html;
                    window.print();
                });
        },
        (errorMessage) => {
            // opsional: log error scan, jangan spam
            console.log("Scan error:", errorMessage);
        }
    );
}

function stopScanner() {
    document.getElementById('scanner').classList.add('hidden');
    if(html5QrCode) html5QrCode.stop();
}
</script>





<div class="w-full min-h-screen bg-gray-100 p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📊 Dashboard Petugas</h1>
        <p class="text-gray-500 text-sm">
            Login: {{ auth()->user()->name }} (ID: {{ auth()->user()->id }})
        </p>
    </div>

    <!-- ================= STAT ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6 mb-6">
        @foreach($stats as $s)
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-xl transition">
            <div class="flex justify-between items-center">
                <span class="text-3xl">{{ $s[0] }}</span>
                <span class="text-xs bg-{{ $s[3] }}-100 text-{{ $s[3] }}-600 px-2 py-1 rounded-full">
                    {{ $s[1] }}
                </span>
            </div>
            <h2 class="text-3xl font-bold text-{{ $s[3] }}-500 mt-2">
                {{ $s[2] }}
            </h2>
        </div>
        @endforeach
    </div>

    <!-- ================= CHART + INSIGHT ================= -->
    <div class="grid md:grid-cols-3 gap-6 mb-6">

        <!-- CHART -->
        <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow">
            <h2 class="font-semibold mb-3">📈 Grafik Pesanan</h2>
            <canvas id="chartOrders"></canvas>
        </div>

        <!-- INSIGHT -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="font-semibold mb-3">⚡ Insight</h2>

            <p class="text-sm text-gray-500 mb-2">
                Hari ini: <span class="font-bold text-green-500">{{ $today }}</span>
            </p>

            <p class="text-sm text-gray-500 mb-2">Progress selesai:</p>

            <div class="w-full bg-gray-200 h-3 rounded-full">
                <div class="bg-blue-500 h-3 rounded-full"
                     style="width: {{ $progress }}%"></div>
            </div>

            <p class="text-xs mt-2 text-gray-400">
                {{ $progress }}% selesai
            </p>

            @if(isset($topUser) && $topUser)
            <div class="mt-4 text-sm">
                👑 Top User:
                <div class="font-semibold">
                    {{ $topUser->user->name ?? '-' }}
                </div>
                <div class="text-gray-400 text-xs">
                    {{ $topUser->total }} transaksi
                </div>
            </div>
            @endif
        </div>

    </div>

    <!-- ================= MENU ================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <a href="{{ route('petugas.orders') }}"
           class="bg-green-500 text-white p-6 rounded-2xl hover:scale-105 transition">
            📝 Kelola Pesanan
        </a>

        <a href="{{ route('petugas.laporan') }}"
   class="bg-purple-500 text-white p-6 rounded-2xl hover:scale-105 transition">
    📊 Laporan
</a>

        <a href="{{ route('petugas.chat.index') }}"
           class="bg-blue-500 text-white p-6 rounded-2xl hover:scale-105 transition">
            💬 Chat
        </a>

       
    

    </div>








    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-2xl p-6 shadow">

        <h2 class="font-semibold mb-4">📦 Pesanan Terbaru</h2>

        @if($orders->count())
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <tbody>
                    @foreach($orders as $index => $order)
                    <tr class="border-b {{ $index==0 ? 'bg-blue-50' : '' }}">

                        <!-- ID + Nama Produk -->
                    <td class="px-3 py-3">
                        <div class="font-semibold">
                            {{ $order->product->name ?? '-' }}
                        </div>
                        <div class="text-xs text-gray-400">
                            ID Produk: {{ $order->product_id ?? '-' }}
                        </div>
                    </td>

                          <!-- USER -->
                    <td class="px-3 py-3">
                        {{ $order->user->name ?? '-' }}
                    </td>

                    <!-- TOTAL -->
                    <td class="px-3 py-3">
                        Rp {{ number_format($order->total_price ?? $order->total ?? 0,0,',','.') }}
                    </td>
                    
                        <td class="px-3 py-3">
                           <span class="text-xs px-3 py-1 rounded-full
    {{ $order->payment_status=='pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
    {{ $order->payment_status=='confirmed' ? 'bg-blue-100 text-blue-600' : '' }}
    {{ $order->payment_status=='diambil' ? 'bg-purple-100 text-purple-600' : '' }}
    {{ $order->payment_status=='dikembalikan' ? 'bg-green-100 text-green-600' : '' }}
    {{ $order->payment_status=='batal' ? 'bg-red-100 text-red-600' : '' }}">
    {{ $order->payment_status }}
</span>
                        <td class="px-3 py-3 space-y-1">
    @if($order->payment_status == 'pending')
    <form action="{{ route('petugas.orders.updateStatus', $order->id) }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="status" value="confirmed">
        <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs w-full">
            ✔ Konfirmasi
        </button>
    </form>
    @endif

    @if(in_array($order->payment_status, ['confirmed','diambil']))
    <form action="{{ route('petugas.transaksi.updateStatus', $order->id) }}" method="POST">
        @csrf @method('PUT')
        <select name="status" class="bg-gray-100 border rounded px-2 py-1 text-xs w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ $order->payment_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="diambil" {{ $order->payment_status == 'diambil' ? 'selected' : '' }}>Diambil</option>
            <option value="dikembalikan" {{ $order->payment_status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            <option value="batal" {{ $order->payment_status == 'batal' ? 'selected' : '' }}>Batal</option>
        </select>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs w-full mt-1">
            Update
        </button>
    </form>
    @endif
</td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-gray-400 py-6">Belum ada pesanan</div>
        @endif

    </div>

</div>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartData = @json($chart);
const labels = chartData.map(item => item.date);
const data = chartData.map(item => item.total);

new Chart(document.getElementById('chartOrders'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pesanan',
            data: data,
            borderWidth: 2,
            tension: 0.3
        }]
    }
});
</script>





<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script>
let scannerActive = false;

function startScanner() {
    document.getElementById('scanner').classList.remove('hidden');

    Quagga.init({
        inputStream: {
            type: "LiveStream",
            target: document.querySelector('#preview'),
            constraints: {
                facingMode: "environment"
            }
        },
        decoder: {
            readers: ["code_128_reader"]
        }
    }, function(err) {
        if (err) {
            console.log(err);
            alert("Kamera tidak bisa dibuka");
            return;
        }
        Quagga.start();
        scannerActive = true;
    });

    Quagga.onDetected(function(data) {
        let kode = data.codeResult.code;

        Quagga.stop();
        scannerActive = false;

        alert("Barcode terbaca: " + kode);
    });
}

function stopScanner() {
    document.getElementById('scanner').classList.add('hidden');

    if (scannerActive) {
        Quagga.stop();
        scannerActive = false;
    }
}
</script>


@endsection