@extends('layouts.app')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="mb-4">
    <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mb-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Kegiatan
    </a>
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <h3 class="fw-bold text-dark mb-1">{{ $activity->title }}</h3>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <span class="badge bg-light text-dark border">
                    <i class="fa-solid fa-calendar me-1"></i> Triwulan {{ $activity->triwulan }}
                </span>
                <span class="badge bg-light text-dark border">
                    <i class="fa-solid fa-receipt me-1"></i> {{ $activity->transaction_method_name }}
                </span>
                @if($activity->status == 'Terlambat')
                    <span class="badge bg-status-terlambat">Terlambat</span>
                @elseif($activity->is_near_deadline)
                    <span class="badge bg-status-mendekati">Mendekati Tenggat</span>
                @elseif($activity->status == 'Selesai')
                    <span class="badge bg-status-selesai">Selesai</span>
                @else
                    <span class="badge bg-status-proses">Dalam Proses</span>
                @endif
            </div>
        </div>

        <div class="mt-3 mt-md-0 d-flex gap-2">
            <button class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addProgressModal">
                <i class="fa-solid fa-plus-circle me-1"></i> Update Progres
            </button>
            @if(Auth::user()->isAdminOrPptk() || $activity->assigned_to == Auth::id())
                <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fa-solid fa-pen me-1"></i> Edit
                </a>
            @endif
        </div>
    </div>
</div>

<!-- 6-Step Visual Stepper Bar -->
<div class="card-custom mb-4 p-4">
    <h6 class="fw-bold text-secondary mb-3">
        <i class="fa-solid fa-bars-staggered me-2 text-primary"></i> Alur Tahapan Kegiatan (Step {{ $activity->current_step }} / 5)
    </h6>

    <div class="row g-2 text-center align-items-center">
        @foreach(\App\Models\Activity::STEPS as $stepCode => $stepName)
            @php
                $isCompleted = $activity->current_step > $stepCode;
                $isCurrent = $activity->current_step == $stepCode;
            @endphp
            <div class="col-md-2 col-4">
                <div class="p-2 rounded-3 border {{ $isCurrent ? 'bg-primary text-white border-primary shadow' : ($isCompleted ? 'bg-success bg-opacity-10 text-success border-success' : 'bg-light text-muted border-light-subtle') }}">
                    <div class="fw-bold small">Step {{ $stepCode }}</div>
                    <div style="font-size: 0.75rem;">{{ $stepName }}</div>
                    @if($isCurrent)
                        <span class="badge bg-white text-primary mt-1" style="font-size: 0.65rem;">Saat Ini</span>
                    @elseif($isCompleted)
                        <i class="fa-solid fa-circle-check text-success mt-1 small"></i>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="row g-4">
    <!-- Meta Info Column -->
    <div class="col-lg-4">
        <div class="card-custom p-4 mb-4">
            <h6 class="fw-bold text-dark mb-3">Informasi Kegiatan</h6>
            
            <div class="mb-3">
                <label class="text-muted small d-block">Deskripsi</label>
                <p class="small text-dark mb-0">{{ $activity->description ?: 'Tidak ada deskripsi rincian.' }}</p>
            </div>

            <hr class="text-muted my-3">

            <div class="mb-3">
                <label class="text-muted small d-block">Pelaksana / Penanggung Jawab</label>
                <div class="d-flex align-items-center mt-1">
                    <div class="avatar-circle me-2" style="width: 34px; height: 34px; font-size: 0.85rem;">
                        {{ strtoupper(substr($activity->assignedUser->name ?? 'S', 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold small">{{ $activity->assignedUser->name ?? '-' }}</div>
                        <div class="text-muted small" style="font-size: 0.7rem;">{{ $activity->assignedUser->position ?? 'Staf Pelaksana' }}</div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="text-muted small d-block">Metode Transaksi</label>
                <div class="fw-semibold text-dark small">{{ $activity->transaction_method_name }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label class="text-muted small d-block">Tanggal Mulai</label>
                    <div class="fw-semibold text-dark small">{{ $activity->start_date->format('d M Y') }}</div>
                </div>
                <div class="col-6">
                    <label class="text-muted small d-block">Tenggat (Deadline)</label>
                    <div class="fw-semibold text-dark small">{{ $activity->deadline->format('d M Y') }}</div>
                </div>
            </div>

            <div class="p-3 bg-light rounded-3 text-center border">
                <div class="small text-muted mb-1">Status Sisa Waktu</div>
                @if($activity->current_step == 5)
                    <div class="fw-bold text-success"><i class="fa-solid fa-circle-check me-1"></i> Tuntas / Selesai 100%</div>
                @elseif($activity->remaining_days < 0)
                    <div class="fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i> Terlambat {{ abs($activity->remaining_days) }} Hari</div>
                @elseif($activity->remaining_days <= 14)
                    <div class="fw-bold text-warning"><i class="fa-solid fa-clock me-1"></i> Mendekati Tenggat (Sisa {{ $activity->remaining_days }} Hari)</div>
                @else
                    <div class="fw-bold text-primary"><i class="fa-solid fa-calendar-check me-1"></i> Sisa {{ $activity->remaining_days }} Hari Lagi</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Timeline History Column -->
    <div class="col-lg-8">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-timeline me-2 text-primary"></i> Riwayat & Log Progres Kegiatan
                </h6>
                <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addProgressModal">
                    <i class="fa-solid fa-plus me-1"></i> Log Baru
                </button>
            </div>

            <!-- Vertical Timeline -->
            <div class="timeline ps-3" style="border-left: 2px solid #e2e8f0; margin-left: 10px;">
                @forelse($activity->progressLogs as $log)
                    <div class="timeline-item position-relative ps-4 pb-4">
                        <!-- Bullet Icon -->
                        <div class="position-absolute bg-primary rounded-circle border border-3 border-white" style="width: 16px; height: 16px; left: -9px; top: 2px;"></div>

                        <div class="bg-light p-3 rounded-4 border">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-step bg-step-{{ $log->step }}">
                                    Step {{ $log->step }}: {{ $log->step_name }}
                                </span>
                                <span class="text-muted small" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB
                                </span>
                            </div>

                            <p class="mb-2 text-dark small fw-semibold">{{ $log->description }}</p>

                            @if($log->notes)
                                <div class="p-2 bg-white rounded-3 small border-start border-3 border-info text-muted">
                                    <i class="fa-regular fa-note-sticky text-info me-1"></i> <strong>Catatan:</strong> {{ $log->notes }}
                                </div>
                            @endif

                            <div class="mt-2 text-muted small" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-user-pen me-1"></i> Ditambahkan oleh: {{ $log->creator->name ?? 'Sistem' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-clipboard-list fs-2 d-block mb-2 text-secondary"></i>
                        Belum ada catatan progres. Klik tombol <strong>Update Progres</strong> untuk menambahkan pembaruan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Progress -->
<div class="modal fade" id="addProgressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-navy">
                    <i class="fa-solid fa-plus-circle me-2 text-primary"></i> Update Progres Kegiatan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('activities.progress.store', $activity->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">

                    <!-- Step Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Pilih Tahapan Progres Baru <span class="text-danger">*</span></label>
                        <select name="step" class="form-select rounded-3" required>
                            @foreach(\App\Models\Activity::STEPS as $stepCode => $stepName)
                                <option value="{{ $stepCode }}" {{ $activity->current_step == $stepCode ? 'selected' : '' }}>
                                    Step {{ $stepCode }}: {{ $stepName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Work Description -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Jelaskan hasil pengerjaan atau hasil tahapan..." required></textarea>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Catatan / Kendala (Opsional)</label>
                        <textarea name="notes" class="form-control rounded-3" rows="2" placeholder="Catatan tambahan, hambatan, atau nomor dokumen..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fa-solid fa-paper-plane me-1"></i> Simpan Update Progres
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
