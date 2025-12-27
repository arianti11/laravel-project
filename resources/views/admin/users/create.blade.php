@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tambah User Baru</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Basic Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Dasar</h6>
                    </div>
                    <div class="card-body">
                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}"
                                   placeholder="John Doe"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}"
                                   placeholder="user@example.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" 
                                   name="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone') }}"
                                   placeholder="081234567890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Min. 8 karakter"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Konfirmasi Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="form-control"
                                           placeholder="Ulangi password"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Avatar -->
                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" 
                                   name="avatar" 
                                   class="form-control @error('avatar') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewAvatar(event)">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, WEBP. Max: 2MB</small>
                            
                            <!-- Preview -->
                            <div id="avatarPreview" class="mt-3" style="display: none;">
                                <img id="avatarPreviewImg" 
                                     src="" 
                                     class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Role & Status -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Role & Status</h6>
                    </div>
                    <div class="card-body">
                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>
                                    Staff
                                </option>
                                <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>
                                    Customer
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Role Description -->
                            <div id="roleDescription" class="mt-2 small text-muted">
                                <div id="adminDesc" style="display: none;">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Administrator:</strong> Full akses ke semua fitur
                                </div>
                                <div id="staffDesc" style="display: none;">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Staff:</strong> Akses terbatas, tidak bisa manage users & categories
                                </div>
                                <div id="userDesc" style="display: none;">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Customer:</strong> Hanya bisa view & order produk
                                </div>
                            </div>
                        </div>

                        <!-- Status Active -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       id="is_active"
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktifkan User
                                </label>
                            </div>
                            <small class="text-muted">
                                User yang nonaktif tidak bisa login
                            </small>
                        </div>

                        <!-- Email Verified -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="email_verified" 
                                       id="email_verified"
                                       value="1"
                                       {{ old('email_verified', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_verified">
                                    Email Verified
                                </label>
                            </div>
                            <small class="text-muted">
                                Tandai email sebagai terverifikasi
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Simpan User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2048000) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').style.display = 'block';
            document.getElementById('avatarPreviewImg').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// Show role description
document.querySelector('select[name="role"]').addEventListener('change', function() {
    document.getElementById('adminDesc').style.display = 'none';
    document.getElementById('staffDesc').style.display = 'none';
    document.getElementById('userDesc').style.display = 'none';
    
    if (this.value === 'admin') {
        document.getElementById('adminDesc').style.display = 'block';
    } else if (this.value === 'staff') {
        document.getElementById('staffDesc').style.display = 'block';
    } else if (this.value === 'user') {
        document.getElementById('userDesc').style.display = 'block';
    }
});

// Trigger on page load if role is selected
if (document.querySelector('select[name="role"]').value) {
    document.querySelector('select[name="role"]').dispatchEvent(new Event('change'));
}
</script>
@endpush
@endsection