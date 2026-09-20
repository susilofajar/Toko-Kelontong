@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(34,197,94,0.15);color:#22c55e;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-value" style="color:#22c55e;">Rp {{ number_format($salesToday, 0, ',', '.') }}</div>
                <div class="stat-label">Penjualan Hari Ini</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(99,102,241,0.15);color:#818cf8;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="stat-value" style="color:#818cf8;">{{ $transactionsToday }}</div>
                <div class="stat-label">Transaksi Hari Ini</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(6,182,212,0.15);color:#06b6d4;">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div class="stat-value" style="color:#06b6d4;">{{ $totalProducts }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:#f59e0b;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="stat-value" style="color:#f59e0b;">{{ $lowStockCount }}</div>
                <div class="stat-label">Stok Menipis</div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-bar-chart-fill me-2" style="color:#818cf8;"></i>Grafik Penjualan Bulanan</span>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-trophy-fill me-2" style="color:#f59e0b;"></i>Produk Terlaris
                </div>
                <div class="card-body p-0">
                    @forelse($bestSelling as $index => $item)
                        <div class="d-flex align-items-center justify-content-between px-3 py-2"
                            style="border-bottom:1px solid var(--border-color);">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-pill {{ $index < 3 ? 'badge-warning' : 'badge-primary' }}"
                                    style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:0.7rem;">{{ $index + 1 }}</span>
                                <span style="font-size:0.85rem;">{{ $item->product->name ?? '-' }}</span>
                            </div>
                            <span class="badge badge-success" style="font-size:0.75rem;">{{ $item->total_qty }} terjual</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted" style="font-size:0.85rem;">
                            <i class="bi bi-inbox" style="font-size:2rem;"></i><br>Belum ada data penjualan
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    @if($lowStockProducts->count() > 0)
        <div class="card">
            <div class="card-header">
                <i class="bi bi-exclamation-triangle-fill me-2" style="color:#f59e0b;"></i>Peringatan Stok Menipis
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td><strong>{{ $product->stock }}</strong></td>
                                    <td>
                                        @if($product->stock == 0)
                                            <span class="badge badge-danger">Habis</span>
                                        @else
                                            <span class="badge badge-warning">Menipis</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.01)');

            // Extract colors from CSS vars
            const style = getComputedStyle(document.body);
            const textColor = style.getPropertyValue('--text-muted').trim() || '#64748b';
            const gridColor = style.getPropertyValue('--border-color').trim() || 'rgba(51, 65, 85, 0.5)';

            let chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: @json($chartData),
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#818cf8',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#818cf8',
                        pointBorderColor: '#1e293b',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                                callback: function (val) { return 'Rp ' + val.toLocaleString('id-ID'); }
                            },
                            grid: { color: gridColor }
                        },
                        x: {
                            ticks: { color: textColor },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) { return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID'); }
                            }
                        }
                    }
                }
            });

            // Listen for theme changes to update chart colors dynamically
            const observer = new MutationObserver(function () {
                const newStyle = getComputedStyle(document.body);
                const newTextColor = newStyle.getPropertyValue('--text-muted').trim();
                const newGridColor = newStyle.getPropertyValue('--border-color').trim();

                chart.options.scales.x.ticks.color = newTextColor;
                chart.options.scales.y.ticks.color = newTextColor;
                chart.options.scales.y.grid.color = newGridColor;
                chart.update();
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
        });
    </script>
@endpush