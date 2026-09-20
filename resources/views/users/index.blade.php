@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="mb-0" style="color:var(--text-secondary);">Total: {{ $users->count() }} user</h6>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i
                class="bi bi-plus-lg me-1"></i>Tambah User</button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin') <span class="badge badge-primary">Admin</span>
                                    @elseif($user->role == 'cashier') <span class="badge badge-success">Kasir</span>
                                    @else <span class="badge badge-warning">Owner</span>
                                    @endif
                                </td>
                                <td style="color:var(--text-muted);">{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm"
                                        onclick="editUser({{ json_encode($user) }})"><i class="bi bi-pencil"></i></button>
                                    @if($user->id !== auth()->id())
                                        <form id="delete-user-{{ $user->id }}" action="{{ route('users.destroy', $user) }}"
                                            method="POST" class="d-inline">@csrf @method('DELETE')</form>
                                        <button class="btn btn-outline-secondary btn-sm"
                                            onclick="confirmDelete('delete-user-{{ $user->id }}')"
                                            style="color:#ef4444;border-color:#ef4444;"><i class="bi bi-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">@csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User</h5><button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control"
                                name="name" required></div>
                        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control"
                                name="email" required></div>
                        <div class="mb-3"><label class="form-label">Password</label><input type="password"
                                class="form-control" name="password" required minlength="6"></div>
                        <div class="mb-3"><label class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="cashier">Kasir</option>
                                <option value="admin">Admin</option>
                                <option value="owner">Owner</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">@csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5><button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control"
                                name="name" id="eName" required></div>
                        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control"
                                name="email" id="eEmail" required></div>
                        <div class="mb-3"><label class="form-label">Password <small
                                    style="color:var(--text-muted);">(kosongkan jika tidak diubah)</small></label><input
                                type="password" class="form-control" name="password" minlength="6"></div>
                        <div class="mb-3"><label class="form-label">Role</label>
                            <select class="form-select" name="role" id="eRole" required>
                                <option value="cashier">Kasir</option>
                                <option value="admin">Admin</option>
                                <option value="owner">Owner</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Perbarui</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function editUser(u) {
            document.getElementById('editForm').action = '/users/' + u.id;
            document.getElementById('eName').value = u.name;
            document.getElementById('eEmail').value = u.email;
            document.getElementById('eRole').value = u.role;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
@endpush