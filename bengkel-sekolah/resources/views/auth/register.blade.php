@extends('layouts.auth')

@section('content')
<div class="card border-0 shadow-sm p-4" style="width: 100%; max-width: 450px;">
    <h3 class="fw-bold text-center mb-1">Daftar Akun Baru</h3>
    <p class="text-muted text-center mb-4 small">Lengkapi data untuk membuat akun</p>

    @if ($errors->any())
        <div class="alert alert-danger py-2 small">
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
            <label class="form-label font-semibold">Nama Lengkap</label>
            <input type="text" name="full_name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('full_name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label font-semibold">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="{{ old('username') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label font-semibold">Role / Jabatan</label>
            <select name="role_id" class="form-select" required>
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

        <div class="mb-3">
            <label class="form-label font-semibold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label class="form-label font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Daftar Sekarang</button>

        <div class="text-center mt-3 small">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login di sini</a>
        </div>
    </form>
</div>
@endsection