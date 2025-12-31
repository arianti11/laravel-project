@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kelola Kategori</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Kategori
        </a>
    </div>

    <!-- Categories Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Kategori 
                <span class="badge bg-primary">{{ $categories->total() }}</span>
            </h6>
            
            <!-- Search -->
            <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex">
                <input type="text" 
                       name="search" 
                       class="form-control form-control-sm me-2" 
                       placeholder="Cari kategori..."
                       value="{{ request('search') }}"
                       style="width: 200px;">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary ms-2">
                    <i class="fas fa-redo"></i>
                </a>
                @endif
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 10%">Icon</th>
                            <th style="width: 25%">Nama Kategori</th>
                            <th style="width: 20%">Slug</th>
                            <th style="width: 30%">Deskripsi</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $index }}</td>
                            <td>
                                @if($category->icon)
                                <img src="{{ $category->icon_url }}" 
                                     alt="{{ $category->name }}"
                                     class="rounded"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $category->name }}</div>
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $category->products_count }} produk
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $category->slug }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ Str::limit($category->description, 50) }}
                                </small>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times-circle me-1"></i>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.categories.show', $category) }}" 
                                       class="btn btn-info"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger"
                                            onclick="deleteCategory({{ $category->id }})"
                                            title="Hapus"
                                            {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $category->id }}" 
                                      action="{{ route('admin.categories.destroy', $category) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-tags fa-3x mb-3"></i>
                                    <p class="mb-0">Belum ada kategori</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div class="text-muted small">
                    Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} 
                    dari {{ $categories->total() }} kategori
                </div>
                <div>
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info mt-3" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Info:</strong> Kategori yang memiliki produk tidak dapat dihapus. Hapus atau pindahkan produk terlebih dahulu.
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteCategory(id) {
    Swal.fire({
        title: 'Hapus Kategori?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// Show success message if exists
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif
</script>
@endpush
@endsection