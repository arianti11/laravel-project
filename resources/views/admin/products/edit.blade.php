@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produk</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <span class="badge bg-info">{{ $product->code }}</span>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Basic Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Produk</h6>
                    </div>
                    <div class="card-body">
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $product->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Short Description -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="short_description" 
                                      class="form-control @error('short_description') is-invalid @enderror" 
                                      rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="6">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Harga & Stok</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Harga Normal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               name="price" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               value="{{ old('price', $product->price) }}"
                                               min="0"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Harga Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               name="discount_price" 
                                               class="form-control @error('discount_price') is-invalid @enderror" 
                                               value="{{ old('discount_price', $product->discount_price) }}"
                                               min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="stock" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock', $product->stock) }}"
                                           min="0"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Berat (gram)</label>
                                    <input type="number" 
                                           name="weight" 
                                           class="form-control @error('weight') is-invalid @enderror" 
                                           value="{{ old('weight', $product->weight) }}"
                                           min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gambar Produk</h6>
                    </div>
                    <div class="card-body">
                        <!-- Current Main Image -->
                        @if($product->image)
                        <div class="mb-3">
                            <label class="form-label">Gambar Utama Saat Ini</label>
                            <div>
                                <img src="{{ $product->image_url }}" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                        @endif

                        <!-- Upload New Main Image -->
                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar Utama</label>
                            <input type="file" 
                                   name="image" 
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewMainImage(event)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                            
                            <div id="mainImagePreview" class="mt-2" style="display: none;">
                                <img id="mainImagePreviewImg" src="" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>

                        <!-- Current Additional Images -->
                        @if($product->images->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Gambar Galeri Saat Ini</label>
                            <div class="row g-2">
                                @foreach($product->images as $image)
                                <div class="col-3">
                                    <div class="position-relative">
                                        <img src="{{ $image->image_url }}" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                                        <button type="button" 
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                onclick="deleteImage({{ $image->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Upload Additional Images -->
                        <div class="mb-3">
                            <label class="form-label">Tambah Gambar Galeri</label>
                            <input type="file" 
                                   name="additional_images[]" 
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   multiple
                                   onchange="previewAdditionalImages(event)">
                            <small class="text-muted">Pilih multiple file (Max 5 gambar)</small>
                            
                            <div id="additionalImagesPreview" class="mt-2 row g-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Status & Publish -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Produk</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="ready" {{ old('status', $product->status) == 'ready' ? 'selected' : '' }}>
                                    Ready Stock
                                </option>
                                <option value="preorder" {{ old('status', $product->status) == 'preorder' ? 'selected' : '' }}>
                                    Pre-order
                                </option>
                                <option value="sold_out" {{ old('status', $product->status) == 'sold_out' ? 'selected' : '' }}>
                                    Sold Out
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_published" 
                                       id="is_published"
                                       value="1"
                                       {{ old('is_published', $product->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Publish Produk
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Stats -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Views:</small>
                            <div class="fw-bold">{{ $product->views }}</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Dibuat:</small>
                            <div class="fw-bold">{{ $product->created_at->format('d M Y') }}</div>
                        </div>
                        <div>
                            <small class="text-muted">Update Terakhir:</small>
                            <div class="fw-bold">{{ $product->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Produk
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function previewMainImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('mainImagePreview').style.display = 'block';
            document.getElementById('mainImagePreviewImg').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

function previewAdditionalImages(event) {
    const files = event.target.files;
    const preview = document.getElementById('additionalImagesPreview');
    preview.innerHTML = '';
    
    if (files.length > 5) {
        alert('Maksimal 5 gambar tambahan');
        event.target.value = '';
        return;
    }
    
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-4';
            col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">`;
            preview.appendChild(col);
        }
        reader.readAsDataURL(file);
    });
}

function deleteImage(imageId) {
    Swal.fire({
        title: 'Hapus Gambar?',
        text: "Gambar akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/products/images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire('Terhapus!', 'Gambar berhasil dihapus.', 'success');
                location.reload();
            });
        }
    });
}
</script>
@endpush
@endsection