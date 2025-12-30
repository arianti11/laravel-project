@extends('layouts.staff')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staff.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">Edit {{ $product->name }}</li>
        </ol>
    </nav>

    <form action="{{ route('staff.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Main Form -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Product Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Product Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $product->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Short Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Short Description</label>
                            <input type="text" name="short_description" 
                                   class="form-control @error('short_description') is-invalid @enderror" 
                                   value="{{ old('short_description', $product->short_description) }}" 
                                   maxlength="500">
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Description</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="5">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Price <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="price" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $product->price) }}" 
                                           required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Discount Price (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="discount_price" 
                                           class="form-control @error('discount_price') is-invalid @enderror" 
                                           value="{{ old('discount_price', $product->discount_price) }}">
                                </div>
                                @error('discount_price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Stock & Weight -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Stock <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="stock" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       value="{{ old('stock', $product->stock) }}" 
                                       required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Weight (grams)</label>
                                <input type="number" name="weight" 
                                       class="form-control @error('weight') is-invalid @enderror" 
                                       value="{{ old('weight', $product->weight) }}">
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" name="image" 
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty to keep current image</small>
                            
                            @if($product->image)
                                <div class="mt-2">
                                    <p class="mb-1"><strong>Current Image:</strong></p>
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}"
                                         style="max-width: 200px; height: auto;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Category & Status -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Category & Status</h6>
                    </div>
                    <div class="card-body">
                        <!-- Category (Read Only for Staff) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <input type="text" class="form-control" 
                                   value="{{ $product->category->name }}" 
                                   readonly>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Staff cannot change category
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="ready" {{ old('status', $product->status) == 'ready' ? 'selected' : '' }}>Ready Stock</option>
                                <option value="preorder" {{ old('status', $product->status) == 'preorder' ? 'selected' : '' }}>Pre-Order</option>
                                <option value="sold_out" {{ old('status', $product->status) == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Published (Read Only for Staff) -->
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Published</label>
                            <div>
                                @if($product->is_published)
                                    <span class="badge bg-success">Yes (Public)</span>
                                @else
                                    <span class="badge bg-warning">No (Draft)</span>
                                @endif
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Only admin can publish/unpublish
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Product Info</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Product Code:</strong></p>
                        <p class="mb-3"><code>{{ $product->code }}</code></p>

                        <p class="mb-2"><strong>Created:</strong></p>
                        <p class="mb-3 small">{{ $product->created_at->format('d M Y H:i') }}</p>

                        <p class="mb-2"><strong>Last Updated:</strong></p>
                        <p class="mb-0 small">{{ $product->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                        <a href="{{ route('staff.products.show', $product->id) }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="fas fa-eye"></i> View Product
                        </a>
                        <a href="{{ route('staff.products.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection