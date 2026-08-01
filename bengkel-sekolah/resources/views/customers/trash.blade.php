@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Sampah Data Pelanggan</h3>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
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
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <form action="{{ route('customers.restore', $customer->customer_id ?? $customer->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                                            <i class="fas fa-rotate-left me-1"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('customers.forceDelete', $customer->customer_id ?? $customer->id) }}" method="POST" onsubmit="return confirm('Hapus permanen pelanggan ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                            <i class="fas fa-trash me-1"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Tidak ada data di tempat sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection