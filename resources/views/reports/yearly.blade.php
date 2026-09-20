@extends('layouts.app')
@section('title', 'Laporan Tahunan')

@section('content')
    <div class="row g-3 mb-4 align-items-end">
        <div class="col-12 col-md-auto">
            <form class="d-flex gap-2" method="GET">
                <select class="form-select" name="year" onchange="this.form.submit()" style="width:130px;">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
        <div class="col-12 col-md">
            <div class="row g-2">
                <div class="col-6 col-md-auto ms-md-auto">
                    <div class="stat-card" style="padding:0.75rem 1.25rem;">
                        <div class="stat-label">Total Penjualan</div>
                        <div class="stat-value" style="font-size:1.15rem;color:var(--success);">Rp
                            {{ number_format($totalSales, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-auto">
                    <div class="stat-card" style="padding:0.75rem 1.25rem;">
                        <div class="stat-label">Transaksi</div>
                        <div class="stat-value" style="font-size:1.15rem;color:var(--primary-light);">
                            {{ $totalTransactions }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-bar-chart-fill me-2" style="color:#818cf8;"></i>Grafik Penjualan Tahun
            {{ $year }}
        </div>
        <div class="card-body"><canvas id="yearlyChart" height="300"></canvas></div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header">Detail per Bulan</div>
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Transaksi</th>
                            <th>Total Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']; @endphp
                        @forelse($monthlySales as $ms)
                            <tr>
                                <td><strong>{{ $months[$ms->month] ?? $ms->month }} {{ $year }}</strong></td>
                                <td>{{ $ms->transactions }}</td>
                                <td style="color:var(--success);"><strong>Rp
                                        {{ number_format($ms->total, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('yearlyChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.01)');
            const style = getComputedStyle(document.body);
            const textColor = style.getPropertyValue('--text-muted').trim() || '#a1a1aa';
            const gridColor = style.getPropertyValue('--border-color').trim() || 'rgba(51,65,85,0.5)';

            new Chart(ctx, {
                type: 'line',
                data: { labels: @json($chartLabels), datasets: [{ label: 'Penjualan (Rp)', data: @json($chartData), fill: true, backgroundColor: gradient, borderColor: '#818cf8', borderWidth: 2, tension: 0.4, pointRadius: 5, pointBackgroundColor: '#818cf8' }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { color: textColor, callback: v => 'Rp ' + v.toLocaleString('id-ID') }, grid: { color: gridColor } }, x: { ticks: { color: textColor }, grid: { display: false } } },
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
@endpush