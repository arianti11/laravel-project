@extends('layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Informasi Dasar -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle text-primary me-2"></i>Informasi Dasar
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Kode Produk (Read Only) -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kode Produk</label>
                        <input type="text" class="form-control" value="{{ $product->code }}" readonly>
                    </div>

                    <!-- Nama Produk -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name) }}"
                               required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">Pilih Kategori</option>
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

                    <!-- Deskripsi Singkat -->
                    <div class="mb-4">
                        <label for="short_description" class="form-label fw-semibold">Deskripsi Singkat</label>
                        <input type="text" 
                               class="form-control @error('short_description') is-invalid @enderror" 
                               id="short_description" 
                               name="short_description" 
                               value="{{ old('short_description', $product->short_description) }}"
                               maxlength="500">
                        @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Deskripsi Lengkap</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="6">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Harga & Stok -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-tags text-success me-2"></i>Harga & Stok
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Harga -->
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-semibold">
                                Harga Normal <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $product->price) }}"
                                       min="0"
                                       required>
                            </div>
                            @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga Diskon -->
                        <div class="col-md-6 mb-3">
                            <label for="discount_price" class="form-label fw-semibold">Harga Diskon</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('discount_price') is-invalid @enderror" 
                                       id="discount_price" 
                                       name="discount_price" 
                                       value="{{ old('discount_price', $product->discount_price) }}"
                                       min="0">
                            </div>
                            @error('discount_price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold">
                                Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', $product->stock) }}"
                                   min="0"
                                   required>
                            @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Berat -->
                        <div class="col-md-6 mb-3">
                            <label for="weight" class="form-label fw-semibold">Berat (gram)</label>
                            <input type="number" 
                                   class="form-control @error('weight') is-invalid @enderror" 
                                   id="weight" 
                                   name="weight" 
                                   value="{{ old('weight', $product->weight) }}"
                                   min="0">
                            @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Gambar -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-images text-info me-2"></i>Gambar Produk
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Gambar Utama -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">Gambar Utama</label>
                        
                        <!-- Current Image -->
                        @if($product->image)
                        <div class="mb-3">
                            <p class="small text-muted mb-2">Gambar saat ini:</p>
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-thumbnail"
                                 style="max-width: 200px;">
                        </div>
                        @endif
                        
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*"
                               onchange="previewImage(event, 'preview-main')">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Upload gambar baru untuk mengganti. Format: JPG, PNG. Maksimal 2MB</small>
                        
                        <!-- New Preview -->
                        <div id="preview-main" class="mt-3" style="display: none;">
                            <p class="small text-muted mb-2">Preview gambar baru:</p>
                            <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>

                    <!-- Galeri Existing -->
                    @if($product->images->count() > 0)
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Galeri Saat Ini</label>
                        <div class="row g-2">
                            @foreach($product->images as $image)
                            <div class="col-3" id="gallery-item-{{ $image->id }}">
                                <div class="position-relative">
                                    <img src="{{ $image->image_url }}" 
                                         alt="Gallery" 
                                         class="img-thumbnail w-100">
                                    <button type="button" 
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                            onclick="deleteGalleryImage({{ $image->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Tambah Galeri Baru -->
                    <div class="mb-3">
                        <label for="images" class="form-label fw-semibold">Tambah Gambar ke Galeri</label>
                        <input type="file" 
                               class="form-control @error('images.*') is-invalid @enderror" 
                               id="images" 
                               name="images[]"
                               accept="image/*"
                               multiple
                               onchange="previewMultipleImages(event)">
                        @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Bisa upload beberapa gambar sekaligus</small>
                        
                        <!-- Preview New Gallery -->
                        <div id="preview-gallery" class="row g-2 mt-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Status & Publish -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-cog text-secondary me-2"></i>Pengaturan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Status Produk -->
                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">
                            Status Produk <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="ready" {{ old('status', $product->status) == 'ready' ? 'selected' : '' }}>
                                Ready - Siap Kirim
                            </option>
                            <option value="preorder" {{ old('status', $product->status) == 'preorder' ? 'selected' : '' }}>
                                Pre-Order
                            </option>
                            <option value="sold_out" {{ old('status', $product->status) == 'sold_out' ? 'selected' : '' }}>
                                Sold Out
                            </option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Publish -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1"
                                   {{ old('is_published', $product->is_published) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_published">
                                Publikasikan Produk
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Informasi</h6>
                    <div class="small">
                        <div class="mb-2">
                            <strong>Dibuat:</strong><br>
                            {{ $product->created_at->format('d M Y, H:i') }}
                        </div>
                        <div class="mb-2">
                            <strong>Update Terakhir:</strong><br>
                            {{ $product->updated_at->format('d M Y, H:i') }}
                        </div>
                        <div>
                            <strong>Dilihat:</strong><br>
                            {{ $product->views }} kali
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Produk
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="button" 
                                class="btn btn-outline-danger btn-lg"
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Hapus Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Data yang dihapus tidak dapat dikembalikan!
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview single image
    function previewImage(event, previewId) {
        const preview = document.getElementById(previewId);
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.style.display = 'block';
                preview.querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Preview multiple images
    function previewMultipleImages(event) {
        const preview = document.getElementById('preview-gallery');
        preview.innerHTML = '';
        
        const files = event.target.files;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-3';
                col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail w-100" alt="Preview ${i+1}">`;
                preview.appendChild(col);
            }
            
            reader.readAsDataURL(file);
        }
    }

    // Delete gallery image (AJAX)
    function deleteGalleryImage(imageId) {
        if (!confirm('Hapus gambar ini?')) return;
        
        fetch(`/admin/products/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`gallery-item-${imageId}`).remove();
                alert('Gambar berhasil dihapus!');
            } else {
                alert('Gagal menghapus gambar: ' + data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan: ' + error);
        });
    }
</script>
@endpush