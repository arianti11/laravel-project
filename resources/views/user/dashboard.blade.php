@extends('layouts.appUser')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard User')

@section('content')
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h3 class="fw-bold mb-2">
                            <i class="fas fa-hand-sparkles me-2"></i>
                            Selamat Datang, {{ auth()->user()->name }}!
                        </h3>
                        <p class="mb-0 opacity-90">
                            Jelajahi koleksi produk kerajinan tangan terbaik kami
                        </p>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block text-end">
                        <i class="fas fa-user-circle" style="font-size: 5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<!-- <div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-lg me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Produk</h6>
                        <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-lg me-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-folder fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Kategori</h6>
                        <h3 class="fw-bold mb-0">{{ $totalCategories }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Kategori -->
<!-- <div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-folder text-primary me-2"></i>Kategori Produk
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($categories as $category)
                    <div class="col-md-4">
                        <div class="card border h-100">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-folder fa-3x text-primary mb-3"></i>
                                <h6 class="fw-bold mb-2">{{ $category->name }}</h6>
                                <p class="text-muted small mb-2">{{ Str::limit($category->description, 60) }}</p>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $category->products_count }} produk
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Produk Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-box text-success me-2"></i>Produk Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($latestProducts as $product)
                    <div class="col-md-4">
                        <div class="card border h-100">
                            <img src="{{ $product->image_url }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <span class="badge bg-light text-dark border mb-2">
                                    {{ $product->category->name }}
                                </span>
                                <h6 class="fw-bold">{{ Str::limit($product->name, 40) }}</h6>
                                <p class="text-muted small mb-2">
                                    {{ Str::limit($product->short_description, 60) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="text-primary fw-bold mb-0">{{ $product->formatted_price }}</h5>
                                        @if($product->discount_price)
                                            <small class="text-decoration-line-through text-muted">
                                                {{ $product->formatted_discount_price }}
                                            </small>
                                        @endif
                                    </div>
                                    <span class="badge bg-{{ $product->status_badge }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada produk</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection