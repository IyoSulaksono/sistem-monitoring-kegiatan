@extends('layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Dashboard Monitoring Triwulan</h3>
        <p class="text-muted small mb-0">Pengawasan visual kegiatan, indikator tenggat waktu, dan kalender 3 bulan</p>
    </div>

    <!-- Triwulan Selector -->
    <div class="mt-3 mt-md-0 d-flex align-items-center bg-white p-2 rounded-4 shadow-sm">
        <label class="small text-muted fw-bold me-2 ps-2">
            <i class="fa-solid fa-calendar-days text-primary me-1"></i> Pilih Triwulan:
        </label>
        <form method="GET" action="{{ route('monitoring.index') }}" id="monitoringTriwulanForm">
            <select name="triwulan" class="form-select form-select-sm border-0 bg-light rounded-pill fw-bold text-dark" onchange="document.getElementById('monitoringTriwulanForm').submit()">
                <option value="1" {{ $selectedTriwulan == 1 ? 'selected' : '' }}>Triwulan I (Jan - Mar)</option>
                <option value="2" {{ $selectedTriwulan == 2 ? 'selected' : '' }}>Triwulan II (Apr - Jun)</option>
                <option value="3" {{ $selectedTriwulan == 3 ? 'selected' : '' }}>Triwulan III (Jul - Sep)</option>
                <option value="4" {{ $selectedTriwulan == 4 ? 'selected' : '' }}>Triwulan IV (Okt - Des)</option>
            </select>
        </form>
    </div>
</div>

<!-- SECTION 1: 3-Month Triwulan Calendar Grid -->
<div class="card-custom p-4 mb-4">
    <h5 class="fw-bold text-navy mb-3">
        <i class="fa-solid fa-calendar-check me-2 text-primary"></i> Kalender Kegiatan Triwulan {{ $selectedTriwulan }} Tahun {{ $year }}
    </h5>
    <p class="text-muted small mb-4">Peta waktu pelaksanaan dan tenggat kegiatan dalam periode 3 bulan berjalan</p>

    <div class="row g-4">
        @foreach($calendarMonths as $cMonth)
            <div class="col-lg-4">
                <div class="border rounded-4 p-3 bg-white h-100 shadow-sm">
                    <h6 class="fw-bold text-center text-primary mb-3 pb-2 border-bottom">
                        {{ $cMonth['name'] }}
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle small mb-0" style="font-size: 0.75rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-danger" style="width: 14%;">Min</th>
                                    <th style="width: 14%;">Sen</th>
                                    <th style="width: 14%;">Sel</th>
                                    <th style="width: 14%;">Rab</th>
                                    <th style="width: 14%;">Kam</th>
                                    <th style="width: 14%;">Jum</th>
                                    <th class="text-primary" style="width: 14%;">Sab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $dayCount = 1;
                                    $firstDay = $cMonth['first_day_of_week'];
                                    $totalDays = $cMonth['days_in_month'];
                                @endphp
                                
                                <tr>
                                    @for($i = 0; $i < $firstDay; $i++)
                                        <td class="bg-light text-muted opacity-50"></td>
                                    @endfor

                                    @for($i = $firstDay; $i < 7; $i++)
                                        @php
                                            $hasActivities = count($cMonth['days_map'][$dayCount]) > 0;
                                        @endphp
                                        <td class="{{ $hasActivities ? 'bg-warning bg-opacity-25 fw-bold text-dark border-warning' : '' }}">
                                            <div>{{ $dayCount }}</div>
                                            @if($hasActivities)
                                                <span class="badge bg-danger rounded-circle p-1" style="font-size: 0.5rem;" title="{{ count($cMonth['days_map'][$dayCount]) }} Kegiatan">
                                                    {{ count($cMonth['days_map'][$dayCount]) }}
                                                </span>
                                            @endif
                                        </td>
                                        @php $dayCount++; @endphp
                                    @endfor
                                </tr>

                                @while($dayCount <= $totalDays)
                                    <tr>
                                        @for($i = 0; $i < 7 && $dayCount <= $totalDays; $i++)
                                            @php
                                                $hasActivities = count($cMonth['days_map'][$dayCount]) > 0;
                                            @endphp
                                            <td class="{{ $hasActivities ? 'bg-warning bg-opacity-25 fw-bold text-dark border-warning' : '' }}">
                                                <div>{{ $dayCount }}</div>
                                                @if($hasActivities)
                                                    <span class="badge bg-danger rounded-circle p-1" style="font-size: 0.5rem;" title="{{ count($cMonth['days_map'][$dayCount]) }} Kegiatan">
                                                        {{ count($cMonth['days_map'][$dayCount]) }}
                                                    </span>
                                                @endif
                                            </td>
                                            @php $dayCount++; @endphp
                                        @endfor

                                        {{-- Fill remaining cells in last week --}}
                                        @if($dayCount > $totalDays && $i < 7)
                                            @for($j = $i; $j < 7; $j++)
                                                <td class="bg-light text-muted opacity-50"></td>
                                            @endfor
                                        @endif
                                    </tr>
                                @endwhile
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- SECTION 2: Monitoring Activity Cards with Status Highlights -->
<div class="mb-3 d-flex align-items-center justify-content-between">
    <h5 class="fw-bold text-navy mb-0">
        <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Pengawasan Status Kegiatan
    </h5>
    <div class="small text-muted">
        Total {{ $activities->count() }} kegiatan terdaftar
    </div>
</div>

<div class="row g-4">
    @forelse($activities as $act)
        @php
            $cardClass = 'bg-status-proses';
            $badgeText = 'Dalam Proses';
            $badgeColor = 'bg-primary';

            if ($act->status == 'Terlambat') {
                $cardClass = 'bg-status-terlambat';
                $badgeText = 'TERLAMBAT';
                $badgeColor = 'bg-danger';
            } elseif ($act->is_near_deadline) {
                $cardClass = 'bg-status-mendekati';
                $badgeText = 'MENDEKATI TENGGAT (≤14 Hari)';
                $badgeColor = 'bg-warning text-dark';
            } elseif ($act->status == 'Selesai') {
                $cardClass = 'bg-status-selesai';
                $badgeText = 'SELESAI';
                $badgeColor = 'bg-success';
            }
        @endphp

        <div class="col-lg-6">
            <div class="card-custom p-4 h-100 border-top border-4 {{ $act->status == 'Terlambat' ? 'border-danger' : ($act->is_near_deadline ? 'border-warning' : ($act->status == 'Selesai' ? 'border-success' : 'border-primary')) }}">
                
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <span class="badge {{ $badgeColor }} px-3 py-2 rounded-pill fw-bold">
                        {{ $badgeText }}
                    </span>

                    <span class="badge bg-light text-dark border">
                        Triwulan {{ $act->triwulan }}
                    </span>
                </div>

                <h5 class="fw-bold text-dark mb-2 mt-2">
                    <a href="{{ route('activities.show', $act->id) }}" class="text-dark text-decoration-none">
                        {{ $act->title }}
                    </a>
                </h5>

                <p class="text-muted small mb-3">{{ Str::limit($act->description, 100) }}</p>

                <!-- Stepper Progress Bar -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between small fw-semibold mb-1">
                        <span>Tahapan saat ini:</span>
                        <span class="text-primary">Step {{ $act->current_step }} - {{ $act->step_name }}</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($act->current_step / 5) * 100 }}%" aria-valuenow="{{ $act->current_step }}" aria-valuemin="0" aria-valuemax="5"></div>
                    </div>
                </div>

                <!-- Footer details & WhatsApp Reminder Button -->
                <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <div class="avatar-circle me-2" style="width: 26px; height: 26px; font-size: 0.7rem;">
                                {{ strtoupper(substr($act->assignedUser->name ?? 'S', 0, 1)) }}
                            </div>
                            <span class="small fw-semibold text-dark">{{ $act->assignedUser->name ?? '-' }}</span>
                        </div>
                        <div class="small text-muted" style="font-size: 0.75rem;">
                            <i class="fa-regular fa-clock me-1"></i> Deadline: <strong>{{ $act->deadline->format('d M Y') }}</strong>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <!-- Direct WhatsApp Reminder Link -->
                        <a href="{{ $act->wa_link }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" title="Kirim Notifikasi Pengingat WhatsApp ke Pelaksana">
                            <i class="fa-brands fa-whatsapp me-1"></i> Kirim WA
                        </a>

                        <a href="{{ route('activities.show', $act->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fa-solid fa-eye me-1"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">
            Belum ada kegiatan untuk triwulan ini.
        </div>
    @endforelse
</div>
@endsection
