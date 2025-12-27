@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Info -->
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <!-- Avatar -->
                    @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" 
                         alt="{{ $user->name }}"
                         class="rounded-circle mb-3"
                         style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 150px; height: 150px; font-size: 3rem; font-weight: bold;">
                        {{ $user->initials }}
                    </div>
                    @endif

                    <!-- Name -->
                    <h4 class="mb-2">{{ $user->name }}</h4>
                    
                    <!-- Role Badge -->
                    <span class="badge bg-{{ $user->role_badge }} fs-6 mb-3">
                        {{ $user->role_label }}
                    </span>

                    <!-- Status Badges -->
                    <div class="mb-3">
                        @if($user->is_active)
                            <span class="badge bg-success me-2">
                                <i class="fas fa-check-circle me-1"></i> Active
                            </span>
                        @else
                            <span class="badge bg-secondary me-2">
                                <i class="fas fa-times-circle me-1"></i> Inactive
                            </span>
                        @endif

                        @if($user->email_verified_at)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i> Verified
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="fas fa-clock me-1"></i> Unverified
                            </span>
                        @endif
                    </div>

                    <!-- Contact Info -->
                    <div class="text-start mt-4">
                        <h6 class="text-muted small mb-3">CONTACT INFORMATION</h6>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-muted me-3"></i>
                                <div>
                                    <small class="text-muted">Email</small>
                                    <div>{{ $user->email }}</div>
                                </div>
                            </div>
                        </div>

                        @if($user->phone)
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone text-muted me-3"></i>
                                <div>
                                    <small class="text-muted">Phone</small>
                                    <div>{{ $user->phone }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Info -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Terdaftar:</small>
                        <div class="fw-bold">{{ $user->created_at->format('d M Y, H:i') }}</div>
                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Update Terakhir:</small>
                        <div class="fw-bold">{{ $user->updated_at->format('d M Y, H:i') }}</div>
                        <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                    </div>

                    @if($user->email_verified_at)
                    <div>
                        <small class="text-muted">Email Verified:</small>
                        <div class="fw-bold text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ $user->email_verified_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    @else
                    <div>
                        <small class="text-muted">Email Status:</small>
                        <div class="fw-bold text-warning">
                            <i class="fas fa-clock me-1"></i>
                            Not Verified
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activity & Details -->
        <div class="col-lg-8">
            <!-- Role Permissions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Permissions & Access</h6>
                </div>
                <div class="card-body">
                    @if($user->isAdmin())
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">
                            <i class="fas fa-user-shield me-2"></i> Administrator
                        </h6>
                        <p class="mb-0">User ini memiliki <strong>full access</strong> ke semua fitur sistem:</p>
                        <ul class="mt-2 mb-0">
                            <li>Manage all products, categories, and users</li>
                            <li>View all reports and analytics</li>
                            <li>Access system settings</li>
                            <li>View activity logs</li>
                        </ul>
                    </div>
                    @elseif($user->isStaff())
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">
                            <i class="fas fa-user-tie me-2"></i> Staff
                        </h6>
                        <p class="mb-0">User ini memiliki <strong>limited access</strong>:</p>
                        <ul class="mt-2 mb-0">
                            <li>✅ Manage products (create, edit, view)</li>
                            <li>✅ Process orders</li>
                            <li>✅ View limited reports</li>
                            <li>❌ Cannot manage categories</li>
                            <li>❌ Cannot manage users</li>
                            <li>❌ Cannot access settings</li>
                        </ul>
                    </div>
                    @else
                    <div class="alert alert-primary">
                        <h6 class="alert-heading">
                            <i class="fas fa-user me-2"></i> Customer
                        </h6>
                        <p class="mb-0">User ini adalah customer dengan akses:</p>
                        <ul class="mt-2 mb-0">
                            <li>✅ View and browse products</li>
                            <li>✅ Add to cart and checkout</li>
                            <li>✅ View order history</li>
                            <li>✅ Manage own profile</li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity (Placeholder) -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <p class="mb-0">Activity log feature akan segera diimplementasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection