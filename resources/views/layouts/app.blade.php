<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-brand {
            font-weight: 700;
            color: #000 !important;
        }

        .nav-link {
            color: #000 !important;
            font-weight: 500;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
        }

        .nav-link:hover,
        .nav-link.fw-bold {
            color: #FFBD38 !important;
        }

        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
        }

        /* Samakan style Logout button dengan nav-link */
        .navbar-nav .nav-link.btn-link {
            color: #000 !important;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            background: none;
            border: none;
            text-align: left;
        }

        .navbar-nav .nav-link.btn-link:hover {
            color: #FFBD38 !important;
            text-decoration: none;
        }

        .navbar-nav form {
            margin: 0;
            padding: 0;
        }

        .navbar-nav i {
            font-size: 1rem;
            line-height: 1;
        }

        .page-title {
            font-weight: 700;
            font-size: 1.75rem;
            color: #343a40;
            margin-bottom: 1.5rem;
            border-left: 5px solid #FFBD38;
            padding-left: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
        }

        .btn-warning {
            background-color: #FFBD38;
            border: none;
            color: white;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo" height="26">
            <span class="fw-semibold fs-5 mb-0" style="letter-spacing: 0.5px;">Buku Tamu</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-2">
                @auth
                    {{-- Menu untuk resepsionis_ground --}}
                    @if(auth()->user()->role === 'resepsionis_ground')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'fw-bold' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('form') ? 'fw-bold' : '' }}" 
                               href="{{ route('form') }}">
                                <i class="bi bi-pencil-square"></i> Form Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('history') ? 'fw-bold' : '' }}" 
                               href="{{ route('history') }}">
                                <i class="bi bi-clock-history"></i> Riwayat
                            </a>
                        </li>
                    @endif

                    {{-- Menu untuk resepsionis_lantai5 --}}
                    @if(auth()->user()->role === 'resepsionis_lantai5')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('lantai5.tamu') ? 'fw-bold' : '' }}" 
                               href="{{ route('lantai5.tamu') }}">
                                <i class="bi bi-people"></i> Tamu
                            </a>
                        </li>
                    @endif

                    {{-- Logout untuk semua user --}}
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

    <!-- End Navbar -->

    @yield('content')

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
