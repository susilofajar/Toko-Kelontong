@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><i class="bi bi-pencil-square me-2"></i>Edit Produk: {{ $product->name }}</div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name', $product->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Barcode</label>
                                <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                                    name="barcode" value="{{ old('barcode', $product->barcode) }}">
                                @error('barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <select class="form-select" name="supplier_id">
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $sup)
                                        <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Harga Beli <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="purchase_price"
                                    value="{{ old('purchase_price', $product->purchase_price) }}" required min="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="selling_price"
                                    value="{{ old('selling_price', $product->selling_price) }}" required min="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stock"
                                    value="{{ old('stock', $product->stock) }}" required min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Gambar Produk</label>
                                @if($product->image)
                                    <div class="mb-2"><img src="{{ asset('storage/' . $product->image) }}"
                                            style="max-height:100px;border-radius:12px;"></div>
                                @endif
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i
                                    class="bi bi-check-lg me-1"></i>Perbarui</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection