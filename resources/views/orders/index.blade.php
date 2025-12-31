@extends('layouts.customer')

@section('title', 'My Orders - UMKM Shop')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">My Orders</li>
                </ol>
            </nav>
            <h2 class="fw-bold">
                <i class="fas fa-box text-primary"></i> Riwayat Pesanan
            </h2>
            <p class="text-muted">Kelola dan lacak pesanan Anda</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('orders.index') }}" method="GET" class="row g-3">
                        <!-- Search -->
                        <div class="col-md-4">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Cari order number..." 
                                   value="{{ request('search') }}">
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Payment Status Filter -->
                        <div class="col-md-3">
                            <select name="payment_status" class="form-select">
                                <option value="">Semua Pembayaran</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-12 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="fas fa-receipt text-primary"></i>
                                        {{ $order->order_number }}
                                    </h6>
                                    <small class="text-muted">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-{{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <span class="badge bg-{{ $order->payment_badge }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <strong class="text-primary fs-5">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </strong>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="{{ route('orders.show', $order->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Order Items Preview -->
                            <div class="row">
                                @foreach($order->items->take(3) as $item)
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                                 class="rounded me-2" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <p class="mb-0 small fw-semibold">{{ Str::limit($item->product_name, 30) }}</p>
                                                <small class="text-muted">
                                                    {{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if($order->items->count() > 3)
                                    <div class="col-md-12">
                                        <small class="text-muted">
                                            <i class="fas fa-plus"></i> {{ $order->items->count() - 3 }} produk lainnya
                                        </small>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-box"></i> {{ $order->items->count() }} item
                                        </small>
                                    </div>
                                    <div>
                                        @if($order->status == 'pending')
                                            <form action="{{ route('orders.cancel', $order->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i> Batalkan
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('orders.show', $order->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-alt"></i> Invoice
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div class="text-muted small">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Pesanan</h4>
                        <p class="text-muted mb-4">Yuk mulai belanja dan buat pesanan pertama Anda!</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag"></i> Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection