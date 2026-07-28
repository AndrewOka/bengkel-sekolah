@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Data Pelanggan (Siswa / Guru)</h3>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Tambah Pelanggan
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="border-bottom bg-white">
                    <tr>
                        <th class="py-3 ps-3 text-dark fw-bold">Kode Pelanggan</th>
                        <th class="py-3 text-dark fw-bold">Nama Lengkap</th>
                        <th class="py-3 text-dark fw-bold">No. Telepon</th>
                        <th class="py-3 text-dark fw-bold">Tipe Pelanggan</th>
                        <th class="py-3 text-center text-dark fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="fw-bold ps-3">
                                CUST-{{ str_pad($customer->customer_id ?? $customer->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>{{ $customer->full_name ?? $customer->name }}</td>
                            <td>{{ $customer->phone ?? $customer->phone_number ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info text-white">{{ $customer->type ?? 'Siswa' }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('customers.destroy', $customer->customer_id ?? $customer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection