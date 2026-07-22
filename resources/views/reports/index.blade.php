@extends('layouts.app')

@section('title', 'Laporan Monitoring')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Laporan Monitoring Kegiatan</h3>
        <p class="text-muted small mb-0">Rekapitulasi resmi pelaksanaan kegiatan Diskominfo Kota Medan dan ekspor PDF</p>
    </div>
</div>

<!-- Filter Card -->
<div class="card-custom p-4 mb-4">
    <h6 class="fw-bold text-navy mb-3">
        <i class="fa-solid fa-filter me-2 text-primary"></i> Filter Parameter Laporan
    </h6>

    <form method="GET" action="{{ route('reports.index') }}" id="reportFilterForm">
        <div class="row g-3 mb-3">
            <!-- Filter Triwulan -->
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Triwulan</label>
                <select name="triwulan" class="form-select form-select-sm rounded-3">
                    <option value="all" {{ request('triwulan') == 'all' ? 'selected' : '' }}>Semua Triwulan</option>
                    <option value="1" {{ request('triwulan') == '1' ? 'selected' : '' }}>Triwulan I (Jan - Mar)</option>
                    <option value="2" {{ request('triwulan') == '2' ? 'selected' : '' }}>Triwulan II (Apr - Jun)</option>
                    <option value="3" {{ request('triwulan') == '3' ? 'selected' : '' }}>Triwulan III (Jul - Sep)</option>
                    <option value="4" {{ request('triwulan') == '4' ? 'selected' : '' }}>Triwulan IV (Okt - Des)</option>
                </select>
            </div>

            <!-- Filter Status -->
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Status Kegiatan</label>
                <select name="status" class="form-select form-select-sm rounded-3">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Belum Dimulai" {{ request('status') == 'Belum Dimulai' ? 'selected' : '' }}>Belum Dimulai</option>
                    <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                    <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Filter Transaction Method -->
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Metode Transaksi</label>
                <select name="transaction_method" class="form-select form-select-sm rounded-3">
                    <option value="all" {{ request('transaction_method') == 'all' ? 'selected' : '' }}>Semua Metode</option>
                    <option value="1" {{ request('transaction_method') == '1' ? 'selected' : '' }}>1 - Pengadaan Langsung</option>
                    <option value="2" {{ request('transaction_method') == '2' ? 'selected' : '' }}>2 - e-Purchasing</option>
                    <option value="3" {{ request('transaction_method') == '3' ? 'selected' : '' }}>3 - Lelang</option>
                </select>
            </div>

            <!-- Filter Staff -->
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Pelaksana (Staff)</label>
                <select name="assigned_to" class="form-select form-select-sm rounded-3">
                    <option value="all" {{ request('assigned_to') == 'all' ? 'selected' : '' }}>Semua Pelaksana</option>
                    @foreach($staffUsers as $staff)
                        <option value="{{ $staff->id }}" {{ request('assigned_to') == $staff->id ? 'selected' : '' }}>
                            {{ $staff->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center pt-2">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Tampilkan Laporan
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    Reset Filter
                </a>
            </div>

            <!-- PDF Export Button -->
            <a href="{{ route('reports.pdf', request()->all()) }}" target="_blank" class="btn btn-sm btn-danger rounded-pill px-4 shadow-sm">
                <i class="fa-solid fa-file-pdf me-1"></i> Ekspor PDF Resmi
            </a>
        </div>
    </form>
</div>

<!-- Report Summary & Table -->
<div class="card-custom">
    <div class="card-header-custom">
        <h6 class="card-title-custom">
            <i class="fa-solid fa-table-list me-2 text-primary"></i> Rekapitulasi Kegiatan
        </h6>
        <span class="badge bg-primary rounded-pill">{{ count($activities) }} Data Ditemukan</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0" style="font-size: 0.88rem;">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama Kegiatan</th>
                        <th style="width: 15%;">Pelaksana</th>
                        <th style="width: 15%;">Metode Transaksi</th>
                        <th style="width: 15%;">Tahapan saat ini</th>
                        <th style="width: 12%;">Tenggat</th>
                        <th style="width: 13%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $act)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $act->title }}</div>
                                <div class="text-muted small">Triwulan {{ $act->triwulan }}</div>
                            </td>
                            <td>{{ $act->assignedUser->name ?? '-' }}</td>
                            <td>{{ $act->transaction_method_name }}</td>
                            <td>
                                <span class="badge badge-step bg-step-{{ $act->current_step }}">
                                    Step {{ $act->current_step }}: {{ $act->step_name }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ $act->deadline->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data kegiatan yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
