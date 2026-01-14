@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Tambah Produk Baru</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produk</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" data-validate="true">
            @csrf
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
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Masukkan nama produk" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
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

                            <!-- Short Description -->
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat</label>
                                <textarea name="short_description"
                                    class="form-control @error('short_description') is-invalid @enderror" rows="2"
                                    placeholder="Deskripsi singkat untuk preview (max 500 karakter)">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror" rows="6"
                                    placeholder="Deskripsi detail produk">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Gunakan HTML untuk formatting (bold, list, dll)</small>
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
                                            <input type="number" name="price"
                                                class="form-control @error('price') is-invalid @enderror"
                                                value="{{ old('price') }}" placeholder="0" min="0" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Harga Diskon</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="discount_price"
                                                class="form-control @error('discount_price') is-invalid @enderror"
                                                value="{{ old('discount_price') }}" placeholder="0" min="0">
                                            @error('discount_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Kosongkan jika tidak ada diskon</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Stok <span class="text-danger">*</span></label>
                                        <input type="number" name="stock"
                                            class="form-control @error('stock') is-invalid @enderror"
                                            value="{{ old('stock', 0) }}" min="0" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Berat (gram)</label>
                                        <input type="number" name="weight"
                                            class="form-control @error('weight') is-invalid @enderror"
                                            value="{{ old('weight') }}" placeholder="Untuk keperluan ongkir" min="0">
                                        @error('weight')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                            <!-- Main Image -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Gambar Utama <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg,image/webp" required
                                    onchange="previewMainImage(event)">
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Wajib upload gambar.</strong> Format: JPG, PNG, WEBP. Max: 2MB
                                </small>

                                <!-- Preview -->
                                <div id="mainImagePreview" class="mt-2" style="display: none;">
                                    <img id="mainImagePreviewImg" src="" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>

                            <!-- Additional Images -->
                            <div class="mb-3">
                                <label class="form-label">Gambar Tambahan (Galeri)</label>
                                <input type="file" 
                                    name="images[]" 
                                    class="form-control @error('images.*') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg,image/webp" 
                                    multiple>
                            </div>


                                <!-- Preview -->
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
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>
                                        Ready Stock
                                    </option>
                                    <option value="preorder" {{ old('status') == 'preorder' ? 'selected' : '' }}>
                                        Pre-order
                                    </option>
                                    <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>
                                        Sold Out
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published"
                                        value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Publish Produk
                                    </label>
                                </div>
                                <small class="text-muted">Jika tidak dicentang, produk akan disimpan sebagai draft</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Simpan Produk
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
<script>
// Auto-refresh CSRF token every 2 minutes
setInterval(function() {
    fetch('/csrf-token')
        .then(response => response.json())
        .then(data => {
            document.querySelector('input[name="_token"]').value = data.token;
        })
        .catch(error => console.error('Error refreshing token:', error));
}, 120000); // 2 minutes

// Prevent double submit
let isSubmitting = false;
document.querySelector('form').addEventListener('submit', function(e) {
    if (isSubmitting) {
        e.preventDefault();
        return false;
    }
    isSubmitting = true;
});

// Script lainnya...
</script>
@endpush
    @push('scripts')
    <script src="{{ asset('assets/js/form-validation.js') }}"></script>
        <script>
            // Preview main image
            function previewMainImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('mainImagePreview').style.display = 'block';
                        document.getElementById('mainImagePreviewImg').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
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

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const col = document.createElement('div');
                        col.className = 'col-4';
                        col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">`;
                        preview.appendChild(col);
                    }
                    reader.readAsDataURL(file);
                });
            }
        </script>
    @endpush
@endsection