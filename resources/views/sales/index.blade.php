@extends('layouts.app')
@section('title', 'Riwayat Penjualan')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h1 class="h3 mb-0" style="font-weight: 700;">Riwayat Penjualan</h1>
        <form class="row g-2 align-items-center m-0" method="GET">
            <div class="col-12 col-sm-auto flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-transparent text-muted"
                        style="border-right: none; border-color: var(--input-border);"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" name="search" style="border-left: none;"
                        placeholder="Cari No. Invoice..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-sm-auto">
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-6 col-sm-auto">
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-12 col-sm-auto d-flex gap-2">
                <button class="btn btn-primary w-100 px-4"><i class="bi bi-filter"></i> Filter</button>
                @if(request()->hasAny(['search', 'date_from', 'date_to']))
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-x-lg"></i>
                        Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-md" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $i => $sale)
                            <tr>
                                <td>{{ $sales->firstItem() + $i }}</td>
                                <td><code style="color:var(--primary-light);">{{ $sale->invoice_number }}</code></td>
                                <td style="color:var(--text-muted);">{{ $sale->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $sale->user->name ?? '-' }}</td>
                                <td>{{ $sale->customer->name ?? 'Umum' }}</td>
                                <td><span class="badge"
                                        style="background: rgba(14, 165, 233, 0.1); color: var(--info); border: 1px solid rgba(14, 165, 233, 0.2); font-weight: 500;">{{ $sale->details->count() }}
                                        item</span></td>
                                <td><strong style="color:var(--success);">Rp
                                        {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm"
                                            style="background: rgba(99,102,241,0.1); color: var(--primary); border: none;"
                                            onclick="showDetail({{ $sale->id }})" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('pos.receipt', $sale) }}" target="_blank" class="btn btn-sm"
                                            style="background: rgba(16,185,129,0.1); color: var(--success); border: none;"
                                            title="Cetak Struk">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $sales->withQueryString()->links() }}</div>

    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title"><i class="bi bi-receipt-cutoff me-2" style="color: var(--primary);"></i>Detail
                        Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3" id="detailBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showDetail(saleId) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const body = document.getElementById('detailBody');
            body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>';
            modal.show();

            fetch('/sales/' + saleId)
                .then(r => r.json())
                .then(data => {
                    let itemsHtml = '';
                    data.items.forEach((item, i) => {
                        itemsHtml += `<tr>
                        <td>${i + 1}</td>
                        <td>${item.name}</td>
                        <td class="text-center">${item.quantity}</td>
                        <td class="text-end">Rp ${parseInt(item.unit_price).toLocaleString('id-ID')}</td>
                        <td class="text-end"><strong>Rp ${parseInt(item.subtotal).toLocaleString('id-ID')}</strong></td>
                    </tr>`;
                    });

                    body.innerHTML = `
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: var(--bg-body); border: 1px solid var(--border-color);">
                                <div class="mb-2"><small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Nomor Invoice</small><br><strong><code style="color:var(--primary-light); font-size: 1rem;">${data.invoice_number}</code></strong></div>
                                <div><small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Waktu Transaksi</small><br><span style="font-weight: 500;">${data.date}</span></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: var(--bg-body); border: 1px solid var(--border-color);">
                                <div class="mb-2"><small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Kasir Bertugas</small><br><span style="font-weight: 500;"><i class="bi bi-person-badge me-1 text-muted"></i>${data.cashier}</span></div>
                                <div><small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pelanggan</small><br><span style="font-weight: 500;"><i class="bi bi-person me-1 text-muted"></i>${data.customer}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive border rounded-3 mb-4" style="border-color: var(--border-color) !important;">
                        <table class="table mb-0 align-middle">
                            <thead style="background: var(--bg-body);">
                                <tr><th class="ps-3 border-bottom-0">#</th><th class="border-bottom-0">Produk</th><th class="text-center border-bottom-0">Qty</th><th class="text-end border-bottom-0">Harga</th><th class="text-end pe-3 border-bottom-0">Subtotal</th></tr>
                            </thead>
                            <tbody>${itemsHtml}</tbody>
                        </table>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-lg-5">
                            <div class="p-4 rounded-4 shadow-sm" style="background: var(--bg-body); border: 1px solid var(--border-color);">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-medium">Total Harga</span>
                                    <strong class="fs-5" style="color:var(--primary-light);">Rp ${parseInt(data.total_amount).toLocaleString('id-ID')}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
                                    <span class="text-muted">Nominal Bayar</span>
                                    <span>Rp ${parseInt(data.payment_amount).toLocaleString('id-ID')}</span>
                                </div>
                                <div class="d-flex justify-content-between pt-1">
                                    <span class="text-muted fw-medium">Kembalian</span>
                                    <span style="color:var(--info); font-weight: 600; font-size: 1.1rem;">Rp ${parseInt(data.change_amount).toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                })
                .catch(() => {
                    body.innerHTML = '<div class="text-center py-4 text-danger">Gagal memuat data</div>';
                });
        }
    </script>
@endpush