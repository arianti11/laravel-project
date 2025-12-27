@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Kategori</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Category Info -->
        <div class="col-lg-4">
            <!-- Main Info Card -->
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <!-- Icon -->
                    @if($category->icon)
                    <img src="{{ $category->icon_url }}" 
                         alt="{{ $category->name }}"
                         class="img-thumbnail mb-3"
                         style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                    <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                    @endif

                    <!-- Name -->
                    <h4 class="mb-2">{{ $category->name }}</h4>
                    
                    <!-- Status Badge -->
                    @if($category->is_active)
                        <span class="badge bg-success mb-3">
                            <i class="fas fa-check-circle me-1"></i> Aktif
                        </span>
                    @else
                        <span class="badge bg-secondary mb-3">
                            <i class="fas fa-times-circle me-1"></i> Nonaktif
                        </span>
                    @endif

                    <!-- Slug -->
                    <div class="mb-3">
                        <small class="text-muted">Slug:</small>
                        <div class="badge bg-light text-dark">{{ $category->slug }}</div>
                    </div>

                    <!-- Description -->
                    @if($category->description)
                    <div class="text-start">
                        <small class="text-muted">Deskripsi:</small>
                        <p class="small mb-0">{{ $category->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Total Produk</small>
                                <div class="h3 mb-0 text-primary">
                                    {{ $category->products_count }}
                                </div>
                            </div>
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Dibuat:</small>
                        <div class="fw-bold">{{ $category->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Update Terakhir:</small>
                        <div class="fw-bold">{{ $category->updated_at->format('d M Y, H:i') }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Update:</small>
                        <div class="fw-bold">{{ $category->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products List -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Produk dalam Kategori Ini
                        <span class="badge bg-primary">{{ $products->total() }}</span>
                    </h6>
                    <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Produk
                    </a>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $product->image_url }}" 
                                                 alt="{{ $product->name }}"
                                                 class="rounded me-2"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold">{{ Str::limit($product->name, 30) }}</div>
                                                <small class="text-muted">{{ $product->code }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">{{ $product->formatted_price }}</div>
                                        @if($product->discount_price)
                                        <small class="text-muted text-decoration-line-through">
                                            {{ $product->formatted_discount_price }}
                                        </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $product->status_badge }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
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
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                    @endif

                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-3">Belum ada produk dalam kategori ini</p>
                        <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Tambah Produk Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection