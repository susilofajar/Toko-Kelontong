@extends('layouts.app')
@section('title', 'Laporan Bulanan')

@section('content')
    <div class="row g-3 mb-4 align-items-end">
        <div class="col-12 col-md-auto">
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <form class="d-flex gap-2" method="GET">
                    <input type="month" class="form-control" name="month" value="{{ $month }}"
                        onchange="this.form.submit()">
                </form>
                <a href="{{ route('reports.monthly.pdf', ['month' => $month]) }}" class="btn btn-outline-secondary btn-sm">
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

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header"><i class="bi bi-bar-chart-fill me-2" style="color:#818cf8;"></i>Grafik Penjualan
                    Harian</div>
                <div class="card-body"><canvas id="monthlyChart" height="300"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header">Detail per Hari</div>
                <div class="card-body p-0" style="max-height:400px;overflow-y:auto;">
                    @forelse($dailySales as $ds)
                        <div class="d-flex justify-content-between align-items-center px-3 py-2"
                            style="border-bottom:1px solid var(--border-color);">
                            <div><span
                                    style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($ds->date)->format('d M') }}</span><br><small
                                    class="text-muted">{{ $ds->transactions }} transaksi</small></div>
                            <strong style="color:var(--success);font-size:0.85rem;">Rp
                                {{ number_format($ds->total, 0, ',', '.') }}</strong>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">Tidak ada data</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            const style = getComputedStyle(document.body);
            const textColor = style.getPropertyValue('--text-muted').trim() || '#a1a1aa';
            const gridColor = style.getPropertyValue('--border-color').trim() || 'rgba(51,65,85,0.5)';

            new Chart(ctx, {
                type: 'bar',
                data: { labels: @json($chartLabels), datasets: [{ label: 'Penjualan (Rp)', data: @json($chartData), backgroundColor: 'rgba(99, 102, 241, 0.6)', borderColor: '#818cf8', borderWidth: 1, borderRadius: 6 }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { color: textColor, callback: v => 'Rp ' + v.toLocaleString('id-ID') }, grid: { color: gridColor } }, x: { ticks: { color: textColor }, grid: { display: false } } },
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
@endpush