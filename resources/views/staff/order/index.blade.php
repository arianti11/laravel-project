@extends('layouts.staff')

@section('title', 'Manage Orders')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Manage Orders</h2>
        <p class="text-muted">Kelola pesanan dan update status pengiriman</p>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('staff.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search order number, customer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Cards -->
    <div class="row">
        @forelse($orders as $order)
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $order->order_number }}</h6>
                            <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <div>
                            <span class="badge bg-{{ $order->status_badge }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Customer Info -->
                        <div class="mb-3">
                            <strong><i class="fas fa-user"></i> {{ $order->customer_name }}</strong>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-envelope"></i> {{ $order->customer_email }}<br>
                                <i class="fas fa-phone"></i> {{ $order->customer_phone }}
                            </small>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <strong><i class="fas fa-map-marker-alt"></i> Alamat:</strong>
                            <br>
                            <small>{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }}</small>
                        </div>

                        <!-- Items Preview -->
                        <div class="mb-3">
                            <strong><i class="fas fa-box"></i> Items ({{ $order->items->count() }}):</strong>
                            @foreach($order->items->take(2) as $item)
                                <br><small>• {{ $item->product_name }} ({{ $item->quantity }}x)</small>
                            @endforeach
                            @if($order->items->count() > 2)
                                <br><small class="text-muted">+{{ $order->items->count() - 2 }} more items</small>
                            @endif
                        </div>

                        <!-- Total & Payment -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>Total:</strong>
                                <h5 class="text-primary mb-0">Rp {{ number_format($order->total, 0, ',', '.') }}</h5>
                            </div>
                            <div class="text-end">
                                <small>Payment:</small><br>
                                <span class="badge bg-{{ $order->payment_badge }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('staff.orders.show', $order->id) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-eye"></i> View Detail & Update Status
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Orders Found</h4>
                        <p class="text-muted">Belum ada pesanan untuk diproses</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection