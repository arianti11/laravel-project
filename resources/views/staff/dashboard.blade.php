@extends('layouts.staff')

@section('title', 'Staff Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Dashboard Staff</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Products -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Products</p>
                            <h4 class="fw-bold mb-0">{{ $stats['total_products'] }}</h4>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-box fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Low Stock</p>
                            <h4 class="fw-bold mb-0 text-danger">{{ $stats['low_stock_products'] }}</h4>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded p-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Categories</p>
                            <h4 class="fw-bold mb-0 text-success">{{ $stats['total_categories'] }}</h4>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-folder fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Products -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Recent Products</h5>
                    <a href="{{ route('staff.products.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @if($recentProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                        <tr>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $product->code }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                            </td>
                                            <td>
                                                <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                            </td>
                                            <td>
                                                @if($product->stock < 10)
                                                    <span class="badge bg-danger">{{ $product->stock }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ $product->stock }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->status == 'ready')
                                                    <span class="badge bg-success">Ready</span>
                                                @elseif($product->status == 'preorder')
                                                    <span class="badge bg-warning">Pre-Order</span>
                                                @else
                                                    <span class="badge bg-secondary">Sold Out</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada produk</p>
                            <a href="{{ route('staff.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4 mb-4">
            <!-- Low Stock Alert -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-warning bg-opacity-10 py-3">
                    <h6 class="mb-0 text-warning">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock Alert
                    </h6>
                </div>
                <div class="card-body">
                    @if($lowStockProducts->count() > 0)
                        @foreach($lowStockProducts as $product)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <small><strong>{{ Str::limit($product->name, 25) }}</strong></small>
                                    <br>
                                    <small class="text-muted">{{ $product->category->name }}</small>
                                </div>
                                <span class="badge bg-danger">{{ $product->stock }} left</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center mb-0">All products have sufficient stock!</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('staff.products.index') }}" class="btn btn-primary text-start">
                            <i class="fas fa-box"></i> Manage Products
                        </a>
                        <a href="{{ route('staff.reports.products') }}" class="btn btn-outline-secondary text-start">
                            <i class="fas fa-chart-bar"></i> View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection