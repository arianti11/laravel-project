@extends('layouts.public')

@section('title', 'Order Detail')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Order Details</h1>
            <p class="text-muted mb-0">Order #{{ $order->order_number }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <div class="row g-4">
        <!-- Order Info -->
        <div class="col-lg-8">
            <!-- Order Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-2">Order Status</h5>
                            <span class="badge bg-{{ $order->status_badge }} fs-6">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5 class="mb-2">Payment Status</h5>
                            <span class="badge bg-{{ $order->payment_status_badge }} fs-6">
                                {{ $order->payment_status_label }}
                            </span>
                        </div>
                    </div>
                    
                    @if($order->status == 'pending')
                    <hr>
                    <div class="text-center">
                        <form action="{{ route('orders.cancel', $order) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-2"></i>Cancel Order
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="row align-items-center py-3 {{ !$loop->first ? 'border-top' : '' }}">
                        <div class="col-md-2">
                            <img src="{{ $item->product->image_url ?? asset('images/default-product.png') }}" 
                                 alt="{{ $item->product_name }}"
                                 class="img-fluid rounded">
                        </div>
                        <div class="col-md-5">
                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                            <small class="text-muted">SKU: {{ $item->product_code }}</small>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="text-muted small">Quantity</div>
                            <div class="fw-bold">{{ $item->quantity }}</div>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="text-muted small">Subtotal</div>
                            <div class="fw-bold text-success">{{ $item->formatted_subtotal }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Shipping Address</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                    <p class="mb-1">{{ $order->customer_phone }}</p>
                    <p class="mb-1">{{ $order->customer_email }}</p>
                    <hr>
                    <p class="mb-1">{{ $order->shipping_address }}</p>
                    <p class="mb-0">{{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <!-- Payment Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Payment Method</small>
                        <div class="fw-bold text-capitalize">
                            @if($order->payment_method == 'bank_transfer')
                                <i class="fas fa-university me-2"></i>Bank Transfer
                            @elseif($order->payment_method == 'cod')
                                <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
                            @else
                                <i class="fas fa-wallet me-2"></i>E-Wallet
                            @endif
                        </div>
                    </div>

                    @if($order->payment_method == 'bank_transfer' && $order->payment_status == 'pending')
                    <div class="alert alert-info">
                        <strong>Transfer to:</strong><br>
                        Bank BCA<br>
                        Acc: 1234567890<br>
                        Name: UMKM Store
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>{{ $order->formatted_subtotal }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <strong>{{ $order->formatted_shipping_cost }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong class="fs-5">Total</strong>
                        <h4 class="mb-0 text-success">{{ $order->formatted_total }}</h4>
                    </div>

                    <!-- Order Info -->
                    <div class="border-top pt-3">
                        <small class="text-muted">Order Date</small>
                        <div class="fw-bold">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    @if($order->notes)
                    <div class="border-top pt-3 mt-3">
                        <small class="text-muted">Order Notes</small>
                        <div>{{ $order->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif
</script>
@endpush
@endsection