@extends('layouts.app')
@section('title', 'Pengaturan Toko')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><i class="bi bi-gear-fill me-2"></i>Pengaturan Toko</div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Toko <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('store_name') is-invalid @enderror"
                                name="store_name" value="{{ old('store_name', $settings['store_name']) }}" required>
                            @error('store_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="store_address"
                                rows="2">{{ old('store_address', $settings['store_address']) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" class="form-control" name="store_phone"
                                    value="{{ old('store_phone', $settings['store_phone']) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="store_email"
                                    value="{{ old('store_email', $settings['store_email']) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Batas Stok Menipis <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror"
                                name="low_stock_threshold"
                                value="{{ old('low_stock_threshold', $settings['low_stock_threshold']) }}" required min="1">
                            @error('low_stock_threshold')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small style="color:var(--text-muted);">Produk dengan stok dibawah angka ini akan ditampilkan
                                sebagai peringatan</small>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan
                            Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection