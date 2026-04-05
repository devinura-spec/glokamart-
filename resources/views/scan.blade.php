<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan QR | Glokamart</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body { font-family: 'Urbanist', sans-serif; background: #f0f0f0; margin:0; }
        #scanner { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center; }
        #preview { width: 90%; max-width: 400px; height: 300px; background: black; border-radius: 12px; }
        .btn-scan { position: fixed; bottom: 24px; right: 24px; width: 60px; height: 60px; border-radius: 50%; background: red; color: white; font-size: 28px; display: flex; justify-content: center; align-items: center; cursor: pointer; z-index: 10000; box-shadow: 0 4px 8px rgba(0,0,0,0.3); }
        .btn-close { position: absolute; top: 16px; right: 16px; background: white; color: black; padding: 4px 8px; border-radius: 6px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

<!-- FLOATING BUTTON SCAN -->
<div class="btn-scan" onclick="startScanner()">📷</div>

<!-- SCANNER MODAL -->
<div id="scanner" class="flex">
    <div id="preview"></div>
    <div class="btn-close" onclick="stopScanner()">✖</div>
</div>

<script>
let html5QrCode;

// 🔥 Mulai scanner
function startScanner() {
    document.getElementById('scanner').style.display = 'flex';

    html5QrCode = new Html5Qrcode("preview");

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 15, // bisa dinaikkan sesuai performa HP
            qrbox: 250,
            aspectRatio: 1.0,
            disableFlip: false
        },
        (decodedText) => {
            // ambil kode terakhir jika QR berisi URL
            const kode = decodedText.split('/').pop().trim();

            stopScanner();

            // fetch ke backend
            fetch(`/scan/${kode}`)
                .then(res => {
                    if(!res.ok) throw new Error("Data tidak ditemukan");
                    return res.text();
                })
                .then(html => {
                    document.body.innerHTML = html;
                    window.print();
                })
                .catch(err => alert(err.message));
        },
        (errorMessage) => {
            // optional: error kecil saat scan
            // console.log("Scan error:", errorMessage);
        }
    ).catch(err => console.log("Error start QR:", err));
}

// 🔥 Stop scanner
function stopScanner() {
    document.getElementById('scanner').style.display = 'none';
    if(html5QrCode){
        html5QrCode.stop().catch(err => console.log(err));
    }
}
</script>

</body>
</html>