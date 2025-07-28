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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('{{ asset('images/bg2.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-panel {
            width: 90%;
            max-width: 700px;
            padding: 3rem 2rem;
            border-radius: 1rem;
            backdrop-filter: blur(25px);
            background: rgba(0, 0, 0, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .login-panel h4 {
            font-weight: 600;
            color: #fff;
        }

        .form-control {
            border-radius: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(255, 189, 56, 0.4);
            color: #fff;
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

        @media (max-width: 768px) {
            .login-panel {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-panel">
        {{ $slot }}
    </div>
</body>
</html>
