@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
                        <p class="mb-0 opacity-75">Kelola produk kerajinan tangan Anda dengan mudah</p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fas fa-hand-sparkles fa-4x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Total Produk -->
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-box text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-body-secondary text-uppercase fw-semibold small">Total Produk</div>
                        <div class="fs-4 fw-semibold">{{ $totalProducts ?? 0 }}</div>
                        <div class="text-success small">
                            <i class="fas fa-arrow-up"></i> 12% dari bulan lalu
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-folder text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-body-secondary text-uppercase fw-semibold small">Kategori</div>
                        <div class="fs-4 fw-semibold">{{ $totalCategories ?? 0 }}</div>
                        <div class="text-info small">
                            <i class="fas fa-minus"></i> Tidak ada perubahan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Rendah -->
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-body-secondary text-uppercase fw-semibold small">Stok Rendah</div>
                        <div class="fs-4 fw-semibold">{{ $lowStockProducts ?? 0 }}</div>
                        <div class="text-warning small">
                            <i class="fas fa-exclamation"></i> Perlu perhatian
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-body-secondary text-uppercase fw-semibold small">Total Pengguna</div>
                        <div class="fs-4 fw-semibold">{{ $totalUsers ?? 0 }}</div>
                        <div class="text-success small">
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
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Produk Terbaru</strong>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestProducts ?? [] as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                             class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                            <div class="small text-body-secondary">{{ $product->code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->formatted_price }}</td>
                                <td>
                                    <span class="badge {{ $product->stock < 10 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $product->status_badge }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada produk</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Produk
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info -->
    <div class="col-lg-4 mb-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Quick Actions</strong>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Produk Baru
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-folder-plus me-2"></i>Tambah Kategori
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-2"></i>Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>

        <!-- Kategori Populer -->
        <div class="card">
            <div class="card-header">
                <strong>Kategori Populer</strong>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @forelse($popularCategories ?? [] as $category)
                    <li class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <i class="fas fa-folder text-primary me-2"></i>
                            <span>{{ $category->name }}</span>
                        </div>
                        <span class="badge bg-primary rounded-pill">
                            {{ $category->products_count }}
                        </span>
                    </li>
                    @empty
                    <li class="text-center text-muted py-3">
                        <i class="fas fa-folder-open fa-2x mb-2"></i>
                        <p class="mb-0">Belum ada kategori</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto refresh notifications (optional)
    setInterval(function() {
        console.log('Checking for new notifications...');
    }, 60000); // Every 1 minute
</script>
@endpush