@extends('layouts.public')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/products">Products</a></li>
            <li class="breadcrumb-item"><a href="/products?category={{ $product->category->slug }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Product Images -->
        <div class="col-lg-6">
            <div class="product-images">
                <!-- Main Image -->
                <div class="main-image mb-3">
                    <img id="mainProductImage" 
                         src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}"
                         class="img-fluid rounded shadow"
                         style="width: 100%; height: 500px; object-fit: cover;">
                    
                    <!-- Badges -->
                    <div class="position-absolute top-0 start-0 m-3">
                        @if($product->is_on_sale)
                        <span class="badge bg-danger fs-6 mb-2">
                            SALE {{ $product->discount_percentage }}%
                        </span>
                        @endif
                        
                        @if($product->status == 'preorder')
                        <span class="badge bg-warning fs-6">
                            Pre-Order
                        </span>
                        @elseif($product->status == 'sold_out' || $product->stock == 0)
                        <span class="badge bg-secondary fs-6">
                            Sold Out
                        </span>
                        @elseif($product->stock <= 5)
                        <span class="badge bg-warning fs-6">
                            Only {{ $product->stock }} Left!
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail Gallery -->
                @if($product->images->count() > 0)
                <div class="row g-2 thumbnail-gallery">
                    <!-- Main Image Thumbnail -->
                    <div class="col-3">
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}"
                             class="img-thumbnail thumbnail-item active"
                             onclick="changeMainImage('{{ $product->image_url }}')"
                             style="cursor: pointer; height: 100px; object-fit: cover; width: 100%;">
                    </div>
                    
                    <!-- Additional Images -->
                    @foreach($product->images as $image)
                    <div class="col-3">
                        <img src="{{ $image->image_url }}" 
                             alt="{{ $product->name }}"
                             class="img-thumbnail thumbnail-item"
                             onclick="changeMainImage('{{ $image->image_url }}')"
                             style="cursor: pointer; height: 100px; object-fit: cover; width: 100%;">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <!-- Category -->
            <div class="mb-2">
                <a href="/products?category={{ $product->category->slug }}" 
                   class="badge bg-primary text-decoration-none">
                    <i class="fas fa-tag me-1"></i>
                    {{ $product->category->name }}
                </a>
            </div>

            <!-- Product Name -->
            <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>

            <!-- Code & Views -->
            <div class="d-flex align-items-center text-muted mb-3">
                <small class="me-3">
                    <i class="fas fa-barcode me-1"></i>
                    {{ $product->code }}
                </small>
                <small>
                    <i class="fas fa-eye me-1"></i>
                    {{ $product->views }} views
                </small>
            </div>

            <!-- Short Description -->
            @if($product->short_description)
            <p class="lead text-muted mb-4">{{ $product->short_description }}</p>
            @endif

            <!-- Price -->
            <div class="mb-4">
                @if($product->is_on_sale)
                <div class="d-flex align-items-center gap-3 mb-2">
                    <h2 class="text-success fw-bold mb-0">{{ $product->formatted_discount_price }}</h2>
                    <h4 class="text-muted text-decoration-line-through mb-0">{{ $product->formatted_price }}</h4>
                    <span class="badge bg-danger fs-6">
                        Save {{ $product->discount_percentage }}%
                    </span>
                </div>
                @else
                <h2 class="text-success fw-bold mb-2">{{ $product->formatted_price }}</h2>
                @endif
            </div>

            <!-- Stock & Status -->
            <div class="mb-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="border rounded p-3 text-center">
                            <div class="text-muted small mb-1">Stock</div>
                            @if($product->stock > 10)
                                <div class="h5 text-success mb-0">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Available
                                </div>
                            @elseif($product->stock > 0)
                                <div class="h5 text-warning mb-0">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $product->stock }} left
                                </div>
                            @else
                                <div class="h5 text-danger mb-0">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Sold Out
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 text-center">
                            <div class="text-muted small mb-1">Weight</div>
                            <div class="h5 mb-0">
                                @if($product->weight)
                                    {{ $product->weight >= 1000 ? number_format($product->weight/1000, 1) . ' kg' : $product->weight . ' gr' }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quantity & Add to Cart -->
            @if($product->stock > 0 && $product->status != 'sold_out')
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="card border-primary mb-4">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Quantity:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" 
                                           name="quantity"
                                           id="quantity" 
                                           class="form-control text-center" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->stock }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="alert alert-secondary">
                <i class="fas fa-info-circle me-2"></i>
                This product is currently out of stock
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="d-flex gap-2 mb-4">
                <button class="btn btn-outline-danger btn-lg flex-fill" onclick="addToWishlist()">
                    <i class="fas fa-heart me-2"></i> Wishlist
                </button>
                <button class="btn btn-outline-secondary btn-lg" onclick="shareProduct()">
                    <i class="fas fa-share-alt"></i>
                </button>
            </div>

            <!-- Product Meta -->
            <div class="border-top pt-4">
                <div class="row g-3">
                    <div class="col-6">
                        <small class="text-muted">SKU:</small>
                        <div class="fw-bold">{{ $product->code }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Category:</small>
                        <div class="fw-bold">{{ $product->category->name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description & Details -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" 
                            data-bs-toggle="tab" 
                            data-bs-target="#description" 
                            type="button">
                        <i class="fas fa-info-circle me-2"></i>Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" 
                            data-bs-toggle="tab" 
                            data-bs-target="#specifications" 
                            type="button">
                        <i class="fas fa-list me-2"></i>Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" 
                            data-bs-toggle="tab" 
                            data-bs-target="#reviews" 
                            type="button">
                        <i class="fas fa-star me-2"></i>Reviews
                    </button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 p-4">
                <!-- Description -->
                <div class="tab-pane fade show active" id="description">
                    @if($product->description)
                        <div class="product-description">
                            {!! $product->description !!}
                        </div>
                    @else
                        <p class="text-muted">No description available.</p>
                    @endif
                </div>

                <!-- Specifications -->
                <div class="tab-pane fade" id="specifications">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width: 30%">Product Code</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>
                                    @if($product->weight)
                                        {{ $product->weight >= 1000 ? number_format($product->weight/1000, 2) . ' kg' : $product->weight . ' gram' }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Stock Status</th>
                                <td>
                                    @if($product->stock > 10)
                                        <span class="badge bg-success">In Stock</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning">Limited Stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Availability</th>
                                <td>{{ ucfirst($product->status) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Reviews -->
                <div class="tab-pane fade" id="reviews">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-comment-dots fa-3x mb-3"></i>
                        <p class="mb-0">No reviews yet. Be the first to review this product!</p>
                        <button class="btn btn-primary mt-3">Write a Review</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4">Related Products</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-md-3">
                <div class="card h-100 product-card">
                    <img src="{{ $relatedProduct->image_url }}" 
                         class="card-img-top" 
                         alt="{{ $relatedProduct->name }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($relatedProduct->name, 50) }}</h6>
                        <p class="text-success fw-bold mb-2">{{ $relatedProduct->formatted_price }}</p>
                        <a href="/products/{{ $relatedProduct->slug }}" class="btn btn-sm btn-outline-primary w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Change main image
function changeMainImage(imageUrl) {
    document.getElementById('mainProductImage').src = imageUrl;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-item').forEach(thumb => {
        thumb.classList.remove('active');
    });
    event.target.classList.add('active');
}

// Quantity controls
function increaseQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQty() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
    }
}

// Add to wishlist
function addToWishlist() {
    Swal.fire({
        icon: 'success',
        title: 'Added to Wishlist!',
        text: 'Product added to your wishlist',
        timer: 2000,
        showConfirmButton: false
    });
}

// Share product
function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->name }}',
            text: '{{ $product->short_description }}',
            url: window.location.href
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        Swal.fire({
            icon: 'success',
            title: 'Link Copied!',
            text: 'Product link copied to clipboard',
            timer: 2000,
            showConfirmButton: false
        });
    }
}

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
    });
@endif
</script>

<style>
.main-image {
    position: relative;
}

.thumbnail-item {
    border: 2px solid transparent;
    transition: all 0.3s;
}

.thumbnail-item:hover,
.thumbnail-item.active {
    border-color: #0d6efd;
}

.product-card {
    transition: transform 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

.product-description img {
    max-width: 100%;
    height: auto;
}

.product-description ul,
.product-description ol {
    padding-left: 1.5rem;
}
</style>
@endpush
@endsection