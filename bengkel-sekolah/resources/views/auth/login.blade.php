@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="card border-0 shadow-lg rounded-4 p-4" style="width: 100%; max-width: 420px;">
    <div class="text-center mb-4">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 55px; height: 55px;">
            <i class="bi bi-wrench-adjustable-circle fs-2"></i>
        </div>
        <h4 class="fw-bold text-dark mb-1">Login Bengkel</h4>
        <p class="text-muted small mb-0">Masuk untuk mengelola sistem booking</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success py-2 small mb-3 border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger py-2 small mb-3 border-0 shadow-sm">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                <input type="text" name="username" class="form-control bg-light border-start-0" placeholder="Masukkan username" value="{{ old('username') }}" autocomplete="new-username" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold text-secondary small">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                <input type="password" id="login_password" name="password" class="form-control bg-light border-start-0 border-end-0" placeholder="Masukkan password" autocomplete="new-password" required>
                <button class="btn btn-light bg-light border border-start-0 text-muted" type="button" id="toggleLoginPassword">
                    <i class="bi bi-eye-slash" id="iconLoginPassword"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm">Masuk Sekarang</button>

        <div class="text-center mt-4 small text-muted">
            Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Daftar Akun Baru</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('toggleLoginPassword').addEventListener('click', function () {
        const pass = document.getElementById('login_password');
        const icon = document.getElementById('iconLoginPassword');
        if (pass.type === 'password') {
            pass.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            pass.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });
</script>
@endsection