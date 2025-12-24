@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* Custom Styles untuk Dashboard */
    .welcome-card {
        background: linear-gradient(135deg, #8B6F47 0%, #6d5637 100%);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .stats-card {
        border-radius: 15px;
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: var(--card-color);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    
    .product-img {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .quick-action-btn {
        border-radius: 12px;
        padding: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .quick-action-btn:hover {
        transform: translateX(5px);
    }
    
    .category-item {
        padding: 1rem;
        border-radius: 10px;
        background: #f8f9fa;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .category-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }
</style>
@endpush

@section('content')
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card text-white p-4 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-2">
                        <i class="fas fa-hand-sparkles me-2"></i>
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h3>
                    <p class="mb-3 opacity-90">
                        Kelola produk kerajinan tangan Anda dengan mudah dan efisien
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Tambah Produk
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-list me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="fas fa-chart-line" style="font-size: 8rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <!-- Total Produk -->
    <div class="col-sm-6 col-xl-3 mb-3">
        <div class="card stats-card shadow-sm" style="--card-color: #667eea;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon flex-shrink-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-muted text-uppercase small fw-semibold mb-1">Total Produk</div>
                        <div class="h3 fw-bold mb-0">{{ $totalProducts ?? 0 }}</div>
                        <div class="text-success small mt-1">
                            <i class="fas fa-arrow-up"></i> 12% dari bulan lalu
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-sm-6 col-xl-3 mb-3">
        <div class="card stats-card shadow-sm" style="--card-color: #f093fb;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon flex-shrink-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-muted text-uppercase small fw-semibold mb-1">Kategori</div>
                        <div class="h3 fw-bold mb-0">{{ $totalCategories ?? 0 }}</div>
                        <div class="text-info small mt-1">
                            <i class="fas fa-minus"></i> Tidak ada perubahan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Rendah -->
    <div class="col-sm-6 col-xl-3 mb-3">
        <div class="card stats-card shadow-sm" style="--card-color: #ff6b6b;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon flex-shrink-0" style="background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-muted text-uppercase small fw-semibold mb-1">Stok Rendah</div>
                        <div class="h3 fw-bold mb-0">{{ $lowStockProducts ?? 0 }}</div>
                        <div class="text-warning small mt-1">
                            <i class="fas fa-exclamation"></i> Perlu perhatian
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="col-sm-6 col-xl-3 mb-3">
        <div class="card stats-card shadow-sm" style="--card-color: #48dbfb;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon flex-shrink-0" style="background: linear-gradient(135deg, #48dbfb 0%, #0abde3 100%);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-muted text-uppercase small fw-semibold mb-1">Pengguna</div>
                        <div class="h3 fw-bold mb-0">{{ $totalUsers ?? 0 }}</div>
                        <div class="text-success small mt-1">
                            <i class="fas fa-arrow-up"></i> 5% dari bulan lalu
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Produk Terbaru -->
    <div class="col-xl-8 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div>
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-box text-primary me-2"></i>Produk Terbaru
                    </h5>
                    <small class="text-muted">Produk yang baru ditambahkan</small>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($latestProducts ?? [] as $product)
                <div class="d-flex align-items-center p-3 border-bottom">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img me-3">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold">{{ $product->name }}</h6>
                        <div class="d-flex align-items-center gap-3">
                            <small class="text-muted">
                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-barcode me-1"></i>{{ $product->code }}
                            </small>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-primary mb-1">{{ $product->formatted_price }}</div>
                        <span class="badge {{ $product->stock < 10 ? 'bg-danger' : 'bg-success' }}">
                            <i class="fas fa-cubes me-1"></i>Stok: {{ $product->stock }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted mb-3">Belum ada produk</h6>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-xl-4">
        <!-- Quick Actions -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary quick-action-btn w-100 mb-2">
                    <i class="fas fa-plus me-2"></i>Tambah Produk Baru
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary quick-action-btn w-100 mb-2">
                    <i class="fas fa-folder-plus me-2"></i>Tambah Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary quick-action-btn w-100">
                    <i class="fas fa-list me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>

        <!-- Kategori Populer -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-star text-warning me-2"></i>Kategori Populer
                </h5>
            </div>
            <div class="card-body">
                @forelse($popularCategories ?? [] as $category)
                <div class="category-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-folder text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->products_count }} produk</small>
                            </div>
                        </div>
                        <span class="badge bg-primary rounded-pill">
                            {{ $category->products_count }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-2">Belum ada kategori</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Kategori
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Auto refresh stats setiap 5 menit
    setInterval(function() {
        console.log('Stats will be refreshed...');
    }, 300000);
</script>
@endpush