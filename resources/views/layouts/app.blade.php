<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Monitoring Kegiatan') - Diskominfo Kota Medan</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --diskominfo-navy: #0d2847;
            --diskominfo-blue: #16425b;
            --diskominfo-accent: #2a9d8f;
            --diskominfo-gold: #f4a261;
            --diskominfo-bg: #f4f6f9;
            --diskominfo-card-bg: #ffffff;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--diskominfo-bg);
            color: #2b2d42;
            overflow-x: hidden;
        }

        /* Top Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, var(--diskominfo-navy) 0%, var(--diskominfo-blue) 100%);
            height: 70px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 1030;
        }

        .navbar-brand-text {
            font-weight: 700;
            font-size: 1.15rem;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .navbar-brand-subtext {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 400;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            position: fixed;
            top: 70px;
            bottom: 0;
            left: 0;
            padding-top: 1.25rem;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.04);
            z-index: 1020;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 700;
            color: #8d99ae;
            padding: 0.75rem 1.5rem 0.25rem;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #4a5568;
            font-weight: 500;
            font-size: 0.92rem;
            border-radius: 0 30px 30px 0;
            margin-right: 1rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .nav-link-custom i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 10px;
            color: #718096;
            transition: all 0.2s ease;
        }

        .nav-link-custom:hover {
            color: var(--diskominfo-navy);
            background-color: #edf2f7;
        }

        .nav-link-custom:hover i {
            color: var(--diskominfo-blue);
        }

        .nav-link-custom.active {
            color: #ffffff;
            background: linear-gradient(135deg, var(--diskominfo-navy) 0%, var(--diskominfo-blue) 100%);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(13, 40, 71, 0.25);
        }

        .nav-link-custom.active i {
            color: #ffffff;
        }

        /* Main Content wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding-top: 90px;
            padding-bottom: 40px;
            padding-left: 2rem;
            padding-right: 2rem;
            min-height: 100vh;
        }

        /* Modern Card Styling */
        .card-custom {
            border: none;
            border-radius: 16px;
            background: var(--diskominfo-card-bg);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 1.5rem;
        }

        .card-custom:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        }

        .card-header-custom {
            background-color: transparent;
            border-bottom: 1px solid #edf2f7;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title-custom {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--diskominfo-navy);
            margin: 0;
        }

        /* Status Badge Styling */
        .badge-step {
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.4em 0.8em;
            border-radius: 20px;
        }

        .bg-step-0 { background-color: #e2e8f0; color: #4a5568; }
        .bg-step-1 { background-color: #ebf8ff; color: #2b6cb0; }
        .bg-step-2 { background-color: #e6fffa; color: #234e52; }
        .bg-step-3 { background-color: #feebc8; color: #7b341e; }
        .bg-step-4 { background-color: #e9d8fd; color: #44337a; }
        .bg-step-5 { background-color: #c6f6d5; color: #22543d; }

        /* Color highlight statuses */
        .bg-status-terlambat { background-color: #fed7d7; color: #9b2c2c; border: 1px solid #feb2b2; }
        .bg-status-mendekati { background-color: #feefc3; color: #744210; border: 1px solid #fbd38d; }
        .bg-status-selesai { background-color: #c6f6d5; color: #22543d; border: 1px solid #9ae6b4; }
        .bg-status-proses { background-color: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }

        /* Avatar circle */
        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2a9d8f, #264653);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Footer */
        .footer-text {
            font-size: 0.82rem;
            color: #a0aec0;
            text-align: center;
            padding-top: 2rem;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container-fluid px-4">
            <button class="btn text-white d-lg-none me-3" type="button" onclick="document.querySelector('.sidebar').classList.toggle('show')">
                <i class="fa-solid fa-bars fs-5"></i>
            </button>

            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <div class="bg-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; shadow: 0 2px 8px rgba(0,0,0,0.15);">
                    <i class="fa-solid fa-building-columns text-dark fs-5"></i>
                </div>
                <div>
                    <div class="navbar-brand-text">Sistem Monitoring Kegiatan</div>
                    <div class="navbar-brand-subtext">Dinas Komunikasi dan Informatika Kota Medan</div>
                </div>
            </a>

            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown me-2">
                    <button class="btn text-white dropdown-toggle d-flex align-items-center bg-white bg-opacity-10 rounded-pill px-3 py-1 border-0" type="button" data-bs-toggle="dropdown">
                        <div class="avatar-circle me-2">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="text-start d-none d-sm-block me-2">
                            <div class="fw-bold small lh-1 text-white">{{ Auth::user()->name }}</div>
                            <div class="text-white-50 small" style="font-size: 0.7rem;">
                                {{ strtoupper(Auth::user()->role) }} 
                                @if(Auth::user()->position) - {{ Auth::user()->position }} @endif
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.show') }}">
                                <i class="fa-solid fa-user-gear me-2 text-primary"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 text-muted" href="{{ route('guide.index') }}">
                                <i class="fa-solid fa-circle-info me-2 text-info"></i> Petunjuk Penggunaan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-heading">Menu Utama</div>

        <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('activities.index') }}" class="nav-link-custom {{ request()->routeIs('activities.*') ? 'active' : '' }}">
            <i class="fa-solid fa-list-check"></i>
            <span>Kelola Kegiatan</span>
        </a>

        <a href="{{ route('monitoring.index') }}" class="nav-link-custom {{ request()->routeIs('monitoring.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Monitoring Triwulan</span>
        </a>

        <a href="{{ route('reports.index') }}" class="nav-link-custom {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-invoice"></i>
            <span>Laporan & PDF</span>
        </a>

        <div class="sidebar-heading mt-4">Informasi & Bantuan</div>

        <a href="{{ route('guide.index') }}" class="nav-link-custom {{ request()->routeIs('guide.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book-open"></i>
            <span>Petunjuk Penggunaan</span>
        </a>

        <a href="{{ route('profile.show') }}" class="nav-link-custom {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fa-solid fa-id-badge"></i>
            <span>Profil Pengguna</span>
        </a>

        <div class="px-4 mt-5">
            <div class="p-3 bg-light rounded-4 border border-1 border-light-subtle text-center">
                <i class="fa-solid fa-shield-halved text-primary fs-4 mb-2"></i>
                <div class="fw-bold small text-navy">SEMOK v1.0</div>
                <div class="text-muted" style="font-size: 0.72rem;">Proyek Aktualisasi LATSAR CPNS</div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        
        <!-- Flash Alert Notifications -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                    <div>
                        <strong class="d-block">Berhasil!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                    <div>
                        <strong class="d-block">Terjadi Kesalahan!</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

        <footer class="footer-text">
            &copy; 2026 Pemerintah Kota Medan - Dinas Komunikasi dan Informatika. All Rights Reserved.
        </footer>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
