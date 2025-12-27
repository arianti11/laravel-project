@extends('layouts.staff')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header with Card -->
    <div class="card bg-gradient-primary text-white shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="mb-1">✏️ Edit Produk</h2>
                    <p class="mb-0 opacity-75">{{ $product->name }}</p>
                </div>
                <div class="col-auto">
                    <span class="badge bg-light text-dark fs-6 me-2">{{ $product->code }}</span>
                    <a href="{{ route('staff.products.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('staff.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Product Information Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informasi Produk
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Product Name -->
                    <div class="col-md-8">
                        <label class="form-label fw-bold">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               value="{{ old('name', $product->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="category_id" class="form-select form-select-lg @error('category_id') is-invalid @enderror" required>
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
                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="short_description" 
                                  class="form-control @error('short_description') is-invalid @enderror" 
                                  rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi Lengkap</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="8">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-success">
                    <i class="fas fa-dollar-sign me-2"></i>Harga & Stok
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Price -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Harga Normal <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-tag"></i> Rp
                            </span>
                            <input type="number" 
                                   name="price" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price', $product->price) }}"
                                   min="0"
                                   required>
                        </div>
                    </div>

                    <!-- Discount Price -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Harga Diskon</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-percentage"></i> Rp
                            </span>
                            <input type="number" 
                                   name="discount_price" 
                                   class="form-control @error('discount_price') is-invalid @enderror" 
                                   value="{{ old('discount_price', $product->discount_price) }}"
                                   min="0">
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Jumlah Stok <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-boxes"></i>
                            </span>
                            <input type="number" 
                                   name="stock" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   value="{{ old('stock', $product->stock) }}"
                                   min="0"
                                   required>
                            <span class="input-group-text">pcs</span>
                        </div>
                    </div>

                    <!-- Weight -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Berat Produk</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-weight"></i>
                            </span>
                            <input type="number" 
                                   name="weight" 
                                   class="form-control @error('weight') is-invalid @enderror" 
                                   value="{{ old('weight', $product->weight) }}"
                                   min="0">
                            <span class="input-group-text">gram</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Images Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-info">
                    <i class="fas fa-images me-2"></i>Gambar Produk
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Current Main Image & Upload New -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="fas fa-image me-2"></i>Gambar Utama
                        </label>
                        
                        @if($product->image)
                        <div class="mb-3 text-center">
                            <img src="{{ $product->image_url }}" class="img-fluid rounded shadow" style="max-height: 250px;">
                            <p class="text-muted small mt-2 mb-0">Gambar saat ini</p>
                        </div>
                        @endif
                        
                        <div class="border-2 border-dashed rounded p-4 text-center bg-light">
                            <input type="file" 
                                   name="image" 
                                   id="mainImage"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewMainImage(event)"
                                   style="display: none;">
                            
                            <div style="cursor: pointer;" onclick="document.getElementById('mainImage').click();">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-0 text-muted">Klik untuk upload gambar baru</p>
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                            </div>
                            
                            <div id="mainImagePreview" style="display: none;">
                                <img id="mainImagePreviewImg" src="" class="img-fluid rounded mt-2" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Images -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="fas fa-photo-video me-2"></i>Galeri
                        </label>
                        
                        @if($product->images->count() > 0)
                        <div class="row g-2 mb-3">
                            @foreach($product->images as $image)
                            <div class="col-6">
                                <div class="position-relative">
                                    <img src="{{ $image->image_url }}" 
                                         class="img-thumbnail w-100" 
                                         style="height: 120px; object-fit: cover;">
                                    <button type="button" 
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                            onclick="deleteImage({{ $image->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        
                        <div class="border-2 border-dashed rounded p-4 text-center bg-light">
                            <input type="file" 
                                   name="additional_images[]" 
                                   id="additionalImages"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   multiple
                                   onchange="previewAdditionalImages(event)"
                                   style="display: none;">
                            
                            <div style="cursor: pointer;" onclick="document.getElementById('additionalImages').click();">
                                <i class="fas fa-images fa-2x text-muted mb-2"></i>
                                <p class="mb-0 text-muted">Tambah gambar galeri</p>
                                <small class="text-muted">Max 5 gambar</small>
                            </div>
                            
                            <div id="additionalImagesPreview" class="mt-3 row g-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Stats -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning">
                    <i class="fas fa-cog me-2"></i>Pengaturan & Statistik
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status Produk</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="status" id="status1" value="ready" 
                                   {{ old('status', $product->status) == 'ready' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="status1">
                                <i class="fas fa-check-circle me-1"></i> Ready
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status2" value="preorder" 
                                   {{ old('status', $product->status) == 'preorder' ? 'checked' : '' }}>
                            <label class="btn btn-outline-warning" for="status2">
                                <i class="fas fa-clock me-1"></i> Preorder
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status3" value="sold_out" 
                                   {{ old('status', $product->status) == 'sold_out' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="status3">
                                <i class="fas fa-times-circle me-1"></i> Sold Out
                            </label>
                        </div>
                    </div>

                    <!-- Publish -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Publikasi</label>
                        <div class="form-check form-switch" style="font-size: 1.5rem;">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_published" 
                                   id="is_published"
                                   value="1"
                                   {{ old('is_published', $product->is_published) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_published" style="font-size: 1rem; margin-left: 10px;">
                                {{ $product->is_published ? 'Published' : 'Draft' }}
                            </label>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-eye fa-2x text-primary mb-2"></i>
                                        <h3 class="mb-0">{{ $product->views }}</h3>
                                        <small class="text-muted">Views</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calendar-plus fa-2x text-success mb-2"></i>
                                        <h6 class="mb-0">{{ $product->created_at->format('d M Y') }}</h6>
                                        <small class="text-muted">Dibuat</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                        <h6 class="mb-0">{{ $product->updated_at->diffForHumans() }}</h6>
                                        <small class="text-muted">Update Terakhir</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning btn-lg w-100 shadow">
                    <i class="fas fa-save me-2"></i> Update Produk
                </button>
            </div>
            <div class="col-md-6">
                <a href="{{ route('staff.products.index') }}" class="btn btn-secondary btn-lg w-100">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
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
    
    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-6';
            col.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-thumbnail w-100" style="height: 120px; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 badge bg-primary m-1">${index + 1}</span>
                </div>
            `;
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
            fetch(`/staff/products/images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire('Terhapus!', 'Gambar berhasil dihapus.', 'success');
                    setTimeout(() => location.reload(), 1500);
                }
            });
        }
    });
}
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.border-dashed {
    border-style: dashed !important;
}
</style>
@endpush
@endsection