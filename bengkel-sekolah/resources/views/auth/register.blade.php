@extends('layouts.auth')

@section('content')
<div class="card shadow-lg border-0 my-4" style="width: 420px; border-radius: 12px;">
    <div class="card-body p-4">
        <h4 class="text-center fw-bold mb-1">Daftar Akun Bengkel</h4>
        <p class="text-muted text-center small mb-4">Buat akun baru untuk mengelola sistem</p>

        @if($errors->any())
            <div class="alert alert-danger py-2 small">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label font-semibold">Nama Lengkap</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label font-semibold">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label class="form-label font-semibold">Pilih Role</label>
                <select name="role_id" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label font-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="mb-3">
                <label class="form-label font-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">Daftar Sekarang</button>

            <div class="text-center small">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login di sini</a>
            </div>
        </form>
    </div>
</div>
@endsection