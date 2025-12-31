@extends('layouts.staff')

@section('title', 'Products Report')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Products Report</h2>
        <p class="text-muted">Analisis stok dan status produk</p>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Products</h6>
                    <h3 class="fw-bold mb-0">{{ $productsByCategory->sum('total') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Low Stock Products</h6>
                    <h3 class="fw-bold mb-0 text-danger">{{ $lowStockProducts->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Categories</h6>
                    <h3 class="fw-bold mb-0 text-success">{{ $productsByCategory->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Products by Status -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Products by Status</h5>
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
                                @php $totalProducts = $productsByStatus->sum('total'); @endphp
                                @foreach($productsByStatus as $status)
                                    <tr>
                                        <td>
                                            @if($status->status == 'ready')
                                                <span class="badge bg-success">Ready Stock</span>
                                            @elseif($status->status == 'preorder')
                                                <span class="badge bg-warning">Pre-Order</span>
                                            @else
                                                <span class="badge bg-secondary">Sold Out</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ $status->total }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-primary">
                                                {{ $totalProducts > 0 ? number_format(($status->total / $totalProducts) * 100, 1) : 0 }}%
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

        <!-- Products by Category -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Products by Category</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Category</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-end">Chart</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $maxTotal = $productsByCategory->max('total'); @endphp
                                @foreach($productsByCategory as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->category->name }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $item->total }}</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" 
                                                     style="width: {{ $maxTotal > 0 ? ($item->total / $maxTotal) * 100 : 0 }}%">
                                                    {{ $item->total }}
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

    <!-- Low Stock Alert -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger bg-opacity-10">
                    <h5 class="mb-0 text-danger">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock Products (< 20 units)
                    </h5>
                </div>
                <div class="card-body">
                    @if($lowStockProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th class="text-center">Stock</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                        <tr>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $product->code }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($product->stock < 5)
                                                    <span class="badge bg-danger fs-6">{{ $product->stock }}</span>
                                                @elseif($product->stock < 10)
                                                    <span class="badge bg-warning fs-6">{{ $product->stock }}</span>
                                                @else
                                                    <span class="badge bg-info fs-6">{{ $product->stock }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->status == 'ready')
                                                    <span class="badge bg-success">Ready</span>
                                                @elseif($product->status == 'preorder')
                                                    <span class="badge bg-warning">Pre-Order</span>
                                                @else
                                                    <span class="badge bg-secondary">Sold Out</span>
                                                 @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('staff.products.edit', $product->id) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Update Stock
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-muted mb-0">All products have sufficient stock!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection