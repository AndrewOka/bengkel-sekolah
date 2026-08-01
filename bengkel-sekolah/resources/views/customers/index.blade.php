@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Data Pelanggan (Siswa / Guru)</h3>
    <div>
        <a href="{{ route('customers.trash') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-trash me-1"></i> Sampah
        </a>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Pelanggan
        </a>
    </div>
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
                                {{-- PERBAIKAN: Panggil langsung kolom customer_code dari Database --}}
                                {{ $customer->customer_code ?? 'CUST-'.str_pad($customer->customer_id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>{{ $customer->full_name }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info text-white">{{ $customer->customer_type ?? 'Siswa' }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('customers.edit', $customer->customer_id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>

                                    <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
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