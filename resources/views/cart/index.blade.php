@extends('layouts.public')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">
        <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
    </h1>

    @if(count($cartItems) > 0)
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    @foreach($cartItems as $index => $item)
                    <div class="row align-items-center py-3 {{ $index > 0 ? 'border-top' : '' }}">
                        <div class="col-md-2">
                            <img src="{{ $item['product']->image_url }}" 
                                 alt="{{ $item['product']->name }}"
                                 class="img-fluid rounded">
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1">
                                <a href="{{ route('products.show', $item['product']->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $item['product']->name }}
                                </a>
                            </h6>
                            <small class="text-muted">{{ $item['product']->code }}</small>
                        </div>
                        <div class="col-md-2">
                            <div class="fw-bold text-success">
                                {{ number_format($item['product']->final_price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" 
                                            type="button"
                                            onclick="this.nextElementSibling.stepDown(); this.form.submit();">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" 
                                           name="quantity"
                                           class="form-control text-center" 
                                           value="{{ $item['quantity'] }}"
                                           min="1"
                                           max="{{ $item['product']->stock }}"
                                           onchange="this.form.submit()">
                                    <button class="btn btn-outline-secondary" 
                                            type="button"
                                            onclick="this.previousElementSibling.stepUp(); this.form.submit();">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                            <small class="text-muted">Max: {{ $item['product']->stock }}</small>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="fw-bold text-success mb-2">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                            <form action="{{ route('cart.remove', $item['product']->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Hapus produk dari keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    <!-- Clear Cart Button -->
                    <div class="text-end mt-3 pt-3 border-top">
                        <form action="{{ route('cart.clear') }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Kosongkan semua keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash-alt me-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <strong>Rp {{ number_format($shippingCost, 0, ',', '.') }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <h4 class="mb-0 text-success">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </h4>
                    </div>
                    
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 mb-2">
                            <i class="fas fa-lock me-2"></i>
                            Proceed to Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-2">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Login to Checkout
                        </a>
                    @endauth
                    
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
        <h3 class="mb-3">Your cart is empty</h3>
        <p class="text-muted mb-4">Add some products to your cart and they will appear here</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-shopping-bag me-2"></i>
            Start Shopping
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
@endpush
@endsection