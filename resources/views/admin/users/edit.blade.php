@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <span class="badge bg-{{ $user->role_badge }} fs-6">{{ $user->role_label }}</span>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
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
                                   value="{{ old('name', $user->name) }}"
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
                                   value="{{ old('email', $user->email) }}"
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
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password (Optional) -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Info:</strong> Kosongkan password jika tidak ingin mengubahnya
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Min. 8 karakter">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="form-control"
                                           placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>

                        <!-- Current Avatar -->
                        @if($user->avatar)
                        <div class="mb-3">
                            <label class="form-label">Foto Profil Saat Ini</label>
                            <div>
                                <img src="{{ $user->avatar_url }}" 
                                     alt="{{ $user->name }}"
                                     class="rounded-circle"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        </div>
                        @endif

                        <!-- Upload New Avatar -->
                        <div class="mb-3">
                            <label class="form-label">
                                {{ $user->avatar ? 'Ganti Foto Profil' : 'Upload Foto Profil' }}
                            </label>
                            <input type="file" 
                                   name="avatar" 
                                   class="form-control @error('avatar') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewAvatar(event)">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti
                            </small>
                            
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
                            <select name="role" 
                                    class="form-select @error('role') is-invalid @enderror" 
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                    required>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>
                                    Staff
                                </option>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                    Customer
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($user->id === auth()->id())
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>
                                Tidak bisa mengubah role sendiri
                            </small>
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                        </div>

                        <!-- Status Active -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       id="is_active"
                                       value="1"
                                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                       {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktifkan User
                                </label>
                            </div>
                            @if($user->id === auth()->id())
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>
                                Tidak bisa nonaktifkan akun sendiri
                            </small>
                            <input type="hidden" name="is_active" value="1">
                            @endif
                        </div>

                        <!-- Email Verified -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="email_verified" 
                                       id="email_verified"
                                       value="1"
                                       {{ $user->email_verified_at ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_verified">
                                    Email Verified
                                </label>
                            </div>
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
                            <small class="text-muted">Terdaftar:</small>
                            <div class="fw-bold">{{ $user->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Update Terakhir:</small>
                            <div class="fw-bold">{{ $user->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div>
                            <small class="text-muted">Update:</small>
                            <div class="fw-bold">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            @if($user->id !== auth()->id())
                            <button type="button" 
                                    class="btn btn-danger"
                                    onclick="deleteUser()">
                                <i class="fas fa-trash me-2"></i> Hapus User
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Form -->
    @if($user->id !== auth()->id())
    <form id="delete-form" 
          action="{{ route('admin.users.destroy', $user) }}" 
          method="POST" 
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

function deleteUser() {
    Swal.fire({
        title: 'Hapus User?',
        text: "Data user akan dihapus permanen!",
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