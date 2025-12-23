@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit User
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center p-5">
                <div class="avatar avatar-xl mx-auto mb-3" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                            color: white; 
                            width: 100px; 
                            height: 100px; 
                            border-radius: 50%; 
                            display: flex; 
                            align-items: center; 
                            justify-content: center; 
                            font-size: 2.5rem;
                            font-weight: bold;">
                    {{ $user->initials }}
                </div>
                
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                <!-- Badges -->
                <div class="mb-3">
                    @if($user->isAdmin())
                        <span class="badge bg-danger fs-6">
                            <i class="fas fa-user-shield me-1"></i>Administrator
                        </span>
                    @else
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-user me-1"></i>User
                        </span>
                    @endif
                    
                    @if($user->is_active)
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-times-circle me-1"></i>Nonaktif
                        </span>
                    @endif
                </div>

                <hr>

                <!-- Contact Info -->
                <div class="text-start">
                    <div class="mb-3">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <strong>Email:</strong><br>
                        <span class="ms-4">{{ $user->email }}</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-phone text-success me-2"></i>
                        <strong>Telepon:</strong><br>
                        <span class="ms-4">{{ $user->phone }}</span>
                    </div>
                    <div class="mb-0">
                        <i class="fas fa-calendar text-info me-2"></i>
                        <strong>Bergabung:</strong><br>
                        <span class="ms-4">{{ $user->created_at->format('d M Y') }}</span><br>
                        <small class="text-muted ms-4">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Account Information -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-user-circle me-2"></i>Informasi Akun
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td width="30%" class="fw-semibold">Nama Lengkap</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Email</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">No. Telepon</td>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Role</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="badge bg-danger">
                                        <i class="fas fa-user-shield me-1"></i>Administrator
                                    </span>
                                @else
                                    <span class="badge bg-primary">
                                        <i class="fas fa-user me-1"></i>User
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Status</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activity Information -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-history me-2"></i>Aktivitas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-calendar-plus fa-2x text-primary mb-2"></i>
                            <h6 class="fw-bold mb-1">Tanggal Bergabung</h6>
                            <p class="mb-0">{{ $user->created_at->format('d F Y') }}</p>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-clock fa-2x text-success mb-2"></i>
                            <h6 class="fw-bold mb-1">Update Terakhir</h6>
                            <p class="mb-0">{{ $user->updated_at->format('d F Y') }}</p>
                            <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection