@extends('layouts.admin')

@section('title', 'Products Report')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Products Report</h2>
            <p class="text-muted">Analisis performa produk</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>

    <!-- Products by Status -->
    <div class="row mb-4">
        @foreach($productsByStatus as $status)
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">{{ ucfirst($status->status) }} Products</h6>
                        <h3 class="fw-bold mb-0">{{ $status->total }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Top Selling Products -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Top 20 Selling Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Product Name</th>
                                    <th class="text-center">Total Sold</th>
                                    <th class="text-end">Total Revenue</th>
                                    <th class="text-center">Chart</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $index => $product)
                                    <tr>
                                        <td>
                                            @if($index < 3)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-trophy"></i> {{ $index + 1 }}
                                                </span>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td><strong>{{ $product->product_name }}</strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $product->total_sold }}</span>
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" 
                                                     style="width: {{ ($product->total_sold / $topProducts->max('total_sold')) * 100 }}%">
                                                    {{ $product->total_sold }}
                                                </div>
                                            </div>
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

    <!-- Products by Category -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Products by Category</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning bg-opacity-10">
                    <h5 class="mb-0 text-warning">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock Products (< 10)
                    </h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th class="text-center">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                    <tr>
                                        <td><strong>{{ $product->name }}</strong></td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger">{{ $product->stock }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            <i class="fas fa-check-circle"></i> All products have sufficient stock!
                                        </td>
                                    </tr>
                                @endforelse
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
// Products by Category Chart
const ctx = document.getElementById('categoryChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($productsByCategory->pluck('category.name')) !!},
        datasets: [{
            data: {!! json_encode($productsByCategory->pluck('total')) !!},
            backgroundColor: [
                'rgba(79, 70, 229, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(251, 191, 36, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(139, 92, 246, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush