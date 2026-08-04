@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Kelola Merek Kendaraan</h3>
    <div>
        <a href="{{ route('brands.trash') }}" class="btn btn-outline-secondary">
            <i class="fas fa-trash me-1"></i> Sampah
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Tambah Merek</h5>
                <form action="{{ route('brands.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="brand_name" class="form-label text-muted fw-semibold">Nama Merek</label>
                        <input type="text" name="brand_name" id="brand_name" class="form-control @error('brand_name') is-invalid @enderror" placeholder="Contoh: Honda / Yamaha" value="{{ old('brand_name') }}" required>
                        @error('brand_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i> Simpan Merek
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="border-bottom bg-white">
                            <tr>
                                <th class="py-3 ps-3 text-dark fw-bold" style="width: 10%;">No</th>
                                <th class="py-3 text-dark fw-bold">Nama Merek</th>
                                <th class="py-3 text-center text-dark fw-bold" style="width: 30%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $index => $brand)
                                <tr>
                                    <td class="ps-3 fw-semibold">{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-dark">{{ $brand->brand_name }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('brands.edit', $brand->brand_id ?? $brand->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('brands.destroy', $brand->brand_id ?? $brand->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus merek ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada data merek kendaraan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection