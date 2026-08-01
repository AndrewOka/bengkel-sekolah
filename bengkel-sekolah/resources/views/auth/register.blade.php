@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="card border-0 shadow-lg rounded-4 p-4" style="width: 100%; max-width: 450px;">
    <div class="text-center mb-4">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 55px; height: 55px;">
            <i class="bi bi-person-plus-fill fs-2"></i>
        </div>
        <h4 class="fw-bold text-dark mb-1">Daftar Akun Baru</h4>
        <p class="text-muted small mb-0">Lengkapi data untuk membuat akun</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 small mb-3 border-0 shadow-sm">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" autocomplete="off">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Nama Lengkap</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-heading text-muted"></i></span>
                <input type="text" name="full_name" class="form-control bg-light border-start-0" placeholder="Masukkan nama lengkap" value="{{ old('full_name') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                <input type="text" name="username" class="form-control bg-light border-start-0" placeholder="Masukkan username" value="{{ old('username') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Role / Jabatan</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-check text-muted"></i></span>
                <select name="role_id" class="form-select bg-light border-start-0" required>
                    <option value="" disabled selected>-- Pilih Role --</option>
                    @if(isset($roles) && $roles->count() > 0)
                        @foreach($roles as $role)
                            <option value="{{ $role->role_id ?? $role->id }}" {{ old('role_id') == ($role->role_id ?? $role->id) ? 'selected' : '' }}>
                                {{ $role->role_name ?? $role->name }}
                            </option>
                        @endforeach
                    @else
                        <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>Manager</option>
                        <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>Admin / Staff</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                <input type="password" id="reg_password" name="password" class="form-control bg-light border-start-0 border-end-0" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                <button class="btn btn-light bg-light border border-start-0 text-muted" type="button" id="toggleRegPassword">
                    <i class="bi bi-eye-slash" id="iconRegPassword"></i>
                </button>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold text-secondary small">Konfirmasi Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock text-muted"></i></span>
                <input type="password" id="confirm_password" name="password_confirmation" class="form-control bg-light border-start-0 border-end-0" placeholder="Ulangi password" required autocomplete="new-password">
                <button class="btn btn-light bg-light border border-start-0 text-muted" type="button" id="toggleConfirmPassword">
                    <i class="bi bi-eye-slash" id="iconConfirmPassword"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm">Daftar Sekarang</button>

        <div class="text-center mt-4 small text-muted">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Login di sini</a>
        </div>
    </form>
</div>

<script>
    // Toggle Password
    document.getElementById('toggleRegPassword').addEventListener('click', function () {
        const pass = document.getElementById('reg_password');
        const icon = document.getElementById('iconRegPassword');
        if (pass.type === 'password') {
            pass.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            pass.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });

    // Toggle Confirm Password
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const pass = document.getElementById('confirm_password');
        const icon = document.getElementById('iconConfirmPassword');
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