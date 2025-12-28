@extends('layouts.customer')

@section('title', 'Shopping Cart - UMKM Shop')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">
                <i class="fas fa-shopping-cart text-primary"></i> Keranjang Belanja
            </h2>
            <p class="text-muted">Review produk yang akan Anda beli</p>
        </div>
    </div>

    @if($cartItems->count() > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Item Belanja ({{ $cartItems->count() }})</h5>
                            <form action="{{ route('cart.clear') }}" method="POST" 
                                  onsubmit="return confirm('Hapus semua item dari keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i> Kosongkan Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center" style="width: 150px;">Jumlah</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <!-- Product Info -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" 
                                                         class="rounded me-3" 
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('products.show', $item->product->slug) }}" 
                                                               class="text-dark text-decoration-none">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">
                                                            <i class="fas fa-tag"></i> {{ $item->product->category->name }}
                                                        </small>
                                                        <br>
                                                        <small class="text-muted">
                                                            Stok: {{ $item->product->stock }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Price -->
                                            <td class="text-center align-middle">
                                                <strong>Rp {{ number_format($item->price, 0, ',', '.') }}</strong>
                                            </td>

                                            <!-- Quantity -->
                                            <td class="text-center align-middle">
                                                <div class="input-group input-group-sm">
                                                    <button type="button" class="btn btn-outline-secondary" 
                                                            onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity - 1 }}, {{ $item->product->stock }})">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="form-control text-center quantity-input" 
                                                           id="qty-{{ $item->product_id }}"
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           max="{{ $item->product->stock }}"
                                                           onchange="updateQuantity({{ $item->product_id }}, this.value, {{ $item->product->stock }})">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                            onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity + 1 }}, {{ $item->product->stock }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>

                                            <!-- Subtotal -->
                                            <td class="text-center align-middle">
                                                <strong class="text-primary" id="subtotal-{{ $item->product_id }}">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </strong>
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-center align-middle">
                                                <form action="{{ route('cart.remove', $item->product_id) }}" method="POST"
                                                      onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Continue Shopping -->
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </a>
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
                        <!-- Subtotal -->
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal ({{ $cartItems->count() }} item)</span>
                            <strong id="cart-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>

                        <!-- Shipping -->
                        <div class="d-flex justify-content-between mb-3">
                            <span>Ongkos Kirim</span>
                            <strong id="cart-shipping">
                                @if($subtotal >= 500000)
                                    <span class="text-success">GRATIS</span>
                                @else
                                    Rp {{ number_format($shippingCost, 0, ',', '.') }}
                                @endif
                            </strong>
                        </div>

                        @if($subtotal < 500000)
                            <div class="alert alert-info py-2 small">
                                <i class="fas fa-info-circle"></i>
                                Belanja Rp {{ number_format(500000 - $subtotal, 0, ',', '.') }} lagi untuk <strong>GRATIS ONGKIR</strong>!
                            </div>
                        @endif

                        <hr>

                        <!-- Total -->
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0">Total</h5>
                            <h4 class="mb-0 text-primary fw-bold" id="cart-total">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </h4>
                        </div>

                        <!-- Checkout Button -->
                        @auth
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 btn-lg mb-2">
                                <i class="fas fa-credit-card"></i> Checkout
                            </a>
                        @else
                            <div class="alert alert-warning py-2 small mb-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                Silakan login untuk melanjutkan
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        @endauth

                        <!-- Security Info -->
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-lock"></i> Transaksi Aman & Terpercaya
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">Keranjang Belanja Kosong</h3>
                        <p class="text-muted mb-4">Yuk mulai belanja produk UMKM berkualitas!</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag"></i> Mulai Belanja
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
    function updateQuantity(productId, newQty, maxStock) {
        // Validation
        if (newQty < 1) newQty = 1;
        if (newQty > maxStock) {
            alert('Jumlah melebihi stok tersedia!');
            newQty = maxStock;
        }

        // Update input value
        document.getElementById('qty-' + productId).value = newQty;

        // Send AJAX request
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page to update totals
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan refresh halaman.');
        });
    }
</script>
@endpush