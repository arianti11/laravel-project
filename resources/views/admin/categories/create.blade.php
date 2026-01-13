@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tambah Kategori Baru</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" data-validate="true">
        @csrf
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Kategori</h6>
                    </div>
                    <div class="card-body">
                        <!-- Category Name -->
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}"
                                   placeholder="Contoh: Kerajinan Kayu"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Slug akan dibuat otomatis dari nama kategori</small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="4"
                                      placeholder="Deskripsi singkat tentang kategori ini">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Icon/Image -->
                        <div class="mb-3">
                            <label class="form-label">Icon Kategori</label>
                            <input type="file" 
                                   name="icon" 
                                   class="form-control @error('icon') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewIcon(event)">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, WEBP. Max: 2MB. Ukuran rekomendasi: 200x200px</small>
                            
                            <!-- Preview -->
                            <div id="iconPreview" class="mt-3" style="display: none;">
                                <img id="iconPreviewImg" 
                                     src="" 
                                     class="img-thumbnail" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Status -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan Kategori
                            </label>
                        </div>
                        <small class="text-muted">
                            Kategori yang tidak aktif tidak akan ditampilkan di list produk
                        </small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Simpan Kategori
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card shadow mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            Tips
                        </h6>
                        <ul class="small mb-0 ps-3">
                            <li class="mb-2">Gunakan nama kategori yang jelas dan mudah dipahami</li>
                            <li class="mb-2">Icon kategori membantu visual di halaman produk</li>
                            <li class="mb-2">Deskripsi akan ditampilkan di halaman kategori</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/form-validation.js') }}"></script>
<script>
function previewIcon(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2048000) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('iconPreview').style.display = 'block';
            document.getElementById('iconPreviewImg').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection