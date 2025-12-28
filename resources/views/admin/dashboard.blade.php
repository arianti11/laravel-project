@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Dashboard</h2>
            <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
        <div>
            <span class="badge bg-primary">{{ now()->format('d M Y') }}</span>
        </div>
    </div>

    <!-- Statistics Cards Row 1 -->
    <div class="row mb-4">
        <!-- Total Revenue -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Revenue</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> This Month: Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Orders</p>
                            <h4 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h4>
                            <small class="text-warning">
                                <i class="fas fa-clock"></i> Pending: {{ $stats['pending_orders'] }}
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Products</p>
                            <h4 class="fw-bold mb-0">{{ $stats['total_products'] }}</h4>
                            <small class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> Low Stock: {{ $stats['low_stock_products'] }}
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-box fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Customers</p>
                            <h4 class="fw-bold mb-0">{{ $stats['total_users'] }}</h4>
                            <small class="text-info">
                                <i class="fas fa-layer-group"></i> Categories: {{ $stats['total_categories'] }}
                            </small>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Sales Chart -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Monthly Sales (Last 6 Months)</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    @foreach($topProducts as $product)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ Str::limit($product->product_name, 20) }}</strong>
                                <br>
                                <small class="text-muted">{{ $product->total_sold }} sold</small>
                            </div>
                            <span class="badge bg-primary">{{ $product->total_sold }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Activities -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities & Low Stock -->
        <div class="col-md-4">
            <!-- Low Stock Alert -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning bg-opacity-10">
                    <h6 class="mb-0 text-warning">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock Alert
                    </h6>
                </div>
                <div class="card-body">
                    @forelse($lowStockProducts as $product)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <small><strong>{{ Str::limit($product->name, 20) }}</strong></small>
                                <br>
                                <small class="text-muted">{{ $product->category->name }}</small>
                            </div>
                            <span class="badge bg-danger">{{ $product->stock }} left</span>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">All products in stock!</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Activities</h6>
                    <a href="{{ route('admin.activity-logs') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @foreach($recentActivities as $activity)
                        <div class="d-flex mb-3">
                            <div class="bg-{{ $activity->type_badge }} bg-opacity-10 rounded-circle p-2 me-2" style="width: 35px; height: 35px;">
                                <i class="fas {{ $activity->type_icon }} text-{{ $activity->type_badge }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <small>
                                    <strong>{{ $activity->user->name ?? 'System' }}</strong>
                                    {{ $activity->description }}
                                </small>
                                <br>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sales Chart
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlySales->pluck('month')) !!},
        datasets: [{
            label: 'Orders',
            data: {!! json_encode($monthlySales->pluck('total_orders')) !!},
            borderColor: 'rgb(79, 70, 229)',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            tension: 0.4
        }, {
            label: 'Revenue (Rp)',
            data: {!! json_encode($monthlySales->pluck('total_revenue')) !!},
            borderColor: 'rgb(16, 185, 129)',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush