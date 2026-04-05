<button onclick="startScanner()" 
        class="bg-green-500 text-white px-4 py-2 rounded">
    📷 Scan Barcode
</button>

<div id="scanner" class="mt-4 hidden">
    <div id="preview" style="width:100%; height:300px;"></div>
</div>
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script>
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
    });

    Quagga.onDetected(function(data) {
        let kode = data.codeResult.code;

        Quagga.stop();

        // sementara kita test dulu
        alert("Kode terbaca: " + kode);
    });
}
</script>