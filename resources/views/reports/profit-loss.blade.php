@extends('layouts.app')
@section('title', 'Laporan Laba Rugi (Profit & Loss)')

@section('content')
    <div class="row mb-4 align-items-end">
        <div class="col-md-4">
            <form method="GET" class="d-flex gap-2">
                <input type="month" class="form-control" name="month" value="{{ $month }}">
                <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Tampilkan</button>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(99,102,241,0.15);color:var(--primary-light);">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Penjualan (Revenue)</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:var(--danger);">
                    <i class="bi bi-cart-dash-fill"></i>
                </div>
                <div class="stat-value">Rp {{ number_format($totalCost, 0, ',', '.') }}</div>
                <div class="stat-label">Total Harga Modal (HPP)</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card"
                style="{{ $netProfit >= 0 ? 'border-color:var(--success);' : 'border-color:var(--danger);' }}">
                <div class="stat-icon"
                    style="background:{{ $netProfit >= 0 ? 'rgba(34,197,94,0.15)' : 'rgba(239,68,68,0.15)' }};color:{{ $netProfit >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="stat-value" style="color:{{ $netProfit >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                    Rp {{ number_format($netProfit, 0, ',', '.') }}
                </div>
                <div class="stat-label">Laba Bersih (Net Profit)</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header border-bottom-0 pb-0">
            <h5 class="mb-0">Rincian Penjualan Lunas</h5>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-end">Penjualan</th>
                            <th class="text-end">Harga Modal</th>
                            <th class="text-end">Laba/Rugi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dailyData as $data)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($data->date)->translatedFormat('l, d F Y') }}</td>
                                <td class="text-end">Rp {{ number_format($data->revenue, 0, ',', '.') }}</td>
                                <td class="text-end text-danger">Rp {{ number_format($data->cost, 0, ',', '.') }}</td>
                                <td class="text-end"
                                    style="color:{{ ($data->revenue - $data->cost) >= 0 ? 'var(--success)' : 'var(--danger)' }}; font-weight: 600;">
                                    Rp {{ number_format($data->revenue - $data->cost, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada data penjualan di bulan ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection