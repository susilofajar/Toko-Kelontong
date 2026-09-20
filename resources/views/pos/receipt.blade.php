<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk #{{ $sale->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #000;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
        }

        .item-name {
            margin-bottom: 2px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            padding-left: 15px;
            color: #555;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 2px;
        }

        @media print {
            body {
                width: 80mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="center">
        <h2>{{ $storeName }}</h2>
        <p>{{ $storeAddress }}</p>
        <p>{{ $storePhone }}</p>
    </div>
    <div class="separator"></div>
    <div class="row"><span>No: {{ $sale->invoice_number }}</span></div>
    <div class="row"><span>Tanggal: {{ $sale->created_at->format('d/m/Y H:i') }}</span></div>
    <div class="row"><span>Kasir: {{ $sale->user->name ?? '-' }}</span></div>
    @if($sale->customer)
        <div class="row"><span>Pelanggan: {{ $sale->customer->name }}</span></div>
    @endif
    <div class="separator"></div>

    @foreach($sale->details as $detail)
        <div class="item-name bold">{{ $detail->product->name ?? 'Produk' }}</div>
        <div class="item-detail">
            <span>{{ $detail->quantity }} x Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</span>
            <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
        </div>
    @endforeach

    <div class="separator"></div>
    <div class="row bold"><span>TOTAL</span><span>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span></div>
    <div class="row"><span>Bayar</span><span>Rp {{ number_format($sale->payment_amount, 0, ',', '.') }}</span></div>
    <div class="row"><span>Kembali</span><span>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</span></div>
    <div class="separator"></div>
    <div class="center" style="margin-top:8px;">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p style="color:#888;font-size:10px;margin-top:4px;">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan
        </p>
    </div>

    <div class="no-print center" style="margin-top:20px;">
        <button onclick="window.print()"
            style="padding:10px 30px;font-size:14px;cursor:pointer;background:#6366f1;color:white;border:none;border-radius:8px;">🖨
            Cetak Struk</button>
    </div>
</body>

</html>