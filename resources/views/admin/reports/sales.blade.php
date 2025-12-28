@extends('layouts.admin')

@section('title', 'Sales Report')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Sales Report</h2>
            <p class="text-muted">Analisis penjualan dan revenue</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>

    <!-- Date Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Sales</p>
                            <h3 class="fw-bold mb-0 text-success">
                                Rp {{ number_format($totalSales, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-dollar-sign fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Orders</p>
                            <h3 class="fw-bold mb-0 text-primary">{{ $totalOrders }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-shopping-cart fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Daily Sales Chart -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daily Sales Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="dailySalesChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders by Status -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Orders by Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales by Payment Method -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Sales by Payment Method</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Payment Method</th>
                                    <th class="text-end">Total Sales</th>
                                    <th class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesByPayment as $payment)
                                    <tr>
                                        <td>
                                            <i class="fas fa-{{ $payment->payment_method == 'bank_transfer' ? 'university' : ($payment->payment_method == 'cod' ? 'money-bill-wave' : 'wallet') }} me-2"></i>
                                            <strong>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($payment->total_sales, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-primary">
                                                {{ number_format(($payment->total_sales / $totalSales) * 100, 1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>TOTAL</th>
                                    <th class="text-end">Rp {{ number_format($totalSales, 0, ',', '.') }}</th>
                                    <th class="text-end">100%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Sales Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daily Sales Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th class="text-center">Total Orders</th>
                                    <th class="text-end">Total Sales</th>
                                    <th class="text-end">Average Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dailySales as $sale)
                                    <tr>
                                        <td><strong>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $sale->total_orders }}</span>
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($sale->total_sales, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-muted">
                                                Rp {{ number_format($sale->total_sales / $sale->total_orders, 0, ',', '.') }}
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
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily Sales Chart
const dailyCtx = document.getElementById('dailySalesChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($dailySales->pluck('date')->map(function($date) { return \Carbon\Carbon::parse($date)->format('d M'); })) !!},
        datasets: [{
            label: 'Sales (Rp)',
            data: {!! json_encode($dailySales->pluck('total_sales')) !!},
            backgroundColor: 'rgba(79, 70, 229, 0.8)',
            borderColor: 'rgb(79, 70, 229)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($ordersByStatus->pluck('status')->map(function($s) { return ucfirst($s); })) !!},
        datasets: [{
            data: {!! json_encode($ordersByStatus->pluck('total')) !!},
            backgroundColor: [
                'rgba(251, 191, 36, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(156, 163, 175, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});
</script>
@endpush