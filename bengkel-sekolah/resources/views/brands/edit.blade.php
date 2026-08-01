@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Edit Brand Kendaraan</h5>
                    <a href="{{ route('brands.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas => fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    {{-- Alert jika ada error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('brands.update', $brand->brand_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="brand_name" class="form-label fw-semibold">Nama Brand <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('brand_name') is-invalid @enderror" 
                                   id="brand_name" 
                                   name="brand_name" 
                                   value="{{ old('brand_name', $brand->brand_name) }}" 
                                   placeholder="Masukkan nama brand (misal: Honda, Yamaha)" 
                                   required>
                            @error('brand_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('brands.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas => fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection