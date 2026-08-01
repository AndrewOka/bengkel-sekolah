@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Sampah Data Merek Kendaraan</h3>
    <a href="{{ route('brands.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="border-bottom bg-white">
                    <tr>
                        <th class="py-3 ps-3 text-dark fw-bold" style="width: 10%;">#</th>
                        <th class="py-3 text-dark fw-bold">Nama Merek</th>
                        <th class="py-3 text-center text-dark fw-bold" style="width: 30%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr>
                            <td class="ps-3 fw-semibold">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-dark">{{ $brand->brand_name }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <form action="{{ route('brands.restore', $brand->brand_id ?? $brand->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-rotate-left me-1"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('brands.forceDelete', $brand->brand_id ?? $brand->id) }}" method="POST" onsubmit="return confirm('Hapus permanen merek ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash me-1"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Tidak ada data merek di tempat sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection