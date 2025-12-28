@extends('layouts.public')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">
        <i class="fas fa-shopping-bag me-2"></i>My Orders
    </h1>

    @if($orders->count() > 0)
    <div class="row g-4">
        @foreach($orders as $order)
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <small class="text-muted">Order Number</small>
                            <div class="fw-bold">{{ $order->order_number }}</div>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Date</small>
                            <div>{{ $order->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Total</small>
                            <div class="fw-bold text-success">{{ $order->formatted_total }}</div>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Status</small>
                            <div>
                                <span class="badge bg-{{ $order->status_badge }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($order->items->take(3) as $item)
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->product->image_url ?? asset('images/default-product.png') }}" 
                                     alt="{{ $item->product_name }}"
                                     class="rounded me-2"
                                     style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <small class="fw-bold d-block">{{ Str::limit($item->product_name, 30) }}</small>
                                    <small class="text-muted">x{{ $item->quantity }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($order->items->count() > 3)
                        <div class="col-md-4">
                            <div class="text-muted">
                                +{{ $order->items->count() - 3 }} more items
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="text-center py-5">
        <i class="fas fa-shopping-bag fa-5x text-muted mb-4"></i>
        <h3 class="mb-3">No orders yet</h3>
        <p class="text-muted mb-4">Start shopping to see your orders here</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-shopping-cart me-2"></i>
            Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection