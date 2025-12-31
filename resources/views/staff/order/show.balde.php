@extends('layouts.staff')

@section('title', 'Order Detail - ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staff.orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Order Items -->
        <div class="col-md-8 mb-4">
            <!-- Order Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Current Status:</strong>
                            <br>
                            <span class="badge bg-{{ $order->status_badge }} fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Payment Status:</strong>
                            <br>
                            <span class="badge bg-{{ $order->payment_badge }} fs-6">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Update Status Form -->
                    <form action="{{ route('staff.orders.updateStatus', $order->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        
                        <label class="form-label fw-semibold">Update Order Status:</label>
                        <div class="input-group">
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Status
                            </button>
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
                                    <td class="text-end">
                                        <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                    <td class="text-end">
                                        <strong>
                                            @if($order->shipping_cost == 0)
                                                <span class="text-success">FREE</span>
                                            @else
                                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                            @endif
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><h5>TOTAL:</h5></td>
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
                    <p class="mb-0">{{ $order->customer_phone }}</p>
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
                        {{ $order->city }}, {{ $order->province }}<br>
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
                    <p class="mb-3 text-capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>

                    <p class="mb-2"><strong>Status:</strong></p>
                    <span class="badge bg-{{ $order->payment_badge }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="row mt-3 no-print">
        <div class="col-md-12">
            <a href="{{ route('staff.orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection