@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Sampah Kendaraan (Trash)</h3>
    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Kendaraan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle mb-0">
            {{-- Mengubah table-dark menjadi table-light agar header berwarna terang/putih --}}
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>No. Plat</th>
                    <th>Pemilik</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                <tr>
                    <td><span class="badge bg-secondary">{{ $vehicle->vehicle_code }}</span></td>
                    <td><span class="fw-bold">{{ $vehicle->plate_number }}</span></td>
                    <td>{{ $vehicle->customer->full_name ?? '-' }}</td>
                    <td>{{ $vehicle->brand->brand_name ?? '-' }}</td>
                    <td>{{ $vehicle->model_name }}</td>
                    <td class="text-center">
                        <form action="{{ route('vehicles.restore', $vehicle->vehicle_id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-undo"></i> Pulihkan
                            </button>
                        </form>
                        <form action="{{ route('vehicles.forceDelete', $vehicle->vehicle_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus permanen kendaraan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i> Hapus Permanen
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Tidak ada data kendaraan di sampah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $vehicles->links() }}
        </div>
    </div>
</div>
@endsection