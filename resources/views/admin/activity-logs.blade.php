@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Activity Logs</h2>
            <p class="text-muted">Monitor semua aktivitas di sistem</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.activity-logs') }}" method="GET" class="row g-3">
                <!-- Type Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Type</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="create" {{ request('type') == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('type') == 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('type') == 'delete' ? 'selected' : '' }}>Delete</option>
                        <option value="login" {{ request('type') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('type') == 'logout' ? 'selected' : '' }}>Logout</option>
                        <option value="view" {{ request('type') == 'view' ? 'selected' : '' }}>View</option>
                    </select>
                </div>

                <!-- Model Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Model</label>
                    <select name="model" class="form-select form-select-sm">
                        <option value="">All Models</option>
                        <option value="Product" {{ request('model') == 'Product' ? 'selected' : '' }}>Product</option>
                        <option value="Category" {{ request('model') == 'Category' ? 'selected' : '' }}>Category</option>
                        <option value="User" {{ request('model') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Order" {{ request('model') == 'Order' ? 'selected' : '' }}>Order</option>
                    </select>
                </div>

                <!-- User Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">User</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Date From</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                </div>

                <!-- Date To -->
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Date To</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                </div>

                <!-- Button -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th style="width: 100px;">Type</th>
                            <th style="width: 150px;">User</th>
                            <th>Description</th>
                            <th style="width: 120px;">Model</th>
                            <th style="width: 150px;">IP Address</th>
                            <th style="width: 150px;">Date</th>
                            <th style="width: 80px;" class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $loop->index }}</td>
                                <td>
                                    <span class="badge bg-{{ $log->type_badge }}">
                                        <i class="fas {{ $log->type_icon }}"></i>
                                        {{ ucfirst($log->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($log->user)
                                        <strong>{{ $log->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $log->user->role }}</small>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    @if($log->model)
                                        <span class="badge bg-secondary">{{ $log->model }}</span>
                                        @if($log->model_id)
                                            <br><small class="text-muted">ID: {{ $log->model_id }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="font-monospace">{{ $log->ip_address }}</small>
                                </td>
                                <td>
                                    {{ $log->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#logModal{{ $log->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Activity Log Detail</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Type:</strong>
                                                    <span class="badge bg-{{ $log->type_badge }}">{{ ucfirst($log->type) }}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Model:</strong> {{ $log->model ?? '-' }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>User:</strong> {{ $log->user->name ?? 'System' }}
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Date:</strong> {{ $log->created_at->format('d M Y H:i:s') }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Description:</strong>
                                                <p>{{ $log->description }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <strong>IP Address:</strong> {{ $log->ip_address }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>User Agent:</strong>
                                                <small class="text-muted">{{ $log->user_agent }}</small>
                                            </div>

                                            @if($log->old_values)
                                                <div class="mb-3">
                                                    <strong>Old Values:</strong>
                                                    <pre class="bg-light p-2 rounded"><code>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</code></pre>
                                                </div>
                                            @endif

                                            @if($log->new_values)
                                                <div class="mb-3">
                                                    <strong>New Values:</strong>
                                                    <pre class="bg-light p-2 rounded"><code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</code></pre>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No activity logs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
            <div class="card-footer bg-white">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection