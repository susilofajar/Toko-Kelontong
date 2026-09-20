<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan - {{ $month }}</title>
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
        @php
            $y = (int) substr($month, 0, 4);
            $m = (int) substr($month, 5, 2);
            $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        @endphp
        <div class="date">Laporan Penjualan Bulanan: {{ $monthNames[$m] }} {{ $y }}</div>
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
                <th>Tanggal</th>
                <th class="text-center">Transaksi</th>
                <th class="text-right">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dailySales as $i => $ds)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($ds->date)->format('d M Y') }}</td>
                    <td class="text-center">{{ $ds->transactions }}</td>
                    <td class="text-right">Rp {{ number_format($ds->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        @if($dailySales->count() > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="2" class="text-right">TOTAL</td>
                    <td class="text-center">{{ $totalTransactions }}</td>
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