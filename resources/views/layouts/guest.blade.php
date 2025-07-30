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

        /* Layout container */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: row;
        }

        /* Left panel */
        .left-panel {
            flex: 1.5;
            position: relative;
            background: url('{{ asset('images/bg7.jpg') }}') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45);
            border-top-right-radius: 2rem;
            border-bottom-right-radius: 2rem;
        }

        .welcome-text {
            position: relative;
            text-align: center;
            padding: 1rem 2rem;
            z-index: 2;
        }

        .welcome-text h2 {
            font-weight: 600;
            font-size: 2rem;
        }

        /* Right panel */
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
            background: #fff;
            padding: 2rem;
            border-radius: 1.25rem;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.5s ease;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 189, 56, 0.4);
            border-color: #FFBD38;
        }

        .btn-warning {
            background-color: #FFBD38;
            border: none;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        .btn-warning:hover {
            background-color: #e0a528;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px);}
            to { opacity: 1; transform: translateY(0);}
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }
            .right-panel {
                flex: 1;
                padding: 1.5rem;
            }
            .login-panel {
                box-shadow: none;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <!-- Left side -->
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
