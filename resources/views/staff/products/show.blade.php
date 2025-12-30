@extends('layouts.staff')

@section('title', 'Product Detail')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staff.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image & Gallery -->
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

                    <!-- Additional Images (if any) -->
                    @if($product->images && $product->images->count() > 0)
                        <div class="row g-2">
                            @foreach($product->images as $image)
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $image->image) }}" 
                                         class="img-fluid rounded cursor-pointer"
                                         onclick="document.getElementById('main-image').src = this.src">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Product Information</h5>
                    <a href="{{ route('staff.products.edit', $product->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Product
                    </a>
                </div>
                <div class="card-body">
                    <!-- Product Name -->
                    <h3 class="fw-bold mb-3">{{ $product->name }}</h3>

                    <!-- Category & Code -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Category:</strong></p>
                            <span class="badge bg-primary">{{ $product->category->name }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Product Code:</strong></p>
                            <code>{{ $product->code }}</code>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <p class="mb-1"><strong>Price:</strong></p>
                        <h4 class="text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                        @if($product->discount_price)
                            <small class="text-muted text-decoration-line-through">
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            </small>
                        @endif
                    </div>

                    <!-- Stock & Status -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Stock:</strong></p>
                            @if($product->stock < 10)
                                <h5 class="text-danger mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $product->stock }} units
                                </h5>
                            @else
                                <h5 class="text-success mb-0">{{ $product->stock }} units</h5>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong></p>
                            @if($product->status == 'ready')
                                <span class="badge bg-success fs-6">Ready Stock</span>
                            @elseif($product->status == 'preorder')
                                <span class="badge bg-warning fs-6">Pre-Order</span>
                            @else
                                <span class="badge bg-secondary fs-6">Sold Out</span>
                            @endif
                        </div>
                    </div>

                    <!-- Weight & Views -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Weight:</strong></p>
                            <p class="mb-0">{{ $product->weight ?? 0 }}g</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Views:</strong></p>
                            <p class="mb-0">{{ $product->views }} times</p>
                        </div>
                    </div>

                    <!-- Published Status -->
                    <div class="mb-3">
                        <p class="mb-1"><strong>Published:</strong></p>
                        @if($product->is_published)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-danger">No (Draft)</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    @if($product->short_description)
                        <div class="alert alert-light mb-3">
                            <strong>Quick Info:</strong><br>
                            {{ $product->short_description }}
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('staff.products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                        <a href="{{ route('staff.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Full Description</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $product->description ?? 'No description available.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection