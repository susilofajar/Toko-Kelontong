@extends('layouts.app')
@section('title', 'Stok Menipis')

@section('content')
    <div class="mb-4">
        <span class="badge badge-warning" style="font-size:0.85rem;padding:0.5rem 1rem;">
            <i class="bi bi-exclamation-triangle me-1"></i>Menampilkan produk dengan stok ≤ {{ $threshold }}
        </span>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $p->name }}</strong></td>
                                <td>{{ $p->category->name ?? '-' }}</td>
                                <td><strong>{{ $p->stock }}</strong></td>
                                <td>@if($p->stock == 0) <span class="badge badge-danger">Habis</span> @else <span
                                class="badge badge-warning">Menipis</span> @endif</td>
                                <td><a href="{{ route('inventory.stock-in') }}" class="btn btn-primary btn-sm"><i
                                            class="bi bi-plus me-1"></i>Tambah Stok</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Semua produk stoknya cukup 👍</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection