@extends('layouts.app')
@section('title', 'Riwayat Stok')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="d-flex gap-2" method="GET">
            <select class="form-select" name="type" style="width:150px;" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stok Masuk</option>
                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stok Keluar</option>
            </select>
        </form>
        <a href="{{ route('inventory.stock-in') }}" class="btn btn-primary"><i class="bi bi-box-arrow-in-down me-1"></i>Stok
            Masuk</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Catatan</th>
                            <th>Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $i => $m)
                            <tr>
                                <td>{{ $movements->firstItem() + $i }}</td>
                                <td style="color:var(--text-muted);">{{ $m->created_at->format('d M Y H:i') }}</td>
                                <td><strong>{{ $m->product->name ?? '-' }}</strong></td>
                                <td>
                                    @if($m->type == 'in') <span class="badge badge-success"><i
                                        class="bi bi-arrow-down-circle me-1"></i>Masuk</span>
                                    @else <span class="badge badge-danger"><i
                                        class="bi bi-arrow-up-circle me-1"></i>Keluar</span>
                                    @endif
                                </td>
                                <td><strong>{{ $m->quantity }}</strong></td>
                                <td style="color:var(--text-muted);font-size:0.8rem;">{{ $m->note ?? '-' }}</td>
                                <td>{{ $m->user->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada pergerakan stok</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $movements->withQueryString()->links() }}</div>
@endsection