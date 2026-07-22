@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark mb-1">Profil Pengguna</h3>
    <p class="text-muted small mb-0">Kelola informasi data diri dan kata sandi akun Anda</p>
</div>

<div class="row g-4">
    <!-- User Card info -->
    <div class="col-lg-4">
        <div class="card-custom p-4 text-center">
            <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
            <span class="badge bg-primary rounded-pill px-3 py-2 text-uppercase mb-3">{{ $user->role }}</span>

            <div class="text-muted small mb-1">
                <i class="fa-solid fa-user-tag me-1"></i> Username: <strong>{{ $user->username }}</strong>
            </div>
            <div class="text-muted small mb-1">
                <i class="fa-solid fa-envelope me-1"></i> {{ $user->email }}
            </div>
            @if($user->position)
                <div class="text-muted small mb-1">
                    <i class="fa-solid fa-briefcase me-1"></i> {{ $user->position }}
                </div>
            @endif
            @if($user->phone)
                <div class="text-muted small">
                    <i class="fa-brands fa-whatsapp text-success me-1"></i> {{ $user->phone }}
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-lg-8">
        <div class="card-custom p-4">
            <h6 class="fw-bold text-navy mb-4">
                <i class="fa-solid fa-user-pen me-2 text-primary"></i> Perbarui Data Profil & Password
            </h6>

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-4 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Jabatan / Posisi</label>
                        <input type="text" name="position" class="form-control rounded-3" value="{{ old('position', $user->position) }}" placeholder="Contoh: Pranata Komputer Ahli Pertama">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Nomor WhatsApp (WhatsApp)</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                    </div>
                </div>

                <hr class="text-muted my-4">
                <h6 class="fw-bold text-secondary mb-3">Ubah Password (Kosongkan jika tidak ingin mengubah)</h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-secondary">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control rounded-3">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-secondary">Password Baru</label>
                        <input type="password" name="password" class="form-control rounded-3">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-secondary">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
