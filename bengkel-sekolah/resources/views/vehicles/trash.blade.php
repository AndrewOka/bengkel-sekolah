@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Sampah Data Kendaraan</h3>
    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
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
                                {{ $vehicle->brand->brand_name ?? '' }} - {{ $vehicle->model_name ?? '' }}
                            </td>
                            <td>{{ $vehicle->customer->full_name ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <form action="{{ route('vehicles.restore', $vehicle->vehicle_id ?? $vehicle->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                                            <i class="fas fa-rotate-left me-1"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('vehicles.forceDelete', $vehicle->vehicle_id ?? $vehicle->id) }}" method="POST" onsubmit="return confirm('Hapus permanen kendaraan ini?')" class="d-inline">
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
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada data kendaraan di tempat sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection