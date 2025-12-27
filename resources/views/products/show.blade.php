@extends('layouts.public')

@section('title', 'Products')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <h1 class="display-4 fw-bold text-center mb-2">Our Products</h1>
        <p class="text-center text-muted mb-0">Discover amazing products from local businesses</p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Filters
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}">
                        <!-- Search -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Search</label>
                            <input type="text" 
                                   name="search" 
                                   class="form-control form-control-sm" 
                                   placeholder="Product name..."
                                   value="{{ request('search') }}">
                        </div>

                        <!-- Categories -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category" class="form-select form-select-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->slug }}" 
                                        {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Price Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" 
                                           name="min_price" 
                                           class="form-control form-control-sm" 
                                           placeholder="Min"
                                           value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" 
                                           name="max_price" 
                                           class="form-control form-control-sm" 
                                           placeholder="Max"
                                           value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary btn-sm w-100 mb-2">
                            <i class="fas fa-search me-1"></i> Apply Filters
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </form>
                </div>
            </div>

            <!-- Popular Categories -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Popular Categories</h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories->take(5) as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        {{ $category->name }}
                        <span class="badge bg-primary rounded-pill">{{ $category->products_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Sort & View Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <strong>{{ $products->total() }}</strong> products found
                </div>
                <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2">
                    <!-- Preserve filters -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('min_price'))
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    @endif
                    @if(request('max_price'))
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                    @endif
                    
                    <select name="sort" class="form-select form-select-sm" style="width: 200px;" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                    </select>
                </form>
            </div>

            <!-- Products -->
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm product-card">
                        <div class="position-relative">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image_url }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 250px; object-fit: cover;">
                            </a>
                            
                            @if($product->is_on_sale)
                            <span class="position-absolute top-0 start-0 m-2 badge bg-danger">
                                -{{ $product->discount_percentage }}%
                            </span>
                            @endif
                            
                            @if($product->stock == 0)
                            <span class="position-absolute top-0 end-0 m-2 badge bg-secondary">
                                Sold Out
                            </span>
                            @elseif($product->stock <= 5)
                            <span class="position-absolute top-0 end-0 m-2 badge bg-warning">
                                {{ $product->stock }} left
                            </span>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-light text-dark small">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                            
                            <h6 class="card-title">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($product->name, 50) }}
                                </a>
                            </h6>
                            
                            <div class="mb-3">
                                @if($product->is_on_sale)
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-success fw-bold">{{ $product->formatted_discount_price }}</span>
                                    <small class="text-muted text-decoration-line-through">{{ $product->formatted_price }}</small>
                                </div>
                                @else
                                <span class="text-success fw-bold">{{ $product->formatted_price }}</span>
                                @endif
                            </div>
                            
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No products found</h5>
                        <p class="text-muted">Try adjusting your filters</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i> Clear Filters
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-5">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}
</style>
@endsection