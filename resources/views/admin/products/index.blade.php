@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kelola Produk</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Produk</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Produk
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Cari produk..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="preorder" {{ request('status') == 'preorder' ? 'selected' : '' }}>Preorder</option>
                            <option value="sold_out" {{ request('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Produk 
                <span class="badge bg-primary">{{ $products->total() ?? 0 }}</span>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 35%">Produk</th>
                            <th style="width: 15%">Kategori</th>
                            <th style="width: 12%">Harga</th>
                            <th style="width: 8%">Stok</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products ?? [] as $index => $product)
                        <tr>
                            <td>{{ $products->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        <small class="text-muted">
                                            <span class="badge bg-light text-dark">{{ $product->code }}</span>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-success">{{ $product->formatted_price }}</div>
                                @if($product->discount_price)
                                <small class="text-muted text-decoration-line-through">
                                    {{ $product->formatted_discount_price }}
                                </small>
                                <span class="badge bg-danger ms-1">
                                    -{{ $product->discount_percentage }}%
                                </span>
                                @endif
                            </td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ $product->stock }}
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->status_badge }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                                @if($product->is_published)
                                    <span class="badge bg-success">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="btn btn-info"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger"
                                            onclick="deleteProduct({{ $product->id }})"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $product->id }}" 
                                      action="{{ route('admin.products.destroy', $product) }}" 
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
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <p class="mb-0">Belum ada produk</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($products) && $products->hasPages())
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div class="text-muted small">
                    Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }}
                    dari {{ $products->total() }} produk
                </div>
                <div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteProduct(id) {
    Swal.fire({
        title: 'Hapus Produk?',
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
</script>
@endpush
@endsection