@extends('layouts.customer')

@section('title', 'Checkout - UMKM Shop')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">
                <i class="fas fa-credit-card text-primary"></i> Checkout
            </h2>
            <p class="text-muted">Lengkapi data pengiriman dan selesaikan pesanan Anda</p>
        </div>
    </div>

    <!-- Checkout Steps -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-center flex-fill">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <p class="mb-0 small fw-semibold">Cart</p>
                        </div>
                        <div class="flex-fill" style="height: 2px; background: #ddd;"></div>
                        <div class="text-center flex-fill">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <p class="mb-0 small fw-semibold text-primary">Checkout</p>
                        </div>
                        <div class="flex-fill" style="height: 2px; background: #ddd;"></div>
                        <div class="text-center flex-fill">
                            <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-check"></i>
                            </div>
                            <p class="mb-0 small text-muted">Complete</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm" data-validate="true">
        @csrf
        
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-md-8">
                <!-- Customer Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-user text-primary"></i> Informasi Pelanggan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="customer_name" 
                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                       value="{{ old('customer_name', $user->name) }}" 
                                       required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       name="customer_email" 
                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                       value="{{ old('customer_email', $user->email) }}" 
                                       required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">
                                    Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="customer_phone" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       value="{{ old('customer_phone', $user->phone) }}" 
                                       placeholder="08xxxxxxxxxx"
                                       required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt text-primary"></i> Alamat Pengiriman
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea name="shipping_address" 
                                      class="form-control @error('shipping_address') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Jl. Nama Jalan, No. Rumah, RT/RW, Kelurahan"
                                      required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Kota/Kabupaten <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city') }}" 
                                       placeholder="Contoh: Jakarta"
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Provinsi <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="province" 
                                       class="form-control @error('province') is-invalid @enderror" 
                                       value="{{ old('province') }}" 
                                       placeholder="Contoh: DKI Jakarta"
                                       required>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Kode Pos <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="postal_code" 
                                       class="form-control @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code') }}" 
                                       placeholder="12345"
                                       required>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card text-primary"></i> Metode Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3 p-3 border rounded">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="bank_transfer" 
                                   value="bank_transfer" 
                                   {{ old('payment_method', 'bank_transfer') == 'bank_transfer' ? 'checked' : '' }}
                                   required>
                            <label class="form-check-label w-100" for="bank_transfer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Transfer Bank</strong>
                                        <p class="mb-0 small text-muted">Transfer ke rekening Bank BCA</p>
                                    </div>
                                    <i class="fas fa-university fa-2x text-primary"></i>
                                </div>
                            </label>
                        </div>

                        <div class="form-check mb-3 p-3 border rounded">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="cod" 
                                   value="cod"
                                   {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                            <label class="form-check-label w-100" for="cod">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Cash on Delivery (COD)</strong>
                                        <p class="mb-0 small text-muted">Bayar saat barang diterima</p>
                                    </div>
                                    <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                </div>
                            </label>
                        </div>

                        <div class="form-check mb-0 p-3 border rounded">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="ewallet" 
                                   value="ewallet"
                                   {{ old('payment_method') == 'ewallet' ? 'checked' : '' }}>
                            <label class="form-check-label w-100" for="ewallet">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>E-Wallet</strong>
                                        <p class="mb-0 small text-muted">GoPay, OVO, DANA, dll</p>
                                    </div>
                                    <i class="fas fa-wallet fa-2x text-warning"></i>
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <div class="text-danger mt-2 small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note text-primary"></i> Catatan (Opsional)
                        </h5>
                    </div>
                    <div class="card-body">
                        <textarea name="notes" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Tambahkan catatan untuk pesanan Anda...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt"></i> Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Cart Items -->
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3">Produk ({{ $cartItems->count() }})</h6>
                            <div style="max-height: 300px; overflow-y: auto;">
                                @foreach($cartItems as $item)
                                    <div class="d-flex mb-3 pb-3 border-bottom">
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                             class="rounded me-2" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <p class="mb-1 small">{{ Str::limit($item->product->name, 30) }}</p>
                                            <small class="text-muted">
                                                {{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <strong class="small">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <hr>

                        <!-- Price Summary -->
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Ongkos Kirim:</span>
                            <strong>
                                @if($shippingCost == 0)
                                    <span class="text-success">GRATIS</span>
                                @else
                                    Rp {{ number_format($shippingCost, 0, ',', '.') }}
                                @endif
                            </strong>
                        </div>

                        @if($subtotal < 500000)
                            <div class="alert alert-info py-2 mb-3 small">
                                <i class="fas fa-info-circle"></i>
                                Belanja Rp {{ number_format(500000 - $subtotal, 0, ',', '.') }} lagi untuk <strong>GRATIS ONGKIR</strong>!
                            </div>
                        @endif

                        <hr>

                        <!-- Total -->
                        <div class="mb-4 d-flex justify-content-between">
                            <h5 class="mb-0">Total:</h5>
                            <h4 class="mb-0 text-primary fw-bold">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </h4>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 btn-lg mb-2" id="submitBtn">
                            <i class="fas fa-check-circle"></i> Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali ke Cart
                        </a>

                        <!-- Security Info -->
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-lock"></i> Transaksi Aman & Terenkripsi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script>
    // Form validation & submit handling
    document.getElementById('checkoutForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
</script>
@endpush