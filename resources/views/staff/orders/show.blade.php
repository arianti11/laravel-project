@extends('layouts.staff')

@section('title', 'Order Detail')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('staff.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <!-- Order Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="fw-bold mb-3">Order {{ $order->order_number }}</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Order Date:</strong></p>
                            <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong></p>
                            <span class="badge bg-{{ $order->status_badge }} fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="badge bg-{{ $order->payment_badge }} fs-6 ms-2">
                                Payment: {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Update Order Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Change Status:</label>
                                <select name="status" class="form-select form-select-lg" required>
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                        ⏳ Pending - Menunggu Konfirmasi
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        ⚙️ Processing - Sedang Diproses
                                    </option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                        🚚 Shipped - Dalam Pengiriman
                                    </option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                        ✅ Delivered - Pesanan Diterima
                                    </option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        ❌ Cancelled - Dibatalkan
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-save"></i> Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $item->product_code }}</small>
                                        </td>
                                        <td class="text-center">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                    <td class="text-end">
                                        @if($order->shipping_cost == 0)
                                            <span class="text-success">FREE</span>
                                        @else
                                            Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><h5 class="mb-0">TOTAL:</h5></td>
                                    <td class="text-end">
                                        <h4 class="text-primary fw-bold mb-0">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Customer Info -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-user"></i> Customer Info</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong></p>
                    <p class="mb-3">{{ $order->customer_name }}</p>

                    <p class="mb-2"><strong>Email:</strong></p>
                    <p class="mb-3">{{ $order->customer_email }}</p>

                    <p class="mb-2"><strong>Phone:</strong></p>
                    <p class="mb-0">
                        <a href="tel:{{ $order->customer_phone }}" class="btn btn-sm btn-success">
                            <i class="fas fa-phone"></i> {{ $order->customer_phone }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-map-marker-alt"></i> Shipping Address</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">{{ $order->shipping_address }}</p>
                    <p class="mb-0">
                        <strong>{{ $order->city }}, {{ $order->province }}</strong><br>
                        {{ $order->postal_code }}
                    </p>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-credit-card"></i> Payment Info</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Method:</strong></p>
                    <p class="mb-3 text-capitalize">
                        <i class="fas fa-{{ $order->payment_method == 'bank_transfer' ? 'university' : ($order->payment_method == 'cod' ? 'money-bill-wave' : 'wallet') }}"></i>
                        {{ str_replace('_', ' ', $order->payment_method) }}
                    </p>

                    <p class="mb-2"><strong>Status:</strong></p>
                    <span class="badge bg-{{ $order->payment_badge }} fs-6">
                        {{ ucfirst($order->payment_status) }}
                    </span>

                    @if($order->payment_method == 'bank_transfer' && $order->payment_status == 'pending')
                        <div class="alert alert-warning mt-3 mb-0">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                Menunggu pembayaran dari customer
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection