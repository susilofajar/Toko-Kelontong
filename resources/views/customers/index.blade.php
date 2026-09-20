@extends('layouts.app')
@section('title', 'Manajemen Pelanggan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="mb-0" style="color:var(--text-secondary);">Total: {{ $customers->count() }} pelanggan</h6>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i
                class="bi bi-plus-lg me-1"></i>Tambah Pelanggan</button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $i => $cust)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $cust->name }}</strong></td>
                                <td>{{ $cust->phone ?? '-' }}</td>
                                <td style="color:var(--text-muted);">{{ $cust->address ?? '-' }}</td>
                                <td><span class="badge badge-info">{{ $cust->sales_count }}</span></td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm"
                                        onclick="editCustomer({{ json_encode($cust) }})"><i class="bi bi-pencil"></i></button>
                                    <form id="delete-cust-{{ $cust->id }}" action="{{ route('customers.destroy', $cust) }}"
                                        method="POST" class="d-inline">@csrf @method('DELETE')</form>
                                    <button class="btn btn-outline-secondary btn-sm"
                                        onclick="confirmDelete('delete-cust-{{ $cust->id }}')"
                                        style="color:#ef4444;border-color:#ef4444;"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada pelanggan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('customers.store') }}" method="POST">@csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pelanggan</h5><button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control"
                                name="name" required></div>
                        <div class="mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control"
                                name="phone"></div>
                        <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control"
                                name="address" rows="2"></textarea></div>
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
                        <h5 class="modal-title">Edit Pelanggan</h5><button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control"
                                name="name" id="eName" required></div>
                        <div class="mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control"
                                name="phone" id="ePhone"></div>
                        <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control"
                                name="address" id="eAddress" rows="2"></textarea></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Perbarui</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function editCustomer(c) {
            document.getElementById('editForm').action = '/customers/' + c.id;
            document.getElementById('eName').value = c.name;
            document.getElementById('ePhone').value = c.phone || '';
            document.getElementById('eAddress').value = c.address || '';
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
@endpush