@extends('layouts.customer')

@section('title', 'Products - UMKM Shop')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold mb-3">
                <i class="fas fa-shopping-bag text-primary"></i> Produk Kami
            </h2>
            <p class="text-muted">Temukan produk UMKM berkualitas pilihan Anda</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                        <!-- Search -->
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari produk..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="col-md-3">
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="preorder" {{ request('status') == 'preorder' ? 'selected' : '' }}>Pre-Order</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="col-md-2">
                            <select name="sort" class="form-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x250' }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}">
                        </a>

                        <!-- Badges -->
                        <div class="position-absolute top-0 end-0 p-2">
                            @if($product->discount_price)
                                <span class="badge bg-danger">
                                    DISKON {{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%
                                </span>
                            @endif
                            
                            @if($product->status == 'preorder')
                                <span class="badge bg-warning text-dark">Pre-Order</span>
                            @elseif($product->stock == 0)
                                <span class="badge bg-secondary">Sold Out</span>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <!-- Category -->
                            <p class="text-muted small mb-2">
                                <i class="fas fa-tag"></i> {{ $product->category->name }}
                            </p>

                            <!-- Product Name -->
                            <h6 class="card-title mb-2">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($product->name, 50) }}
                                </a>
                            </h6>

                            <!-- Price -->
                            <div class="mb-3">
                                @if($product->discount_price)
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="text-primary mb-0 fw-bold">
                                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                        </h5>
                                        <small class="text-muted text-decoration-line-through">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </small>
                                    </div>
                                @else
                                    <h5 class="text-primary mb-0 fw-bold">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </h5>
                                @endif
                            </div>

                            <!-- Stock Info -->
                            <p class="small text-muted mb-3">
                                <i class="fas fa-box"></i> Stok: {{ $product->stock }}
                            </p>

                            <!-- Actions -->
                            <div class="mt-auto">
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-times"></i> Sold Out
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div class="text-muted small">
                    {{ $products->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Produk Tidak Ditemukan</h4>
                        <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Add to cart with AJAX (optional enhancement)
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const btn = this.querySelector('button');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        
        // Update cart count after form submission
        setTimeout(() => {
            updateCartCount();
        }, 500);
    });
});
</script>
@endpush