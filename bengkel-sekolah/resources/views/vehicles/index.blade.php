@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Data Kendaraan</h3>
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah Kendaraan</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Kode Kendaraan</th>
                    <th>Plat Nomor</th>
                    <th>Merek & Model</th>
                    <th>Pemilik</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $v)
                <tr>
                    <td><strong>{{ $v->vehicle_code }}</strong></td>
                    <td><span class="badge bg-dark">{{ $v->plate_number }}</span></td>
                    <td>{{ $v->brand->brand_name }} - {{ $v->model }}</td>
                    <td>{{ $v->customer->full_name }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">Data kendaraan kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white pt-3">{{ $vehicles->links() }}</div>
</div>
@endsection