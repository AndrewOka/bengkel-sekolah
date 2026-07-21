@extends('layouts.auth')

@section('content')
<div class="card shadow-lg border-0" style="width: 400px; border-radius: 12px;">
    <div class="card-body p-4">
        <h4 class="text-center fw-bold mb-1">Login Bengkel</h4>
        <p class="text-muted text-center small mb-4">Masuk untuk mengelola sistem booking</p>

        @if($errors->any())
            <div class="alert alert-danger py-2 small">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">Masuk</button>

           <div class="text-center small mt-3">
    Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar Akun Baru</a>
</div>
        </form>
    </div>
</div>
@endsection