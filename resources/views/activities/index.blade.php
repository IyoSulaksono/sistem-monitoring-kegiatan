@extends('layouts.app')

@section('title', 'Kelola Kegiatan')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Daftar & Kelola Kegiatan</h3>
        <p class="text-muted small mb-0">Manajemen kegiatan operasional Diskominfo Kota Medan berdasarkan tahapan pekerjaan</p>
    </div>

    @if(Auth::user()->isAdminOrPptk())
        <div class="mt-3 mt-md-0">
            <a href="{{ route('activities.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Tambah Kegiatan Baru
            </a>
        </div>
    @endif
</div>

<!-- Filter Bar -->
<div class="card-custom p-3 mb-4">
    <form method="GET" action="{{ route('activities.index') }}" class="row g-3 align-items-center">
        <!-- Triwulan Filter -->
        <div class="col-md-4">
            <label class="form-label small fw-bold text-muted mb-1">Filter Triwulan</label>
            <select name="triwulan" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                <option value="all" {{ request('triwulan') == 'all' ? 'selected' : '' }}>Semua Triwulan</option>
                <option value="1" {{ request('triwulan') == '1' ? 'selected' : '' }}>Triwulan I (Jan - Mar)</option>
                <option value="2" {{ request('triwulan') == '2' ? 'selected' : '' }}>Triwulan II (Apr - Jun)</option>
                <option value="3" {{ request('triwulan') == '3' ? 'selected' : '' }}>Triwulan III (Jul - Sep)</option>
                <option value="4" {{ request('triwulan') == '4' ? 'selected' : '' }}>Triwulan IV (Okt - Des)</option>
            </select>
        </div>

        <!-- Search Bar -->
        <div class="col-md-6">
            <label class="form-label small fw-bold text-muted mb-1">Pencarian Kegiatan</label>
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari nama kegiatan atau deskripsi..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary rounded-end-pill px-3">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                </button>
            </div>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill w-100">
                <i class="fa-solid fa-rotate me-1"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- Activities Table -->
<div class="card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Kegiatan</th>
                        <th>Pelaksana (Staff)</th>
                        <th>Metode Transaksi</th>
                        <th>Tahapan (Step)</th>
                        <th>Tenggat</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $act)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">
                                {{ $activities->firstItem() + $index }}
                            </td>
                            <td style="max-width: 280px;">
                                <a href="{{ route('activities.show', $act->id) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $act->title }}
                                </a>
                                <div class="text-muted small">Triwulan {{ $act->triwulan }} ({{ $act->start_date->format('d/m/Y') }} - {{ $act->deadline->format('d/m/Y') }})</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
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
                                    <span class="badge bg-success">Selesai</span>
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
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('activities.show', $act->id) }}" class="btn btn-light border" title="Lihat Detail & Timeline Progres">
                                        <i class="fa-solid fa-eye text-primary"></i>
                                    </a>

                                    @if(Auth::user()->isAdminOrPptk() || $act->assigned_to == Auth::id())
                                        <a href="{{ route('activities.edit', $act->id) }}" class="btn btn-light border" title="Edit Kegiatan">
                                            <i class="fa-solid fa-pen-to-square text-warning"></i>
                                        </a>
                                    @endif

                                    @if(Auth::user()->isAdminOrPptk())
                                        <form action="{{ route('activities.destroy', $act->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light border" title="Hapus Kegiatan">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fs-2 d-block mb-2 text-secondary"></i>
                                Tidak ada kegiatan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($activities->hasPages())
        <div class="card-footer bg-transparent border-0 p-3">
            {{ $activities->links() }}
        </div>
    @endif
</div>
@endsection
