@extends('layouts.staff')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Header with Card -->
    <div class="card bg-gradient-primary text-white shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="mb-1">✨ Tambah Produk Baru</h2>
                    <p class="mb-0 opacity-75">Isi form di bawah untuk menambahkan produk baru</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('staff.products.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('staff.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
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
                               value="{{ old('name') }}"
                               placeholder="Contoh: Batik Tulis Solo Premium"
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
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                  rows="2"
                                  placeholder="Deskripsi singkat yang akan muncul di list produk (max 500 karakter)">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi Lengkap</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="8"
                                  placeholder="Jelaskan detail produk, spesifikasi, keunggulan, dll. Bisa gunakan HTML untuk formatting.">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-lightbulb me-1"></i>
                            Tips: Gunakan tag HTML seperti &lt;strong&gt;, &lt;ul&gt;, &lt;li&gt; untuk formatting yang lebih baik
                        </small>
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
                                   value="{{ old('price') }}"
                                   placeholder="350000"
                                   min="0"
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Discount Price -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Harga Diskon
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-percentage"></i> Rp
                            </span>
                            <input type="number" 
                                   name="discount_price" 
                                   class="form-control @error('discount_price') is-invalid @enderror" 
                                   value="{{ old('discount_price') }}"
                                   placeholder="315000"
                                   min="0">
                            @error('discount_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Kosongkan jika tidak ada diskon</small>
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
                                   value="{{ old('stock', 0) }}"
                                   placeholder="25"
                                   min="0"
                                   required>
                            <span class="input-group-text">pcs</span>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Weight -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Berat Produk
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-weight"></i>
                            </span>
                            <input type="number" 
                                   name="weight" 
                                   class="form-control @error('weight') is-invalid @enderror" 
                                   value="{{ old('weight') }}"
                                   placeholder="500"
                                   min="0">
                            <span class="input-group-text">gram</span>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Untuk keperluan perhitungan ongkir</small>
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
                    <!-- Main Image -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="fas fa-image me-2"></i>Gambar Utama
                        </label>
                        <div class="border-2 border-dashed rounded p-4 text-center bg-light">
                            <input type="file" 
                                   name="image" 
                                   id="mainImage"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewMainImage(event)"
                                   style="display: none;">
                            
                            <div id="mainImageUploadArea" style="cursor: pointer;" onclick="document.getElementById('mainImage').click();">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted">Klik untuk upload gambar</p>
                                <small class="text-muted">JPG, PNG, WEBP (Max 2MB)</small>
                            </div>
                            
                            <div id="mainImagePreview" style="display: none;">
                                <img id="mainImagePreviewImg" src="" class="img-fluid rounded" style="max-height: 300px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeMainImage()">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </div>
                            
                            @error('image')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Images -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="fas fa-photo-video me-2"></i>Galeri Tambahan
                        </label>
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
                                <i class="fas fa-images fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted">Klik untuk upload multiple gambar</p>
                                <small class="text-muted">Maksimal 5 gambar</small>
                            </div>
                            
                            <div id="additionalImagesPreview" class="mt-3 row g-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Actions Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning">
                    <i class="fas fa-cog me-2"></i>Pengaturan
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Status Produk <span class="text-danger">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="status" id="status1" value="ready" {{ old('status', 'ready') == 'ready' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="status1">
                                <i class="fas fa-check-circle me-1"></i> Ready
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status2" value="preorder" {{ old('status') == 'preorder' ? 'checked' : '' }}>
                            <label class="btn btn-outline-warning" for="status2">
                                <i class="fas fa-clock me-1"></i> Preorder
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status3" value="sold_out" {{ old('status') == 'sold_out' ? 'checked' : '' }}>
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
                                   {{ old('is_published', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_published" style="font-size: 1rem; margin-left: 10px;">
                                <span id="publishLabel">Publish Sekarang</span>
                            </label>
                        </div>
                        <small class="text-muted">
                            Jika tidak dicentang, produk akan disimpan sebagai draft
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary btn-lg w-100 shadow">
                    <i class="fas fa-save me-2"></i> Simpan Produk
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
<script>
// Preview main image
function previewMainImage(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2048000) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('mainImageUploadArea').style.display = 'none';
            document.getElementById('mainImagePreview').style.display = 'block';
            document.getElementById('mainImagePreviewImg').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

function removeMainImage() {
    document.getElementById('mainImage').value = '';
    document.getElementById('mainImageUploadArea').style.display = 'block';
    document.getElementById('mainImagePreview').style.display = 'none';
}

// Preview additional images
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
        if (file.size > 2048000) {
            alert(`File ${file.name} terlalu besar! Maksimal 2MB`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-6';
            col.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 badge bg-primary m-1">${index + 1}</span>
                </div>
            `;
            preview.appendChild(col);
        }
        reader.readAsDataURL(file);
    });
}

// Toggle publish label
document.getElementById('is_published').addEventListener('change', function() {
    document.getElementById('publishLabel').textContent = this.checked ? 'Publish Sekarang' : 'Simpan Sebagai Draft';
});
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