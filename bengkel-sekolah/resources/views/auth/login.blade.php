@extends('layouts.auth')

@section('content')
<div class="card border-0 shadow-sm p-4" style="width: 100%; max-width: 400px;">
    <h3 class="fw-bold text-center mb-1">Login Bengkel</h3>
    <p class="text-muted text-center mb-4 small">Masuk untuk mengelola sistem booking</p>
    @if (session('success'))
    <div class="alert alert-success py-2 small mb-3">
        {{ session('success') }}
    </div>
     @endif

    <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="" autocomplete="new-username" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" value="" autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Masuk</button>

        <div class="text-center mt-3 small">
            Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar Akun Baru</a>
        </div>
    </form>
</div>
@endsection