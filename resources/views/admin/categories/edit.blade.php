@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-edit text-warning me-2"></i>Edit Kategori
                    </h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Kategori -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name) }}"
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
                               value="{{ old('slug', $category->slug) }}"
                               placeholder="batik-tenun"
                               readonly>
                        <small class="form-text text-muted">
                            <i class="fas fa-magic me-1"></i>Slug akan diupdate otomatis jika nama berubah
                        </small>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Jelaskan tentang kategori ini...">{{ old('description', $category->description) }}</textarea>
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
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Status Aktif
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-toggle-on me-1"></i>Nonaktifkan kategori jika tidak ingin ditampilkan
                        </small>
                    </div>

                    <!-- Info Produk -->
                    @if($category->products()->count() > 0)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Kategori ini memiliki <strong>{{ $category->products()->count() }} produk</strong>
                    </div>
                    @endif

                    <hr class="my-4">

                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-between">
                        <button type="button" 
                                class="btn btn-lg btn-outline-danger"
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Hapus Kategori
                        </button>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-lg btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="fas fa-save me-2"></i>Update Kategori
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-info-circle text-info me-2"></i>Informasi
                </h6>
                <div class="row small">
                    <div class="col-md-6 mb-2">
                        <strong>Dibuat:</strong><br>
                        {{ $category->created_at->format('d M Y, H:i') }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Terakhir Update:</strong><br>
                        {{ $category->updated_at->format('d M Y, H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Jumlah Produk:</strong><br>
                        {{ $category->products()->count() }} produk
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong><br>
                        <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                <p class="mb-0">Apakah Anda yakin ingin menghapus kategori <strong>{{ $category->name }}</strong>?</p>
                @if($category->products()->count() > 0)
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Kategori ini memiliki <strong>{{ $category->products()->count() }} produk</strong> dan tidak bisa dihapus!
                    </div>
                @else
                    <div class="alert alert-danger mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Data yang dihapus tidak dapat dikembalikan!
                    </div>
                @endif
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                @if($category->products()->count() == 0)
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus Permanen
                    </button>
                </form>
                @endif
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
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        
        document.getElementById('slug').value = slug;
    });

    // Character counter untuk deskripsi
    const descriptionField = document.getElementById('description');
    if (descriptionField) {
        const maxLength = 500;
        const currentLength = descriptionField.value.length;
        
        descriptionField.addEventListener('input', function() {
            const remaining = maxLength - this.value.length;
            console.log('Sisa karakter:', remaining);
        });
    }
</script>
@endpush