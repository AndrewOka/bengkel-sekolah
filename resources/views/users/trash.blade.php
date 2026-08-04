@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-danger"><i class="fa-solid fa-trash-can me-2"></i> Tempat Sampah User</h3>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role / Jabatan</th>
                            <th>Tanggal Dihapus</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="px-3">{{ $users->firstItem() + $index }}</td>
                                <td class="fw-semibold">{{ $user->full_name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $user->role->role_name ?? 'Tidak Ada Role' }}
                                    </span>
                                </td>
                                <td>{{ $user->deleted_at ? $user->deleted_at->format('d M Y H:i') : '-' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('users.restore', $user->user_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm me-1">
                                            <i class="fa-solid fa-rotate-left me-1"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('users.forceDelete', $user->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini secara PERMANEN?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-ban me-1"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Tidak ada data user di tempat sampah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection