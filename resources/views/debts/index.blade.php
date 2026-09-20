@extends('layouts.app')
@section('title', 'Buku Hutang (Kasbon)')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h1 class="h3 mb-0" style="font-weight: 700; letter-spacing: -0.02em;">Buku Hutang</h1>

        <div class="d-flex w-100 justify-content-md-end" style="max-width: 500px;">
            <form method="GET" class="row g-2 w-100 m-0">
                <div class="col-12 col-sm-auto flex-grow-1">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="belum_lunas" {{ request('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas
                        </option>
                        <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <div class="col-12 col-sm-auto flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent text-muted"
                            style="border-right: none; border-color: var(--input-border);"><i
                                class="bi bi-person-bounding-box"></i></span>
                        <input type="text" name="search" class="form-control" style="border-left: none;"
                            placeholder="Cari Pelanggan..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-12 col-sm-auto mt-2 mt-sm-0">
                    <button type="submit" class="btn btn-primary w-100 px-4"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-md mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total Hutang</th>
                            <th>Telah Dibayar</th>
                            <th>Sisa Hutang</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($debts as $debt)
                            @php
                                $remaining = max(0, $debt->total_amount - $debt->payment_amount);
                                $isOverdue = $debt->due_date && \Carbon\Carbon::parse($debt->due_date)->isPast() && $debt->payment_status !== 'lunas';
                            @endphp
                            <tr>
                                <td><a href="{{ route('sales.show', $debt->id) }}"
                                        style="color:var(--primary); font-weight: 600; text-decoration: none;">{{ $debt->invoice_number }}</a>
                                </td>
                                <td>{{ $debt->created_at->format('d M Y') }}</td>
                                <td>{{ $debt->customer->name ?? '-' }}</td>
                                <td>Rp {{ number_format($debt->total_amount, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($debt->payment_amount, 0, ',', '.') }}</td>
                                <td class="text-danger fw-bold">Rp {{ number_format($remaining, 0, ',', '.') }}</td>
                                <td>
                                    @if($debt->due_date)
                                        <span class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                            {{ \Carbon\Carbon::parse($debt->due_date)->format('d M Y') }}
                                            @if($isOverdue) <i class="bi bi-exclamation-triangle"></i> @endif
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($debt->payment_status === 'lunas')
                                        <span class="badge"
                                            style="background: rgba(16, 185, 129, 0.1); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2);">Lunas</span>
                                    @else
                                        <span class="badge"
                                            style="background: rgba(245, 158, 11, 0.1); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2);">Belum
                                            Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    @if($debt->payment_status !== 'lunas')
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#payModal{{ $debt->id }}">
                                            <i class="bi bi-wallet2"></i> Bayar
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Repayment Modal -->
                            @if($debt->payment_status !== 'lunas')
                                <div class="modal fade" id="payModal{{ $debt->id }}" tabindex="-1"
                                    aria-labelledby="payModalLabel{{ $debt->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="payModalLabel{{ $debt->id }}">Catat Pembayaran Hutang
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('debts.pay', $debt->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Pelanggan</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $debt->customer->name ?? '-' }}" readonly
                                                            style="background-color: var(--bg-body); border-color: var(--input-border);">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Sisa Hutang</label>
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-transparent text-danger fw-bold border-end-0"
                                                                style="border-color: var(--input-border);">Rp</span>
                                                            <input type="text"
                                                                class="form-control text-danger fw-bold border-start-0 ps-0"
                                                                value="{{ number_format($remaining, 0, ',', '.') }}" readonly
                                                                style="background-color: var(--bg-body); font-size: 1.15rem; border-color: var(--input-border);">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="payment_amount" class="form-label">Jumlah Pembayaran <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-transparent text-muted border-end-0"
                                                                style="border-color: var(--input-border);">Rp</span>
                                                            <input type="number" class="form-control border-start-0 ps-0"
                                                                name="payment_amount" id="payment_amount" required min="1"
                                                                max="{{ $remaining }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="note" class="form-label">Catatan (Opsional)</label>
                                                        <textarea class="form-control" name="note" id="note" rows="2"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary px-4"><i
                                                            class="bi bi-save me-2"></i>Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Tidak ada data hutang pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end pb-0">
                {{ $debts->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection