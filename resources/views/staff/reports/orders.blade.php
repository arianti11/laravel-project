@extends('layouts.staff')

@section('title', 'Orders Report')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Orders Report</h2>
        <p class="text-muted">Monitoring pesanan dan status pembayaran</p>
    </div>

    <!-- Date Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('staff.reports.orders') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-shopping-cart fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders by Status -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Orders by Status</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Status</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordersByStatus as $status)
                                    <tr>
                                        <td>
                                            @if($status->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($status->status == 'processing')
                                                <span class="badge bg-info">Processing</span>
                                            @elseif($status->status == 'shipped')
                                                <span class="badge bg-primary">Shipped</span>
                                            @elseif($status->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ $status->total }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-primary">
                                                {{ $totalOrders > 0 ? number_format(($status->total / $totalOrders) * 100, 1) : 0 }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info bg-opacity-10">
                    <h6 class="mb-0 text-info">
                        <i class="fas fa-info-circle"></i> Staff Information
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <i class="fas fa-check-circle text-success"></i>
                        Staff dapat melihat laporan pesanan
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-times-circle text-danger"></i>
                        Staff tidak dapat mengubah status order
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-times-circle text-danger"></i>
                        Staff tidak dapat mengakses data pembayaran detail
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-info-circle text-info"></i>
                        Untuk perubahan status order, hubungi Admin
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                {{ $order->customer_name }}
                                                <br>
                                                <small class="text-muted">{{ $order->customer_email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $order->items->count() }} items</span>
                                            </td>
                                            <td>
                                                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
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
                                            <td>
                                                {{ $order->created_at->format('d M Y') }}
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No orders found for selected period</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection