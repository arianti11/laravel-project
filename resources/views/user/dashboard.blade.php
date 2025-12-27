@extends('layouts.staff')

@section('title', 'Dashboard Staff')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="card bg-gradient-primary text-white shadow mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="mb-1">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                    <p class="mb-0 opacity-75">Semangat bekerja hari ini!</p>
                </div>
                <div class="col-auto">
                    <div class="bg-white text-primary rounded-circle p-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Produk Aktif -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3">
                            <i class="fas fa-box fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h3 class="mb-1 fw-bold">{{ $totalProducts ?? 0 }}</h3>
                    <p class="text-muted mb-0">Produk Aktif</p>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('staff.products.index') }}" class="text-decoration-none">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                    </div>
                    <h3 class="mb-1 fw-bold">{{ $lowStockProducts ?? 0 }}</h3>
                    <p class="text-muted mb-0">Stok Menipis</p>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('staff.products.index', ['stock' => 'low']) }}" class="text-decoration-none">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Hari Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                    <h3 class="mb-1 fw-bold">{{ $todayOrders ?? 0 }}</h3>
                    <p class="text-muted mb-0">Order Hari Ini</p>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="#" class="text-decoration-none">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-3">
                            <i class="fas fa-clock fa-2x text-info"></i>
                        </div>
                    </div>
                    <h3 class="mb-1 fw-bold">{{ $pendingOrders ?? 0 }}</h3>
                    <p class="text-muted mb-0">Menunggu Proses</p>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="#" class="text-decoration-none">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('staff.products.create') }}" class="text-decoration-none">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-plus-circle fa-3x mb-3"></i>
                                        <h6 class="mb-0">Tambah Produk</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('staff.products.index') }}" class="text-decoration-none">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-list fa-3x mb-3"></i>
                                        <h6 class="mb-0">Lihat Produk</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('staff.reports.products') }}" class="text-decoration-none">
                                <div class="card bg-info text-white h-100">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-chart-bar fa-3x mb-3"></i>
                                        <h6 class="mb-0">Laporan</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Tasks -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Tugas Hari Ini</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex align-items-center">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="checkbox" id="task1">
                            </div>
                            <label class="form-check-label" for="task1">
                                Cek stok produk
                            </label>
                        </div>
                        <div class="list-group-item px-0 d-flex align-items-center">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="checkbox" id="task2">
                            </div>
                            <label class="form-check-label" for="task2">
                                Update harga produk
                            </label>
                        </div>
                        <div class="list-group-item px-0 d-flex align-items-center">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="checkbox" id="task3">
                            </div>
                            <label class="form-check-label" for="task3">
                                Proses order pending
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Produk Terbaru</h5>
            <a href="{{ route('staff.products.index') }}" class="btn btn-sm btn-outline-primary">
                Lihat Semua
            </a>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @forelse($recentProducts ?? [] as $product)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border">
                        <img src="{{ $product->image_url }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}"
                             style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ Str::limit($product->name, 30) }}</h6>
                            <p class="text-muted small mb-2">{{ $product->code }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">{{ $product->formatted_price }}</span>
                                <span class="badge bg-{{ $product->stock > 10 ? 'success' : 'warning' }}">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('staff.products.edit', $product) }}" class="btn btn-sm btn-warning w-100">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada produk terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endsection