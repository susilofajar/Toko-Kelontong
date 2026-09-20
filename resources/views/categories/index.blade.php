@extends('layouts.app')
@section('title', 'Manajemen Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="mb-0" style="color:var(--text-secondary);">Total: {{ $categories->count() }} kategori</h6>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $i => $cat)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $cat->name }}</strong></td>
                                <td style="color:var(--text-muted);">{{ $cat->description ?? '-' }}</td>
                                <td><span class="badge badge-info">{{ $cat->products_count }}</span></td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm"
                                        onclick="editCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description) }}')"><i
                                            class="bi bi-pencil"></i></button>
                                    <form id="delete-cat-{{ $cat->id }}" action="{{ route('categories.destroy', $cat) }}"
                                        method="POST" class="d-inline">@csrf @method('DELETE')</form>
                                    <button class="btn btn-outline-secondary btn-sm"
                                        onclick="confirmDelete('delete-cat-{{ $cat->id }}')"
                                        style="color:#ef4444;border-color:#ef4444;"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori</td>
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
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori</h5><button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nama Kategori</label><input type="text"
                                class="form-control" name="name" required></div>
                        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea class="form-control"
                                name="description" rows="3"></textarea></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary"><i
                                class="bi bi-check-lg me-1"></i>Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori</h5><button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nama Kategori</label><input type="text"
                                class="form-control" name="name" id="editName" required></div>
                        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea class="form-control"
                                name="description" id="editDesc" rows="3"></textarea></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary"><i
                                class="bi bi-check-lg me-1"></i>Perbarui</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function editCategory(id, name, desc) {
            document.getElementById('editForm').action = '/categories/' + id;
            document.getElementById('editName').value = name;
            document.getElementById('editDesc').value = desc;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
@endpush