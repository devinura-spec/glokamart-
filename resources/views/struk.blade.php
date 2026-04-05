<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi {{ $trx->invoice_code }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 16px;
            font-size: 14px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0;
        }

        .details, .items, .footer {
            width: 100%;
            margin-bottom: 12px;
        }

        .details div {
            margin-bottom: 4px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th, .items td {
            border-bottom: 1px dashed #000;
            padding: 4px 0;
            text-align: left;
        }

        .items th {
            text-align: left;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 8px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 16px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h2>🛒 Glokamart</h2>
    <div>Invoice: <strong>{{ $trx->invoice_code }}</strong></div>
    <div>Tanggal: {{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</div>
</div>

<div class="details">
    <div>Pelanggan: {{ $trx->user->name }}</div>
    <div>Metode Pembayaran: {{ ucfirst($trx->payment_method) }}</div>
    <div>Status: {{ ucfirst($trx->payment_status) }}</div>
</div>

<div class="items">
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $trx->product->name }}</td>
                <td>1</td>
                <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        Total: Rp {{ number_format($trx->total_price, 0, ',', '.') }}
    </div>
</div>

<div class="footer">
    Terima kasih telah berbelanja di Glokamart!<br>
    📞 Hubungi kami: 0812-XXXX-XXXX
</div>

<script>
    window.onload = function() {
        window.print();
    }
</script>

</body>
</html>