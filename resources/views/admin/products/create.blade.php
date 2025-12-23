@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
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
                    <!-- Nama Produk -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Contoh: Batik Tulis Premium Motif Parang"
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
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                               value="{{ old('short_description') }}"
                               placeholder="Deskripsi singkat untuk preview (max 500 karakter)"
                               maxlength="500">
                        @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Ditampilkan di daftar produk</small>
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Deskripsi Lengkap</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="6"
                                  placeholder="Jelaskan detail produk, bahan, ukuran, dll...">{{ old('description') }}</textarea>
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
                                       value="{{ old('price') }}"
                                       placeholder="350000"
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
                                       value="{{ old('discount_price') }}"
                                       placeholder="300000"
                                       min="0">
                            </div>
                            @error('discount_price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Opsional, harus lebih kecil dari harga normal</small>
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
                                   value="{{ old('stock', 0) }}"
                                   placeholder="10"
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
                                   value="{{ old('weight') }}"
                                   placeholder="500"
                                   min="0">
                            @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Untuk keperluan ongkir</small>
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
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*"
                               onchange="previewImage(event, 'preview-main')">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                        
                        <!-- Preview -->
                        <div id="preview-main" class="mt-3" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>

                    <!-- Galeri (Multiple Upload) -->
                    <div class="mb-3">
                        <label for="images" class="form-label fw-semibold">Galeri Gambar</label>
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
                        <small class="text-muted">Bisa upload beberapa gambar sekaligus. Maksimal 2MB per file</small>
                        
                        <!-- Preview Multiple -->
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
                            <option value="ready" {{ old('status', 'ready') == 'ready' ? 'selected' : '' }}>
                                Ready - Siap Kirim
                            </option>
                            <option value="preorder" {{ old('status') == 'preorder' ? 'selected' : '' }}>
                                Pre-Order - Produksi Setelah Pesan
                            </option>
                            <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>
                                Sold Out - Habis
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
                                   {{ old('is_published', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_published">
                                Publikasikan Produk
                            </label>
                        </div>
                        <small class="text-muted">Produk yang dipublikasikan akan muncul di website</small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Produk
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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
                col.className = 'col-4';
                col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" alt="Preview ${i+1}">`;
                preview.appendChild(col);
            }
            
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush