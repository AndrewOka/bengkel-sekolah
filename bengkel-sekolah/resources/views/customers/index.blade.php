@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Data Pelanggan (Siswa / Guru)</h3>
    <a href="{{ route('customers.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah Pelanggan</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Kode Pelanggan</th>
                    <th>Nama Lengkap</th>
                    <th>No. Telepon</th>
                    <th>Tipe Pelanggan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                <tr>
                    <td><strong>{{ $c->customer_code }}</strong></td>
                    <td>{{ $c->full_name }}</td>
                    <td>{{ $c->phone }}</td>
                    <td><span class="badge bg-info">{{ $c->customer_type }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">Data pelanggan kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white pt-3">{{ $customers->links() }}</div>
</div>
@endsection