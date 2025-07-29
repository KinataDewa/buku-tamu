<x-guest-layout>
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="mb-3" style="height: 60px;">
        <h4 class="fw-semibold">Buku Tamu</h4>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autofocus
                   placeholder="Masukkan email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password + Toggle --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">Password</label>
            <div class="input-group">
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required placeholder="Masukkan password">
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-warning text-decoration-none fw-semibold" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- Button --}}
        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-warning fw-semibold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Log in
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center">
                <small>Belum punya akun?
                    <a href="{{ route('register') }}" class="text-warning fw-bold">Register</a>
                </small>
            </div>
        @endif
    </form>

    {{-- Toggle Password Script --}}
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>

   <style>
        .form-label {
            font-size: 0.95rem;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.6rem 0.75rem;
        }
        .btn-outline-secondary {
            border-radius: 0.5rem;
        }
        .btn-warning {
            background-color: #FFBD38;
            border: none;
            font-weight: 600;
        }
        .btn-warning:hover {
            background-color: #e0a528;
        }
    </style>
</x-guest-layout>
