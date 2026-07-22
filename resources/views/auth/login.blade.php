<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Monitoring Kegiatan Diskominfo Kota Medan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0d2847 0%, #16425b 50%, #2a9d8f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .login-banner {
            background: linear-gradient(135deg, #0d2847 0%, #16425b 100%);
            padding: 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-wrapper {
            padding: 45px;
        }

        .btn-login {
            background: linear-gradient(135deg, #0d2847 0%, #16425b 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #16425b 0%, #2a9d8f 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 40, 71, 0.3);
        }

        .form-control-custom {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .form-control-custom:focus {
            border-color: #2a9d8f;
            box-shadow: 0 0 0 4px rgba(42, 157, 143, 0.15);
        }

        .demo-badge {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .demo-badge:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="row g-0">
        <!-- Banner Side -->
        <div class="col-lg-5 login-banner d-none d-lg-flex">
            <div class="mb-4">
                <div class="bg-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center mb-3 shadow overflow-hidden" style="width: 60px; height: 60px;">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo SEMOK" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fa-solid fa-building-columns text-dark fs-2\'></i>';">
                </div>
                <h3 class="fw-bold">SEMOK</h3>
                <p class="text-white-50 small mb-0">Sistem Monitoring Kegiatan Diskominfo Kota Medan</p>
            </div>
            
            <div class="mt-auto">
                <div class="d-flex align-items-center mb-3">
                    <i class="fa-solid fa-circle-check text-warning me-2 fs-5"></i>
                    <span class="small">Pengendalian Progres Berbasis Tahapan</span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="fa-solid fa-chart-line text-warning me-2 fs-5"></i>
                    <span class="small">Monitoring Realtime & Kalender Triwulan</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-file-pdf text-warning me-2 fs-5"></i>
                    <span class="small">Pelaporan Akuntabel & Notifikasi WA</span>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="col-lg-7 login-form-wrapper">
            <div class="text-center text-lg-start mb-4">
                <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
                <p class="text-muted small">Silakan masuk dengan akun pengguna Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 small mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 small mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Username / Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="login" id="loginInput" class="form-control form-control-custom border-start-0" placeholder="Masukkan username atau email" value="{{ old('login') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="passwordInput" class="form-control form-control-custom border-start-0" placeholder="Masukkan password" required>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-muted" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100 shadow">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke Sistem
                </button>
            </form>

            <hr class="my-4 text-muted">

            <!-- Quick Demo Login Presets -->
            <div>
                <div class="small fw-bold text-muted mb-2 text-center text-lg-start">
                    <i class="fa-solid fa-bolt text-warning me-1"></i> Demo Login Cepat (Klik untuk mencoba):
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                    <span class="badge bg-primary demo-badge py-2 px-3 rounded-pill" onclick="quickLogin('admin', 'password')">
                        <i class="fa-solid fa-user-shield me-1"></i> Admin (admin)
                    </span>
                    <span class="badge bg-success demo-badge py-2 px-3 rounded-pill" onclick="quickLogin('pptk', 'password')">
                        <i class="fa-solid fa-user-tie me-1"></i> PPTK (pptk)
                    </span>
                    <span class="badge bg-info text-dark demo-badge py-2 px-3 rounded-pill" onclick="quickLogin('staf', 'password')">
                        <i class="fa-solid fa-user-gear me-1"></i> Staf (staf)
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function quickLogin(username, password) {
        document.getElementById('loginInput').value = username;
        document.getElementById('passwordInput').value = password;
        document.getElementById('loginForm').submit();
    }
</script>

</body>
</html>
