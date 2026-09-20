@extends('layouts.app')
@section('title', 'Laporan Harian')

@section('content')
    <div class="row g-3 mb-4 align-items-end">
        <div class="col-12 col-md-auto">
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <form class="d-flex gap-2" method="GET">
                    <input type="date" class="form-control" name="date" value="{{ $date }}" onchange="this.form.submit()">
                </form>
                <a href="{{ route('reports.daily.pdf', ['date' => $date]) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                </a>
            </div>
        </div>
        <div class="col-12 col-md">
            <div class="row g-2">
                <div class="col-6 col-md-auto ms-md-auto">
                    <div class="stat-card" style="padding:0.75rem 1.25rem;">
                        <div class="stat-label">Total Penjualan</div>
                        <div class="stat-value" style="font-size:1.15rem;color:var(--success);">Rp
                            {{ number_format($totalSales, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-auto">
                    <div class="stat-card" style="padding:0.75rem 1.25rem;">
                        <div class="stat-label">Transaksi</div>
                        <div class="stat-value" style="font-size:1.15rem;color:var(--primary-light);">
                            {{ $totalTransactions }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Waktu</th>
                            <th>Kasir</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $i => $sale)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><code>{{ $sale->invoice_number }}</code></td>
                                <td style="color:var(--text-muted);">{{ $sale->created_at->format('H:i') }}</td>
                                <td>{{ $sale->user->name ?? '-' }}</td>
                                <td>{{ $sale->customer->name ?? 'Umum' }}</td>
                                <td><span class="badge badge-info">{{ $sale->details->count() }} item</span></td>
                                <td><strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Tidak ada transaksi pada tanggal ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection