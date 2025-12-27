@extends('layouts.staff')

@section('title', 'Kelola Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">Kelola Produk</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Produk</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('staff.products.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus-circle me-2"></i> Tambah Produk Baru
        </a>
    </div>

    <!-- Filters & Search Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('staff.products.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small text-muted mb-1">Cari Produk</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Nama produk atau kode..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Kategori</label>
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
                        <label class="form-label small text-muted mb-1">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="preorder" {{ request('status') == 'preorder' ? 'selected' : '' }}>Preorder</option>
                            <option value="sold_out" {{ request('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @forelse($products ?? [] as $product)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm hover-shadow">
                <!-- Product Image -->
                <div class="position-relative">
                    <img src="{{ $product->image_url }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 200px; object-fit: cover;">
                    
                    <!-- Badges -->
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-{{ $product->status_badge }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                    <div class="position-absolute top-0 end-0 m-2">
                        @if($product->discount_price)
                        <span class="badge bg-danger">
                            -{{ $product->discount_percentage }}%
                        </span>
                        @endif
                    </div>
                    
                    <!-- Stock Badge -->
                    <div class="position-absolute bottom-0 start-0 m-2">
                        @if($product->stock > 10)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Stok: {{ $product->stock }}
                            </span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Stok: {{ $product->stock }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle me-1"></i>
                                Stok Habis
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="card-body">
                    <!-- Category -->
                    <div class="mb-2">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-tag me-1"></i>
                            {{ $product->category->name }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h6 class="card-title mb-2">
                        {{ Str::limit($product->name, 40) }}
                    </h6>

                    <!-- Product Code -->
                    <p class="text-muted small mb-2">
                        <i class="fas fa-barcode me-1"></i>
                        {{ $product->code }}
                    </p>

                    <!-- Price -->
                    <div class="mb-3">
                        @if($product->discount_price)
                            <div class="d-flex align-items-center gap-2">
                                <span class="h5 mb-0 text-success fw-bold">
                                    {{ $product->formatted_discount_price }}
                                </span>
                                <small class="text-muted text-decoration-line-through">
                                    {{ $product->formatted_price }}
                                </small>
                            </div>
                        @else
                            <span class="h5 mb-0 text-success fw-bold">
                                {{ $product->formatted_price }}
                            </span>
                        @endif
                    </div>

                    <!-- Views & Published Status -->
                    <div class="d-flex justify-content-between text-muted small">
                        <span>
                            <i class="fas fa-eye me-1"></i>
                            {{ $product->views }} views
                        </span>
                        <span>
                            @if($product->is_published)
                                <i class="fas fa-check-circle text-success me-1"></i>
                                Published
                            @else
                                <i class="fas fa-times-circle text-danger me-1"></i>
                                Draft
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white border-top-0">
                    <div class="d-grid gap-2">
                        <a href="{{ route('staff.products.edit', $product) }}" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Edit Produk
                        </a>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('staff.products.show', $product) }}" 
                               class="btn btn-outline-info">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                            <button type="button" 
                                    class="btn btn-outline-primary"
                                    onclick="copyProductLink('{{ url('/products/' . $product->slug) }}')">
                                <i class="fas fa-link me-1"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada produk</h5>
                    <p class="text-muted mb-4">Mulai tambahkan produk untuk ditampilkan di sini</p>
                    <a href="{{ route('staff.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Produk Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($products) && $products->hasPages())
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} 
                    dari {{ $products->total() }} produk
                </div>
                <div>
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function copyProductLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Link produk berhasil disalin',
            timer: 2000,
            showConfirmButton: false
        });
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

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection