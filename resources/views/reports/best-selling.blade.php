@extends('layouts.app')
@section('title', 'Produk Terlaris')

@section('content')
    <div class="mb-4">
        <form class="d-flex gap-2" method="GET">
            <select class="form-select" name="period" style="width:180px;" onchange="this.form.submit()">
                <option value="all" {{ $period == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Tahun Ini</option>
            </select>
        </form>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><i class="bi bi-trophy-fill me-2" style="color:#f59e0b;"></i>Top 20 Produk Terlaris
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Terjual</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSelling as $i => $item)
                                    <tr>
                                        <td>
                                            @if($i < 3)
                                                <span class="badge badge-warning" style="font-size:0.8rem;">🏆 {{ $i + 1 }}</span>
                                            @else
                                                <span class="badge badge-primary">{{ $i + 1 }}</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $item->product->name ?? '-' }}</strong></td>
                                        <td><span class="badge badge-info">{{ $item->product->category->name ?? '-' }}</span>
                                        </td>
                                        <td><strong>{{ $item->total_qty }}</strong> unit</td>
                                        <td style="color:var(--success);"><strong>Rp
                                                {{ number_format($item->total_revenue, 0, ',', '.') }}</strong></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data penjualan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Grafik</div>
                <div class="card-body"><canvas id="bestSellingChart" height="300"></canvas></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        const labels = @json($bestSelling->map(fn($i) => $i->product->name ?? '-')->take(5)->values());
        const data = @json($bestSelling->pluck('total_qty')->take(5)->values());
        const colors = ['#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe', '#e0e7ff'];

        const style = getComputedStyle(document.body);
        const labelColor = style.getPropertyValue('--text-muted').trim() || '#94a3b8';
        const bgTint = style.getPropertyValue('--bg-card').trim() || '#1e293b';

        new Chart(document.getElementById('bestSellingChart'), {
            type: 'doughnut',
            data: { labels, datasets: [{ data, backgroundColor: colors, borderColor: bgTint, borderWidth: 2 }] },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { color: labelColor, font: { size: 11 }, padding: 15 } } }
            }
        });
    </script>
@endpush