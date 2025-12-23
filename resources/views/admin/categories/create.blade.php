@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-folder-plus text-primary me-2"></i>Tambah Kategori Baru
                    </h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <!-- Nama Kategori -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Contoh: Batik & Tenun" 
                               required
                               autofocus>
                        @error('name')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>Nama kategori harus unik dan maksimal 100 karakter
                        </small>
                    </div>

                    <!-- Slug (Auto Generated) -->
                    <div class="mb-4">
                        <label for="slug" class="form-label fw-semibold">Slug (URL)</label>
                        <input type="text" 
                               class="form-control" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug') }}"
                               placeholder="batik-tenun"
                               readonly>
                        <small class="form-text text-muted">
                            <i class="fas fa-magic me-1"></i>Slug akan dibuat otomatis dari nama kategori
                        </small>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Jelaskan tentang kategori ini...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-align-left me-1"></i>Maksimal 500 karakter (opsional)
                        </small>
                    </div>

                    <!-- Status Aktif -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Status Aktif
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-toggle-on me-1"></i>Aktifkan kategori agar bisa digunakan
                        </small>
                    </div>

                    <hr class="my-4">

                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-lg btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-lg btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-lightbulb text-warning me-2"></i>Tips
                </h6>
                <ul class="mb-0 small">
                    <li class="mb-2">Gunakan nama kategori yang jelas dan mudah dipahami</li>
                    <li class="mb-2">Deskripsi membantu menjelaskan jenis produk dalam kategori</li>
                    <li class="mb-2">Kategori tidak aktif tidak akan muncul di website</li>
                    <li>Pastikan nama kategori belum ada sebelumnya</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto generate slug dari nama
    document.getElementById('name').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter selain huruf, angka, spasi, dan dash
            .replace(/\s+/g, '-') // Ganti spasi dengan dash
            .replace(/-+/g, '-') // Hapus dash berlebih
            .trim();
        
        document.getElementById('slug').value = slug;
    });

    // Character counter untuk deskripsi
    const descriptionField = document.getElementById('description');
    if (descriptionField) {
        descriptionField.addEventListener('input', function() {
            const maxLength = 500;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            // Bisa ditambahkan display counter kalau mau
            console.log('Sisa karakter:', remaining);
        });
    }
</script>
@endpush