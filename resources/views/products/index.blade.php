@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div class="w-100" style="max-width: 500px;">
            <form class="d-flex flex-column flex-sm-row gap-2" method="GET">
                <input type="text" class="form-control" name="search" placeholder="Cari produk atau barcode..."
                    value="{{ request('search') }}">
                <select class="form-select" name="category_id" style="min-width: 150px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary flex-shrink-0">
            <i class="bi bi-plus-lg me-1"></i>Tambah Produk
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Barcode</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $i => $product)
                            <tr>
                                <td>{{ $products->firstItem() + $i }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                            style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
                                    @else
                                        <div
                                            style="width:40px;height:40px;border-radius:8px;background:var(--border-color);display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-image" style="color:var(--text-muted);"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td><span class="badge badge-primary">{{ $product->category->name ?? '-' }}</span></td>
                                <td style="font-family:monospace;font-size:0.8rem;">{{ $product->barcode ?? '-' }}</td>
                                <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="badge badge-danger">{{ $product->stock }}</span>
                                    @elseif($product->stock <= 10)
                                        <span class="badge badge-warning">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary btn-sm"><i
                                            class="bi bi-pencil"></i></a>
                                    <form id="delete-{{ $product->id }}" action="{{ route('products.destroy', $product) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button class="btn btn-outline-secondary btn-sm"
                                        onclick="confirmDelete('delete-{{ $product->id }}')"
                                        style="color:#ef4444;border-color:#ef4444;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Belum ada produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $products->withQueryString()->links() }}</div>
@endsection