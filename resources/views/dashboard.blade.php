@extends('layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Dashboard Monitoring Kegiatan</h3>
        <p class="text-muted small mb-0">Ringkasan progres kegiatan dan performa kerja Diskominfo Kota Medan</p>
    </div>

    <!-- Triwulan Filter Dropdown -->
    <div class="mt-3 mt-md-0 d-flex align-items-center bg-white p-2 rounded-4 shadow-sm">
        <label class="small text-muted fw-bold me-2 ps-2">
            <i class="fa-solid fa-filter text-primary me-1"></i> Filter Triwulan:
        </label>
        <form method="GET" action="{{ route('dashboard') }}" id="triwulanForm">
            <select name="triwulan" class="form-select form-select-sm border-0 bg-light rounded-pill fw-bold text-dark" onchange="document.getElementById('triwulanForm').submit()">
                <option value="1" {{ $selectedTriwulan == 1 ? 'selected' : '' }}>Triwulan I (Jan - Mar)</option>
                <option value="2" {{ $selectedTriwulan == 2 ? 'selected' : '' }}>Triwulan II (Apr - Jun)</option>
                <option value="3" {{ $selectedTriwulan == 3 ? 'selected' : '' }}>Triwulan III (Jul - Sep)</option>
                <option value="4" {{ $selectedTriwulan == 4 ? 'selected' : '' }}>Triwulan IV (Okt - Des)</option>
            </select>
        </form>
    </div>
</div>

<!-- KPI Summary Metric Cards -->
<div class="row g-3 mb-4">
    <!-- Total Activities -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card-custom p-3 h-100 border-start border-4 border-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Total Kegiatan</div>
                    <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalCount }}</h2>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4">
                    <i class="fa-solid fa-folder-open fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Ongoing Triwulan Activities -->
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card-custom p-3 h-100 border-start border-4 border-info">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Kegiatan Berjalan (Triwulan {{ $selectedTriwulan }})</div>
                    <h2 class="fw-bold text-dark mb-0 mt-1">{{ $ongoingTriwulanCount }}</h2>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-4">
                    <i class="fa-solid fa-spinner fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Near Deadline Activities (<= 14 Days) -->
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card-custom p-3 h-100 border-start border-4 border-warning">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Mendekati Tenggat (≤14 Hari)</div>
                    <h2 class="fw-bold text-warning mb-0 mt-1">{{ $nearDeadlineCount }}</h2>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4">
                    <i class="fa-solid fa-hourglass-half fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Activities -->
    <div class="col-xl-2 col-md-6 col-sm-6">
        <div class="card-custom p-3 h-100 border-start border-4 border-danger">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Terlambat</div>
                    <h2 class="fw-bold text-danger mb-0 mt-1">{{ $overdueCount }}</h2>
                </div>
                <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-4">
                    <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Activities -->
    <div class="col-xl-2 col-md-6 col-sm-6">
        <div class="card-custom p-3 h-100 border-start border-4 border-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Selesai</div>
                    <h2 class="fw-bold text-success mb-0 mt-1">{{ $completedCount }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-4">
                    <i class="fa-solid fa-circle-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Visualization Section -->
<div class="row g-4 mb-4">
    <!-- Doughnut Chart: Status Breakdown -->
    <div class="col-lg-5">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6 class="card-title-custom">
                    <i class="fa-solid fa-chart-pie me-2 text-primary"></i> Status Kegiatan
                </h6>
                <span class="badge bg-light text-dark rounded-pill">Keseluruhan</span>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center" style="position: relative; min-height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bar Chart: Step Distribution -->
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6 class="card-title-custom">
                    <i class="fa-solid fa-chart-simple me-2 text-success"></i> Distribusi Tahapan Progres (Step 0 s/d 5)
                </h6>
                <span class="badge bg-light text-dark rounded-pill">6 Tahapan</span>
            </div>
            <div class="card-body p-4" style="position: relative; min-height: 300px;">
                <canvas id="stepChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities Table -->
<div class="card-custom">
    <div class="card-header-custom">
        <h6 class="card-title-custom">
            <i class="fa-solid fa-clock-rotate-left me-2 text-info"></i> Kegiatan Terbaru
        </h6>
        <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
            Lihat Semua Kegiatan <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama Kegiatan</th>
                        <th>Pelaksana (Staff)</th>
                        <th>Metode Transaksi</th>
                        <th>Tahapan saat ini</th>
                        <th>Tenggat</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivities as $act)
                        <tr>
                            <td class="ps-4">
                                <a href="{{ route('activities.show', $act->id) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $act->title }}
                                </a>
                                <div class="text-muted small">Triwulan {{ $act->triwulan }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                        {{ strtoupper(substr($act->assignedUser->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <span class="small fw-semibold">{{ $act->assignedUser->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $act->transaction_method_name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-step bg-step-{{ $act->current_step }}">
                                    Step {{ $act->current_step }}: {{ $act->step_name }}
                                </span>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $act->deadline->format('d M Y') }}</div>
                                @if($act->current_step < 5)
                                    @if($act->remaining_days < 0)
                                        <span class="badge bg-danger">Terlambat {{ abs($act->remaining_days) }} hari</span>
                                    @elseif($act->remaining_days <= 14)
                                        <span class="badge bg-warning text-dark">Sisa {{ $act->remaining_days }} hari</span>
                                    @else
                                        <span class="text-muted small">Sisa {{ $act->remaining_days }} hari</span>
                                    @endif
                                @else
                                    <span class="badge bg-success">Tuntas</span>
                                @endif
                            </td>
                            <td>
                                @if($act->status == 'Terlambat')
                                    <span class="badge bg-status-terlambat">Terlambat</span>
                                @elseif($act->is_near_deadline)
                                    <span class="badge bg-status-mendekati">Mendekati Tenggat</span>
                                @elseif($act->status == 'Selesai')
                                    <span class="badge bg-status-selesai">Selesai</span>
                                @else
                                    <span class="badge bg-status-proses">Dalam Proses</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('activities.show', $act->id) }}" class="btn btn-sm btn-light border rounded-circle shadow-sm" title="Lihat Detail & Progress">
                                    <i class="fa-solid fa-eye text-primary"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada kegiatan yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Doughnut Chart: Status
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($statusCounts)) !!},
            datasets: [{
                data: {!! json_encode(array_values($statusCounts)) !!},
                backgroundColor: [
                    '#cbd5e1', // Belum Dimulai
                    '#3b82f6', // Dalam Proses
                    '#f59e0b', // Mendekati Tenggat
                    '#ef4444', // Terlambat
                    '#10b981'  // Selesai
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { family: 'Plus Jakarta Sans', size: 12 } }
                }
            },
            cutout: '70%'
        }
    });

    // Bar Chart: Steps
    const ctxStep = document.getElementById('stepChart').getContext('2d');
    new Chart(ctxStep, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($stepCounts)) !!},
            datasets: [{
                label: 'Jumlah Kegiatan',
                data: {!! json_encode(array_values($stepCounts)) !!},
                backgroundColor: [
                    '#94a3b8',
                    '#60a5fa',
                    '#34d399',
                    '#fbbf24',
                    '#a78bfa',
                    '#10b981'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>
@endsection
