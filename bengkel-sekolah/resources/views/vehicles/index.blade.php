@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Data Kendaraan</h3>
    <div>
        <a href="{{ route('vehicles.trash') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-trash me-1"></i> Sampah
        </a>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Kendaraan
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="border-bottom bg-white">
                    <tr>
                        <th class="py-3 ps-3 text-dark fw-bold">Kode Kendaraan</th>
                        <th class="py-3 text-dark fw-bold">Plat Nomor</th>
                        <th class="py-3 text-dark fw-bold">Merek & Model</th>
                        <th class="py-3 text-dark fw-bold">Pemilik</th>
                        <th class="py-3 text-center text-dark fw-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehicles as $vehicle)
                        <tr>
                            <td class="fw-bold ps-3">
                                {{ $vehicle->vehicle_code ?? 'VH-' . str_pad($vehicle->vehicle_id ?? $vehicle->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <span class="badge bg-dark px-2 py-1">{{ $vehicle->plate_number ?? $vehicle->plat_nomor }}</span>
                            </td>
                            <td>
                                {{ $vehicle->brand->brand_name ?? $vehicle->brand_name ?? '' }} - {{ $vehicle->model_name ?? $vehicle->model }}
                            </td>
                            <td>{{ $vehicle->customer->full_name ?? $vehicle->customer_name ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('vehicles.edit', $vehicle->vehicle_id ?? $vehicle->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>

                                    <form action="{{ route('vehicles.destroy', $vehicle->vehicle_id ?? $vehicle->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')" class="d-inline">
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
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data kendaraan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection