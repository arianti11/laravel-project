@extends('layouts.admin')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit Produk
        </a>
    </div>
</div>

<div class="row">
    <!-- Left Column - Images -->
    <div class="col-lg-5">
        <!-- Main Image -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-0">
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid w-100 rounded"
                     style="max-height: 400px; object-fit: cover;">
            </div>
        </div>

        <!-- Gallery -->
        @if($product->images->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-images me-2"></i>Galeri Gambar
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach($product->images as $image)
                    <div class="col-4">
                        <img src="{{ $image->image_url }}" 
                             alt="Gallery" 
                             class="img-thumbnail w-100"
                             style="height: 100px; object-fit: cover; cursor: pointer;"
                             onclick="showImageModal('{{ $image->image_url }}')">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Details -->
    <div class="col-lg-7">
        <!-- Product Info -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <!-- Badge Status -->
                <div class="mb-3">
                    <span class="badge bg-{{ $product->status_badge }} me-2">
                        {{ ucfirst($product->status) }}
                    </span>
                    @if($product->is_published)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Published
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            <i class="fas fa-eye-slash me-1"></i>Draft
                        </span>
                    @endif
                    @if($product->is_on_sale)
                        <span class="badge bg-danger">
                            <i class="fas fa-fire me-1"></i>Diskon {{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h3 class="fw-bold mb-2">{{ $product->name }}</h3>
                <p class="text-muted mb-3">
                    <i class="fas fa-barcode me-1"></i>{{ $product->code }}
                </p>

                <!-- Category -->
                <div class="mb-3">
                    <span class="badge bg-light text-dark border fs-6">
                        <i class="fas fa-folder me-1"></i>{{ $product->category->name }}
                    </span>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <h4 class="text-primary fw-bold mb-1">{{ $product->formatted_price }}</h4>
                    @if($product->discount_price)
                        <div>
                            <span class="text-decoration-line-through text-muted me-2">
                                {{ $product->formatted_discount_price }}
                            </span>
                            <span class="badge bg-danger">Hemat {{ $product->discount_percentage }}%</span>
                        </div>
                    @endif
                </div>

                <!-- Short Description -->
                @if($product->short_description)
                <div class="mb-3">
                    <p class="text-muted mb-0">{{ $product->short_description }}</p>
                </div>
                @endif

                <hr class="my-4">

                <!-- Info Grid -->
                <div class="row g-3">
                    <div class="col-6">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-cubes fa-2x text-primary mb-2"></i>
                            <div class="fw-bold">{{ $product->stock }}</div>
                            <small class="text-muted">Stok Tersedia</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-weight fa-2x text-success mb-2"></i>
                            <div class="fw-bold">{{ $product->weight ?? '-' }} gram</div>
                            <small class="text-muted">Berat</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-eye fa-2x text-info mb-2"></i>
                            <div class="fw-bold">{{ $product->views }}</div>
                            <small class="text-muted">Dilihat</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-images fa-2x text-warning mb-2"></i>
                            <div class="fw-bold">{{ $product->images->count() + 1 }}</div>
                            <small class="text-muted">Gambar</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($product->description)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-align-left me-2"></i>Deskripsi Lengkap
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-line;">{{ $product->description }}</p>
            </div>
        </div>
        @endif

        <!-- Additional Info -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tbody>
                        <tr>
                            <td width="40%" class="fw-semibold">Kode Produk</td>
                            <td>{{ $product->code }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Kategori</td>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Harga Normal</td>
                            <td>{{ $product->formatted_price }}</td>
                        </tr>
                        @if($product->discount_price)
                        <tr>
                            <td class="fw-semibold">Harga Diskon</td>
                            <td>
                                {{ $product->formatted_discount_price }}
                                <span class="badge bg-danger ms-2">-{{ $product->discount_percentage }}%</span>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="fw-semibold">Stok</td>
                            <td>
                                <span class="badge {{ $product->stock < 10 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $product->stock }} unit
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Berat</td>
                            <td>{{ $product->weight ?? '-' }} gram</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Status</td>
                            <td>
                                <span class="badge bg-{{ $product->status_badge }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Publikasi</td>
                            <td>
                                @if($product->is_published)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Dipublikasikan
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-eye-slash me-1"></i>Draft
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Dibuat</td>
                            <td>{{ $product->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Update Terakhir</td>
                            <td>{{ $product->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Dilihat</td>
                            <td>{{ $product->views }} kali</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white" 
                        data-bs-dismiss="modal" 
                        style="z-index: 10;"></button>
                <img src="" alt="Preview" class="img-fluid w-100" id="modalImage">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show image in modal
    function showImageModal(imageUrl) {
        document.getElementById('modalImage').src = imageUrl;
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
</script>
@endpush