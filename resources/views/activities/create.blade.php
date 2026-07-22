@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="mb-4">
    <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mb-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h3 class="fw-bold text-dark mb-1">Tambah Kegiatan Baru</h3>
    <p class="text-muted small mb-0">Isi formulir berikut untuk mendaftarkan kegiatan operasional Diskominfo Kota Medan</p>
</div>

<div class="card-custom max-width-800">
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-4 mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('activities.store') }}" method="POST">
            @csrf

            <!-- Activity Title -->
            <div class="mb-3">
                <label class="form-label fw-bold text-secondary">Nama Kegiatan <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control rounded-3" placeholder="Contoh: Pengembangan Portal Satu Data Kota Medan" value="{{ old('title') }}" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label fw-bold text-secondary">Deskripsi Kegiatan</label>
                <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Tuliskan rincian dan tujuan kegiatan...">{{ old('description') }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <!-- Assigned Staff -->
                <div class="col-md-6">
                    <label class="form-label fw-bold text-secondary">Pelaksana / Penanggung Jawab <span class="text-danger">*</span></label>
                    <select name="assigned_to" class="form-select rounded-3" required>
                        <option value="">-- Pilih Pegawai Pelaksana --</option>
                        @foreach($staffUsers as $staff)
                            <option value="{{ $staff->id }}" {{ old('assigned_to') == $staff->id ? 'selected' : '' }}>
                                {{ $staff->name }} ({{ strtoupper($staff->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Transaction Method -->
                <div class="col-md-6">
                    <label class="form-label fw-bold text-secondary">Metode Transaksi <span class="text-danger">*</span></label>
                    <select name="transaction_method" class="form-select rounded-3" required>
                        <option value="1" {{ old('transaction_method', 1) == 1 ? 'selected' : '' }}>1 - Pengadaan Langsung</option>
                        <option value="2" {{ old('transaction_method') == 2 ? 'selected' : '' }}>2 - e-Purchasing</option>
                        <option value="3" {{ old('transaction_method') == 3 ? 'selected' : '' }}>3 - Lelang</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <!-- Start Date -->
                <div class="col-md-6">
                    <label class="form-label fw-bold text-secondary">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control rounded-3" value="{{ old('start_date', date('Y-m-d')) }}" required>
                </div>

                <!-- Deadline -->
                <div class="col-md-6">
                    <label class="form-label fw-bold text-secondary">Tenggat Waktu (Deadline) <span class="text-danger">*</span></label>
                    <input type="date" name="deadline" class="form-control rounded-3" value="{{ old('deadline') }}" required>
                </div>
            </div>

            <!-- Current Step -->
            <div class="mb-4">
                <label class="form-label fw-bold text-secondary">Tahapan Awal Progres <span class="text-danger">*</span></label>
                <select name="current_step" class="form-select rounded-3" required>
                    <option value="0" {{ old('current_step', 0) == 0 ? 'selected' : '' }}>Step 0: Belum dikerjakan</option>
                    <option value="1" {{ old('current_step') == 1 ? 'selected' : '' }}>Step 1: Persiapan</option>
                    <option value="2" {{ old('current_step') == 2 ? 'selected' : '' }}>Step 2: Pengajuan</option>
                    <option value="3" {{ old('current_step') == 3 ? 'selected' : '' }}>Step 3: Pengerjaan</option>
                    <option value="4" {{ old('current_step') == 4 ? 'selected' : '' }}>Step 4: Pembayaran</option>
                    <option value="5" {{ old('current_step') == 5 ? 'selected' : '' }}>Step 5: Selesai</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('activities.index') }}" class="btn btn-light border rounded-pill px-4">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-save me-1"></i> Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
