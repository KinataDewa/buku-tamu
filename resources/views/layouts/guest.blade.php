<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Buku Tamu</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f4f5f7;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: row;
        }

        /* LEFT PANEL MODERN CURVE */
        .left-panel {
            flex: 1.5;
            position: relative;
            background: url('{{ asset('images/bg8.jpg') }}') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            clip-path: path('M0,0 L90%,0 Q100%,50% 90%,100% L0,100% Z');
        }

        /* Overlay dengan gradient */
        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .welcome-text {
            position: relative;
            text-align: center;
            padding: 1rem 2rem;
            z-index: 2;
            animation: fadeInUp 0.8s ease;
        }

        .welcome-text h2 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: .5rem;
        }

        .welcome-text p {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* RIGHT PANEL */
        .right-panel {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-panel {
            width: 100%;
            max-width: 420px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 1.25rem;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.6s ease;
        }

        /* Form control */
        .form-control {
            border-radius: 0.5rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 189, 56, 0.4);
            border-color: #FFBD38;
        }

        /* Button */
        .btn-warning {
            background-color: #FFBD38;
            border: none;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a528;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,189,56,0.4);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px);}
            to { opacity: 1; transform: translateY(0);}
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { flex: 1; padding: 1.5rem; }
            .login-panel { box-shadow: none; padding: 1.5rem; background: #fff; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <!-- Left side with curve -->
        <div class="left-panel d-none d-md-flex">
            <div class="overlay"></div>
            <div class="welcome-text">
                <h2>Selamat Datang di Buku Tamu SUA</h2>
                <p>Catat kunjunganmu dengan mudah dan cepat.</p>
            </div>
        </div>

        <!-- Right side -->
        <div class="right-panel">
            <div class="login-panel">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
