@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen User Bengkel</h3>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah User</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td><strong>{{ $u->username }}</strong></td>
                    <td>{{ $u->full_name }}</td>
                    <td><span class="badge bg-primary">{{ $u->role->role_name }}</span></td>
                    <td>
                        @if($u->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Non-Aktif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection