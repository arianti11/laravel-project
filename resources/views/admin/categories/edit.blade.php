@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Kategori</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <span class="badge bg-info">{{ $category->slug }}</span>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
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
                                   value="{{ old('name', $category->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Slug saat ini: <strong>{{ $category->slug }}</strong>
                            </small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Icon -->
                        @if($category->icon)
                        <div class="mb-3">
                            <label class="form-label">Icon Saat Ini</label>
                            <div>
                                <img src="{{ $category->icon_url }}" 
                                     alt="{{ $category->name }}"
                                     class="img-thumbnail"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                        @endif

                        <!-- Upload New Icon -->
                        <div class="mb-3">
                            <label class="form-label">
                                {{ $category->icon ? 'Ganti Icon' : 'Upload Icon' }}
                            </label>
                            <input type="file" 
                                   name="icon" 
                                   class="form-control @error('icon') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewIcon(event)">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti. Format: JPG, PNG, WEBP. Max: 2MB
                            </small>
                            
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
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan Kategori
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Total Produk:</small>
                            <div class="h4 mb-0 text-primary">
                                <i class="fas fa-box me-2"></i>
                                {{ $category->products_count }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Dibuat:</small>
                            <div class="fw-bold">{{ $category->created_at->format('d M Y') }}</div>
                        </div>
                        <div>
                            <small class="text-muted">Update Terakhir:</small>
                            <div class="fw-bold">{{ $category->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Kategori
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            @if($category->products_count == 0)
                            <button type="button" 
                                    class="btn btn-danger"
                                    onclick="deleteCategory()">
                                <i class="fas fa-trash me-2"></i> Hapus Kategori
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Warning if has products -->
                @if($category->products_count > 0)
                <div class="alert alert-warning mt-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <small>
                        <strong>Perhatian!</strong> Kategori ini memiliki {{ $category->products_count }} produk dan tidak dapat dihapus.
                    </small>
                </div>
                @endif
            </div>
        </div>
    </form>

    <!-- Delete Form -->
    <form id="delete-form" 
          action="{{ route('admin.categories.destroy', $category) }}" 
          method="POST" 
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

function deleteCategory() {
    Swal.fire({
        title: 'Hapus Kategori?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endpush
@endsection