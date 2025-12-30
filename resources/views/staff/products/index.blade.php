@extends('layouts.staff')

@section('title', 'Manage Products')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Manage Products</h2>
            <p class="text-muted">View & Edit produk UMKM (Staff tidak bisa create/delete)</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('staff.products.index') }}" method="GET" class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search products..." value="{{ request('search') }}">
                </div>

                <!-- Category Filter -->
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="preorder" {{ request('status') == 'preorder' ? 'selected' : '' }}>Pre-Order</option>
                        <option value="sold_out" {{ request('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('staff.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid (Card Design for Staff) -->
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <!-- Product Image -->
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200' }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 200px; object-fit: cover;">

                    <!-- Badges -->
                    <div class="position-absolute top-0 end-0 p-2">
                        @if($product->stock < 10)
                            <span class="badge bg-danger">Low Stock</span>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <!-- Category -->
                        <p class="text-muted small mb-2">
                            <i class="fas fa-tag"></i> {{ $product->category->name }}
                        </p>

                        <!-- Product Name -->
                        <h6 class="card-title mb-2">
                            {{ Str::limit($product->name, 40) }}
                        </h6>

                        <!-- Code -->
                        <p class="text-muted small mb-2">
                            <i class="fas fa-barcode"></i> {{ $product->code }}
                        </p>

                        <!-- Price -->
                        <h5 class="text-primary mb-2">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h5>

                        <!-- Stock & Status -->
                        <div class="d-flex justify-content-between mb-3">
                            <small>
                                <strong>Stock:</strong> 
                                <span class="badge bg-{{ $product->stock < 10 ? 'danger' : 'success' }}">
                                    {{ $product->stock }}
                                </span>
                            </small>
                            <small>
                                @if($product->status == 'ready')
                                    <span class="badge bg-success">Ready</span>
                                @elseif($product->status == 'preorder')
                                    <span class="badge bg-warning">Pre-Order</span>
                                @else
                                    <span class="badge bg-secondary">Sold Out</span>
                                @endif
                            </small>
                        </div>

                        <!-- Actions -->
                        <div class="mt-auto">
                            <div class="d-flex gap-2">
                                <a href="{{ route('staff.products.show', $product->id) }}" 
                                   class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('staff.products.edit', $product->id) }}" 
                                   class="btn btn-sm btn-primary flex-fill">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Products Found</h4>
                        <p class="text-muted">Tidak ada produk yang cocok dengan filter</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection