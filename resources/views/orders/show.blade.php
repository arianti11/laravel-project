@extends('layouts.customer')

@section('title', 'Order Detail - ' . $order->order_number)

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-2">
                        <i class="fas fa-receipt text-primary"></i> Detail Pesanan
                    </h2>
                    <p class="text-muted mb-0">Order Number: <strong>{{ $order->order_number }}</strong></p>
                </div>
                <div>
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        <i class="fas fa-print"></i> Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Items -->
        <div class="col-md-8 mb-4">
            <!-- Order Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-info-circle text-primary"></i> Status Pesanan
                            </h6>
                            <div class="mb-2">
                                <small class="text-muted">Order Status:</small><br>
                                <span class="badge bg-{{ $order->status_badge }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <small class="text-muted">Payment Status:</small><br>
                                <span class="badge bg-{{ $order->payment_badge }} fs-6">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-calendar text-primary"></i> Timeline
                            </h6>
                            <div class="mb-2">
                                <small class="text-muted">Order Date:</small><br>
                                <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
                            </div>
                            @if($order->paid_at)
                                <div>
                                    <small class="text-muted">Paid At:</small><br>
                                    <strong>{{ $order->paid_at->format('d M Y, H:i') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Cancel Button -->
                    @if($order->status == 'pending')
                        <div class="mt-3 pt-3 border-top">
                            <form action="{{ route('orders.cancel', $order->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Stok produk akan dikembalikan.')">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Items List -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-bag text-primary"></i> Produk yang Dipesan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" 
                                                     class="rounded me-3" 
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                                    <small class="text-muted">
                                                        Kode: {{ $item->product_code }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <strong>Rp {{ number_format($item->price, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end align-middle">
                                            <strong class="text-primary">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">
                                        <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Ongkos Kirim:</strong></td>
                                    <td class="text-end">
                                        <strong>
                                            @if($order->shipping_cost == 0)
                                                <span class="text-success">GRATIS</span>
                                            @else
                                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                            @endif
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><h5 class="mb-0">TOTAL:</h5></td>
                                    <td class="text-end">
                                        <h4 class="mb-0 text-primary fw-bold">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Info Sidebar -->
        <div class="col-md-4">
            <!-- Customer Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-user text-primary"></i> Info Pelanggan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Nama:</small>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Email:</small>
                        <strong>{{ $order->customer_email }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Telepon:</small>
                        <strong>{{ $order->customer_phone }}</strong>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-map-marker-alt text-primary"></i> Alamat Pengiriman
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">{{ $order->shipping_address }}</p>
                    <p class="mb-0">
                        {{ $order->city }}, {{ $order->province }}<br>
                        {{ $order->postal_code }}
                    </p>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-credit-card text-primary"></i> Metode Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Payment Method:</small>
                        <strong class="text-capitalize">
                            {{ str_replace('_', ' ', $order->payment_method) }}
                        </strong>
                    </div>

                    @if($order->payment_method == 'bank_transfer' && $order->payment_status == 'pending')
                        <div class="alert alert-warning mb-0">
                            <small>
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Transfer ke:</strong><br>
                                Bank BCA<br>
                                1234567890<br>
                                a.n UMKM Shop
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0">
                            <i class="fas fa-sticky-note text-primary"></i> Catatan
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 small">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4 no-print">
        <div class="col-md-12">
            <div class="d-flex gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Orders
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Belanja Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        .navbar,
        footer,
        .breadcrumb {
            display: none !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>
@endpush