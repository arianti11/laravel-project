@extends('layouts.public')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">
        <i class="fas fa-credit-card me-2"></i>Checkout
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="row g-4">
            <!-- Checkout Form -->
            <div class="col-lg-8">
                <!-- Customer Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Customer Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="customer_name" 
                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                       value="{{ old('customer_name', auth()->user()->name) }}"
                                       required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       name="customer_email" 
                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                       value="{{ old('customer_email', auth()->user()->email) }}"
                                       required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="customer_phone" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       value="{{ old('customer_phone', auth()->user()->phone) }}"
                                       required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>Shipping Address
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Complete Address <span class="text-danger">*</span></label>
                                <textarea name="shipping_address" 
                                          class="form-control @error('shipping_address') is-invalid @enderror" 
                                          rows="3"
                                          placeholder="Street, house number, etc."
                                          required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city') }}"
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="province" 
                                       class="form-control @error('province') is-invalid @enderror" 
                                       value="{{ old('province') }}"
                                       required>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="postal_code" 
                                       class="form-control @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code') }}"
                                       required>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>Payment Method
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check card p-3 {{ old('payment_method', 'bank_transfer') == 'bank_transfer' ? 'border-primary' : '' }}">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="payment_method" 
                                           id="bank_transfer" 
                                           value="bank_transfer"
                                           {{ old('payment_method', 'bank_transfer') == 'bank_transfer' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="bank_transfer">
                                        <i class="fas fa-university fa-2x text-primary mb-2 d-block"></i>
                                        <strong>Bank Transfer</strong>
                                        <small class="d-block text-muted">Transfer ke rekening bank</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card p-3 {{ old('payment_method') == 'cod' ? 'border-primary' : '' }}">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="payment_method" 
                                           id="cod" 
                                           value="cod"
                                           {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="cod">
                                        <i class="fas fa-money-bill-wave fa-2x text-success mb-2 d-block"></i>
                                        <strong>Cash on Delivery</strong>
                                        <small class="d-block text-muted">Bayar saat terima</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card p-3 {{ old('payment_method') == 'ewallet' ? 'border-primary' : '' }}">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="payment_method" 
                                           id="ewallet" 
                                           value="ewallet"
                                           {{ old('payment_method') == 'ewallet' ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="ewallet">
                                        <i class="fas fa-wallet fa-2x text-info mb-2 d-block"></i>
                                        <strong>E-Wallet</strong>
                                        <small class="d-block text-muted">OVO, GoPay, Dana</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Order Notes (Optional)</h6>
                    </div>
                    <div class="card-body">
                        <textarea name="notes" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
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
                        <!-- Order Items -->
                        <div class="mb-3">
                            @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div class="flex-grow-1">
                                    <small class="fw-bold">{{ $item['product']->name }}</small>
                                    <small class="d-block text-muted">x{{ $item['quantity'] }}</small>
                                </div>
                                <small class="fw-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</small>
                            </div>
                            @endforeach
                        </div>

                        <!-- Costs -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping</span>
                            <strong>Rp {{ number_format($shippingCost, 0, ',', '.') }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <h4 class="mb-0 text-success">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </h4>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-2">
                            <i class="fas fa-check me-2"></i>
                            Place Order
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Cart
                        </a>

                        <!-- Security Badge -->
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>
                                Secure Checkout
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Radio button card styling
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.form-check.card').forEach(card => {
            card.classList.remove('border-primary');
        });
        this.closest('.card').classList.add('border-primary');
    });
});
</script>
@endpush
@endsection