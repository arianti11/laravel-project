@extends('layouts.admin')

@section('title', 'Users Report')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Users Report</h2>
            <p class="text-muted">Analisis data user dan customer</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Active Users</p>
                            <h3 class="fw-bold mb-0 text-success">{{ $activeUsers }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-check fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Inactive Users</p>
                            <h3 class="fw-bold mb-0 text-danger">{{ $inactiveUsers }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-times fa-3x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users by Role & Top Customers -->
    <div class="row mb-4">
        <!-- Users by Role -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Users by Role</h5>
                </div>
                <div class="card-body">
                    <canvas id="roleChart"></canvas>
                    
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Role</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-end">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalUsers = $usersByRole->sum('total'); @endphp
                                    @foreach($usersByRole as $role)
                                        <tr>
                                            <td>
                                                <span class="badge bg-{{ $role->role == 'admin' ? 'danger' : ($role->role == 'staff' ? 'warning' : 'primary') }}">
                                                    {{ ucfirst($role->role) }}
                                                </span>
                                            </td>
                                            <td class="text-center"><strong>{{ $role->total }}</strong></td>
                                            <td class="text-end">
                                                {{ number_format(($role->total / $totalUsers) * 100, 1) }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-crown text-warning"></i> Top 10 Customers
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Customer</th>
                                    <th class="text-end">Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $index => $customer)
                                    <tr>
                                        <td>
                                            @if($index < 3)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-medal"></i> {{ $index + 1 }}
                                                </span>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $customer->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $customer->user->email }}</small>
                                        </td>
                                        <td class="text-end">
                                            <strong class="text-success">
                                                Rp {{ number_format($customer->total_spent, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Users (Last 30 Days) -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus text-primary"></i> New Users (Last 30 Days)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($newUsers as $user)
                                    <tr>
                                        <td><strong>{{ $user->name }}</strong></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role_badge }}">
                                                {{ $user->role_label }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">
                                            No new users in the last 30 days
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Users by Role Chart
const ctx = document.getElementById('roleChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($usersByRole->pluck('role')->map(function($r) { return ucfirst($r); })) !!},
        datasets: [{
            data: {!! json_encode($usersByRole->pluck('total')) !!},
            backgroundColor: [
                'rgba(239, 68, 68, 0.8)',   // Admin - Red
                'rgba(251, 191, 36, 0.8)',  // Staff - Yellow
                'rgba(59, 130, 246, 0.8)'   // User - Blue
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush