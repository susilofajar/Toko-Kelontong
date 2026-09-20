<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Harian - {{ $date }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 2px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: normal;
            color: #666;
        }

        .header .date {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .summary {
            display: flex;
            margin-bottom: 20px;
        }

        .summary-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 15px;
            margin-right: 15px;
        }

        .summary-box .label {
            font-size: 10px;
            color: #888;
            text-transform: uppercase;
        }

        .summary-box .value {
            font-size: 16px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            border: 1px solid #ddd;
            padding: 6px 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background: #f9f9f9;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            color: #888;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $storeName }}</h1>
        <h2>{{ $storeAddress }}</h2>
        <div class="date">Laporan Penjualan Harian: {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <table style="width:auto;border:none;margin-bottom:20px;">
        <tr>
            <td style="border:1px solid #ddd;padding:8px 15px;">
                <div style="font-size:9px;color:#888;text-transform:uppercase;">Total Penjualan</div>
                <div style="font-size:14px;font-weight:bold;">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
            </td>
            <td style="border:1px solid #ddd;padding:8px 15px;">
                <div style="font-size:9px;color:#888;text-transform:uppercase;">Jumlah Transaksi</div>
                <div style="font-size:14px;font-weight:bold;">{{ $totalTransactions }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width:30px;">#</th>
                <th>Invoice</th>
                <th>Waktu</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th>Items</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $i => $sale)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->created_at->format('H:i') }}</td>
                    <td>{{ $sale->user->name ?? '-' }}</td>
                    <td>{{ $sale->customer->name ?? 'Umum' }}</td>
                    <td class="text-center">{{ $sale->details->count() }}</td>
                    <td class="text-right">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
        @if($sales->count() > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="6" class="text-right">TOTAL</td>
                    <td class="text-right">Rp {{ number_format($totalSales, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} | {{ $storeName }}
    </div>
</body>

</html>