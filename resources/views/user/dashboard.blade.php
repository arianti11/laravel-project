@extends('layouts.customer')

@section('title', 'Dashboard - UMKM Shop')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">
                <i class="fas fa-tachometer-alt text-primary"></i> Dashboard
            </h2>
            <p class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Orders -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Pesanan</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Pesanan Pending</p>
                            <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_orders'] }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Pesanan Selesai</p>
                            <h3 class="fw-bold mb-0 text-success">{{ $stats['completed_orders'] }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Belanja</p>
                            <h3 class="fw-bold mb-0 text-primary">
                                Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-wallet fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary"></i> Pesanan Terbaru
                        </h5>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_number }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $order->items->count() }} item
                                                </small>
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('d M Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $order->created_at->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <strong class="text-primary">
                                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $order->status_badge }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                <br>
                                                <small>
                                                    <span class="badge bg-{{ $order->payment_badge }} mt-1">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('orders.show', $order->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada pesanan</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag"></i> Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Profile -->
        <div class="col-md-4 mb-4">
            <!-- User Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <!-- Avatar -->
                    <div class="mb-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 class="rounded-circle" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width: 100px; height: 100px;">
                                <span class="fs-1 fw-bold text-primary">
                                    {{ auth()->user()->initials }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- User Info -->
                    <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small mb-1">
                        <i class="fas fa-envelope"></i> {{ auth()->user()->email }}
                    </p>
                    @if(auth()->user()->phone)
                        <p class="text-muted small mb-3">
                            <i class="fas fa-phone"></i> {{ auth()->user()->phone }}
                        </p>
                    @endif

                    <!-- Edit Profile Button -->
                    <a href="{{ route('user.profile') }}" class="btn btn-primary w-100">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt text-warning"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-shopping-bag"></i> Browse Products
                        </a>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-shopping-cart"></i> View Cart
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-box"></i> My Orders
                        </a>
                        <a href="{{ route('user.profile') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-user-cog"></i> Account Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips & Info -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x me-3"></i>
                    <div>
                        <h6 class="mb-1">💡 Tips Belanja</h6>
                        <p class="mb-0 small">
                            Belanja minimal Rp 500.000 untuk mendapatkan <strong>GRATIS ONGKIR</strong> ke seluruh Indonesia!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }

    .table tbody tr {
        transition: background-color 0.3s;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush