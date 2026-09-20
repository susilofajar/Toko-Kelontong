@extends('layouts.app')
@section('title', 'Stok Keluar')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><i class="bi bi-box-arrow-up me-2"></i>Form Stok Keluar</div>
                <div class="card-body">
                    <form action="{{ route('inventory.process-stock-out') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Produk <span class="text-danger">*</span></label>
                            <select class="form-select @error('product_id') is-invalid @enderror" name="product_id"
                                required>
                                <option value="">Pilih Produk</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }} (Stok: {{ $p->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                name="quantity" min="1" required value="{{ old('quantity') }}">
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alasan <span class="text-danger">*</span></label>
                            <select class="form-select" name="reason" required>
                                <option value="">Pilih Alasan</option>
                                <option value="Barang rusak">Barang Rusak</option>
                                <option value="Barang kadaluarsa">Barang Kadaluarsa</option>
                                <option value="Barang hilang">Barang Hilang</option>
                                <option value="Retur ke supplier">Retur ke Supplier</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" name="note" rows="2"
                                placeholder="Keterangan tambahan...">{{ old('note') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Proses Stok
                            Keluar</button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection