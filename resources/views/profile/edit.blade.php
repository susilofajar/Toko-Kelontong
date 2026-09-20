@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-person-circle me-2"></i>Informasi Profil</div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="text-center mb-4">
                            <div class="user-avatar mx-auto"
                                style="width:80px;height:80px;font-size:2rem;background:linear-gradient(135deg,var(--primary),#a855f7);border-radius:20px;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div class="mt-2">
                                <span class="badge badge-primary"
                                    style="font-size:0.8rem;padding:0.4rem 0.8rem;text-transform:capitalize;">{{ $user->role }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled
                                style="opacity:0.6;">
                            <small style="color:var(--text-muted);">Email tidak dapat diubah</small>
                        </div>

                        <hr style="border-color:var(--border-color);margin:1.5rem 0;">
                        <h6 style="color:var(--text-secondary);margin-bottom:1rem;"><i
                                class="bi bi-shield-lock me-1"></i>Ganti Password</h6>
                        <small class="d-block mb-3" style="color:var(--text-muted);">Kosongkan jika tidak ingin mengubah
                            password</small>

                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    name="new_password">
                                @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="new_password_confirmation">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan
                            Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection