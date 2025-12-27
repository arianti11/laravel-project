@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
            <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
        <div>
            <span class="badge bg-danger px-3 py-2">
                <i class="fas fa-crown me-1"></i> Administrator
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Products -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Produk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalProducts ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Kategori
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalCategories ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total User
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalUsers ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Staff -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Staff
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalStaff ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="row g-3">
        <!-- Recent Products -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Produk Terbaru</h6>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
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
                                @forelse($recentProducts ?? [] as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $product->image_url }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="rounded me-2"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold">{{ $product->name }}</div>
                                                <small class="text-muted">{{ $product->code }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td>{{ $product->formatted_price }}</td>
                                    <td>
                                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : 'bg-warning' }}">
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
                                    <td colspan="5" class="text-center text-muted">
                                        Belum ada produk
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Tambah Produk
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i> Tambah Kategori
                        </a>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-info">
                            <i class="fas fa-user-plus me-2"></i> Tambah User
                        </a>
                        <a href="{{ route('admin.activity-logs') }}" class="btn btn-warning">
                            <i class="fas fa-history me-2"></i> Activity Logs
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Info</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <small class="text-muted">Laravel Version:</small>
                            <div class="fw-bold">{{ app()->version() }}</div>
                        </li>
                        <li class="mb-2">
                            <small class="text-muted">PHP Version:</small>
                            <div class="fw-bold">{{ phpversion() }}</div>
                        </li>
                        <li>
                            <small class="text-muted">Last Login:</small>
                            <div class="fw-bold">{{ now()->format('d M Y, H:i') }}</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
</style>
@endsection