@extends('layouts.customer')

@section('title', $product->name . ' - UMKM Shop')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body">
                    <!-- Main Image -->
                    <div class="mb-3">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/500' }}" 
                             class="img-fluid rounded" 
                             id="main-image"
                             alt="{{ $product->name }}">
                    </div>

                    <!-- Thumbnail Images -->
                    @if($product->images->count() > 0)
                        <div class="row g-2">
                            <!-- Main Image Thumbnail -->
                            <div class="col-3">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/100' }}" 
                                     class="img-fluid rounded cursor-pointer thumbnail-img active" 
                                     onclick="changeImage(this.src)">
                            </div>
                            
                            <!-- Additional Images -->
                            @foreach($product->images as $image)
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $image->image) }}" 
                                         class="img-fluid rounded cursor-pointer thumbnail-img" 
                                         onclick="changeImage(this.src)">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Category & Code -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                        <small class="text-muted">Kode: {{ $product->code }}</small>
                    </div>

                    <!-- Product Name -->
                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

                    <!-- Price -->
                    <div class="mb-4">
                        @if($product->discount_price)
                            <div class="d-flex align-items-center gap-3">
                                <h3 class="text-primary mb-0 fw-bold">
                                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                </h3>
                                <h5 class="text-muted text-decoration-line-through mb-0">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </h5>
                                <span class="badge bg-danger">
                                    HEMAT {{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%
                                </span>
                            </div>
                        @else
                            <h3 class="text-primary fw-bold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </h3>
                        @endif
                    </div>

                    <!-- Status & Stock -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Status:</strong>
                                @if($product->status == 'ready')
                                    <span class="badge bg-success">Ready Stock</span>
                                @elseif($product->status == 'preorder')
                                    <span class="badge bg-warning text-dark">Pre-Order</span>
                                @else
                                    <span class="badge bg-secondary">Sold Out</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Stok:</strong>
                                @if($product->stock > 10)
                                    <span class="text-success">{{ $product->stock }} unit</span>
                                @elseif($product->stock > 0)
                                    <span class="text-warning">{{ $product->stock }} unit (Terbatas!)</span>
                                @else
                                    <span class="text-danger">Habis</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Short Description -->
                    @if($product->short_description)
                        <div class="alert alert-light mb-4">
                            <i class="fas fa-info-circle text-primary"></i>
                            {{ $product->short_description }}
                        </div>
                    @endif

                    <!-- Add to Cart Form -->
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="row g-3 mb-3">
                                <!-- Quantity -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Jumlah:</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" 
                                               class="form-control text-center" 
                                               value="1" min="1" max="{{ $product->stock }}">
                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Subtotal:</label>
                                    <h4 class="text-primary fw-bold mb-0" id="subtotal">
                                        Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Produk
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Maaf, produk ini sedang habis
                        </div>
                    @endif

                    <!-- Product Stats -->
                    <div class="row mt-4 pt-4 border-top">
                        <div class="col-6 text-center">
                            <i class="fas fa-eye text-muted fs-4"></i>
                            <p class="mb-0 mt-2">{{ $product->views }} views</p>
                        </div>
                        <div class="col-6 text-center">
                            <i class="fas fa-weight-hanging text-muted fs-4"></i>
                            <p class="mb-0 mt-2">{{ $product->weight ?? 0 }}g</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#description">
                                <i class="fas fa-info-circle"></i> Deskripsi
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-md-12">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-th-large text-primary"></i> Produk Terkait
                </h4>
            </div>

            @foreach($relatedProducts as $related)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100">
                        <a href="{{ route('products.show', $related->slug) }}">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/300x250' }}" 
                                 class="card-img-top" 
                                 alt="{{ $related->name }}">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('products.show', $related->slug) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($related->name, 40) }}
                                </a>
                            </h6>
                            <h5 class="text-primary fw-bold">
                                Rp {{ number_format($related->discount_price ?? $related->price, 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .thumbnail-img {
        cursor: pointer;
        opacity: 0.6;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .thumbnail-img:hover,
    .thumbnail-img.active {
        opacity: 1;
        border-color: var(--primary-color);
    }
</style>
@endpush

@push('scripts')
<script>
    const price = {{ $product->discount_price ?? $product->price }};
    const maxStock = {{ $product->stock }};

    // Change main image
    function changeImage(src) {
        document.getElementById('main-image').src = src;
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-img').forEach(img => {
            img.classList.remove('active');
        });
        event.target.classList.add('active');
    }

    // Increase quantity
    function increaseQty() {
        let qty = document.getElementById('quantity');
        let current = parseInt(qty.value);
        if (current < maxStock) {
            qty.value = current + 1;
            updateSubtotal();
        }
    }

    // Decrease quantity
    function decreaseQty() {
        let qty = document.getElementById('quantity');
        let current = parseInt(qty.value);
        if (current > 1) {
            qty.value = current - 1;
            updateSubtotal();
        }
    }

    // Update subtotal
    function updateSubtotal() {
        let qty = parseInt(document.getElementById('quantity').value);
        let subtotal = price * qty;
        document.getElementById('subtotal').textContent = 
            'Rp ' + subtotal.toLocaleString('id-ID');
    }

    // Handle quantity input change
    document.getElementById('quantity').addEventListener('change', function() {
        if (this.value > maxStock) this.value = maxStock;
        if (this.value < 1) this.value = 1;
        updateSubtotal();
    });

    // Handle form submit
    document.getElementById('addToCartForm').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';
        
        setTimeout(() => {
            updateCartCount();
        }, 500);
    });
</script>
@endpush