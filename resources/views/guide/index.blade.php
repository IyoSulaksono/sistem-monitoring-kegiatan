@extends('layouts.app')

@section('title', 'Petunjuk Penggunaan')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark mb-1">Petunjuk Penggunaan & Dokumentasi Sistem</h3>
    <p class="text-muted small mb-0">Panduan operasional Sistem Monitoring Kegiatan Diskominfo Kota Medan untuk seminar aktualisasi</p>
</div>

<!-- Overview Card -->
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-primary text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
            <i class="fa-solid fa-circle-info fs-4"></i>
        </div>
        <div>
            <h5 class="fw-bold text-navy mb-1">Latar Belakang & Tujuan Sistem</h5>
            <p class="text-muted small mb-0">Transformasi digital pengendalian dan pengawasan kegiatan operasional berbasis tahapan pekerjaan di Diskominfo Kota Medan.</p>
        </div>
    </div>
</div>

<!-- Step-by-Step Guide Sections -->
<div class="row g-4 mb-4">
    <!-- 1. Hak Akses & Peran -->
    <div class="col-md-6">
        <div class="card-custom p-4 h-100 border-start border-4 border-primary">
            <h6 class="fw-bold text-dark mb-3">
                <i class="fa-solid fa-users-gear me-2 text-primary"></i> 1. Hak Akses & Akun Pengguna
            </h6>
            <ul class="small text-muted ps-3 mb-0">
                <li class="mb-2">
                    <strong>Admin (`admin`)</strong>: Memiliki akses penuh (CRUD) terhadap seluruh kegiatan, user management, dan laporan.
                </li>
                <li class="mb-2">
                    <strong>PPTK (`pptk`)</strong>: Memiliki wewenang dan fungsionalitas yang sama dengan Admin untuk mengawasi seluruh kegiatan OPD.
                </li>
                <li class="mb-2">
                    <strong>Staf Pelaksana (`staf`)</strong>: Mengelola dan memperbarui log progres kegiatan yang ditugaskan kepada dirinya.
                </li>
            </ul>
        </div>
    </div>

    <!-- 2. Alur 6 Tahapan Kegiatan -->
    <div class="col-md-6">
        <div class="card-custom p-4 h-100 border-start border-4 border-success">
            <h6 class="fw-bold text-dark mb-3">
                <i class="fa-solid fa-list-ol me-2 text-success"></i> 2. Alur 6 Tahapan Progres (Step 0 - 5)
            </h6>
            <div class="small text-muted">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-secondary me-2">Step 0</span> Belum dikerjakan (Kegiatan baru dibuat)
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary me-2">Step 1</span> Persiapan (KAK, HPS, atau berkas awal)
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-info text-dark me-2">Step 2</span> Pengajuan (Pengadaan Langsung / e-Purchasing / Lelang)
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-warning text-dark me-2">Step 3</span> Pengerjaan (Pelaksanaan pekerjaan fisik/sistem)
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-purple text-white bg-dark me-2">Step 4</span> Pembayaran (Pemeriksaan berkas & pencairan)
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success me-2">Step 5</span> Selesai (Tuntas 100%)
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Monitoring & Pengingat WhatsApp -->
    <div class="col-md-6">
        <div class="card-custom p-4 h-100 border-start border-4 border-warning">
            <h6 class="fw-bold text-dark mb-3">
                <i class="fa-solid fa-calendar-days me-2 text-warning"></i> 3. Monitoring & Notifikasi WhatsApp
            </h6>
            <ul class="small text-muted ps-3 mb-0">
                <li class="mb-2">
                    <strong>Filter Triwulan</strong>: Kegiatan dikelompokkan secara otomatis dalam Triwulan I s/d IV sesuai bulan deadline.
                </li>
                <li class="mb-2">
                    <strong>Kalender 3 Bulan</strong>: Menampilkan visualisasi grid kalender 3 bulan untuk setiap triwulan.
                </li>
                <li class="mb-2">
                    <strong>Highlight Warna Status</strong>: Merah (Terlambat), Kuning (Mendekati Tenggat ≤14 hari), Hijau (Selesai).
                </li>
                <li class="mb-2">
                    <strong>Notifikasi WhatsApp</strong>: Fitur "Kirim WA" menghasilkan link pesan otomatis berisi pengingat progres.
                </li>
            </ul>
        </div>
    </div>

    <!-- 4. Laporan & Ekspor PDF -->
    <div class="col-md-6">
        <div class="card-custom p-4 h-100 border-start border-4 border-danger">
            <h6 class="fw-bold text-dark mb-3">
                <i class="fa-solid fa-file-pdf me-2 text-danger"></i> 4. Laporan Rekapitulasi & PDF
            </h6>
            <ul class="small text-muted ps-3 mb-0">
                <li class="mb-2">
                    <strong>Filter Komprehensif</strong>: Menyaring data berdasarkan Triwulan, Status, Metode Transaksi, dan Pelaksana.
                </li>
                <li class="mb-2">
                    <strong>Cetak PDF Resmi</strong>: Menghasilkan dokumen PDF berformat Kop Surat Pemerintah Kota Medan lengkap dengan lembar pengesahan TTD Kepala Dinas.
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
