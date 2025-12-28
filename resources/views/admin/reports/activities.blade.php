@extends('layouts.admin')

@section('title', 'Activities Report')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Activities Report</h2>
            <p class="text-muted">Analisis aktivitas user di sistem</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>

    <!-- Date Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.activities') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Activities by Type -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Activities by Type</h5>
                </div>
                <div class="card-body">
                    <canvas id="typeChart"></canvas>
                    
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-end">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalActivities = $activitiesByType->sum('total'); @endphp
                                    @foreach($activitiesByType as $type)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($type->type) }}
                                                </span>
                                            </td>
                                            <td class="text-center"><strong>{{ $type->total }}</strong></td>
                                            <td class="text-end">
                                                {{ number_format(($type->total / $totalActivities) * 100, 1) }}%
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

        <!-- Most Active Users -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-fire text-danger"></i> Most Active Users
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th class="text-center">Activities</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activitiesByUser as $index => $activity)
                                    <tr>
                                        <td>
                                            @if($index < 3)
                                                <span class="badge bg-warning">{{ $index + 1 }}</span>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $activity->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $activity->user->email }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $activity->user->role_badge }}">
                                                {{ $activity->user->role_label }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $activity->total }}</span>
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

    <!-- Recent Activities Timeline -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Activities Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 120px;">Type</th>
                                    <th style="width: 150px;">User</th>
                                    <th>Description</th>
                                    <th style="width: 120px;">Model</th>
                                    <th style="width: 180px;">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $activity->type_badge }}">
                                                <i class="fas {{ $activity->type_icon }}"></i>
                                                {{ ucfirst($activity->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $activity->user->name ?? 'System' }}</strong>
                                            @if($activity->user)
                                                <br>
                                                <small class="text-muted">{{ $activity->user->role }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $activity->description }}</td>
                                        <td>
                                            @if($activity->model)
                                                <span class="badge bg-secondary">{{ $activity->model }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $activity->created_at->format('d M Y') }}
                                            <br>
                                            <small class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No activities found for the selected period
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
// Activities by Type Chart
const ctx = document.getElementById('typeChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($activitiesByType->pluck('type')->map(function($t) { return ucfirst($t); })) !!},
        datasets: [{
            label: 'Activities',
            data: {!! json_encode($activitiesByType->pluck('total')) !!},
            backgroundColor: [
                'rgba(16, 185, 129, 0.8)',   // Create - Green
                'rgba(59, 130, 246, 0.8)',   // Update - Blue
                'rgba(239, 68, 68, 0.8)',    // Delete - Red
                'rgba(79, 70, 229, 0.8)',    // Login - Purple
                'rgba(156, 163, 175, 0.8)',  // Logout - Gray
                'rgba(251, 191, 36, 0.8)'    // View - Yellow
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush