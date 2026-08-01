@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Edit Data Pelanggan</h4>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('customers.update', $customer->customer_id ?? $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Kode Pelanggan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Pelanggan</label>
                    <input type="text" class="form-control bg-light" value="{{ $customer->customer_code ?? $customer->code }}" readonly disabled>
                </div>

                {{-- Nama Lengkap (diubah name="full_name") --}}
                <div class="mb-3">
                    <label for="full_name" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                         value="{{ old('name', $customer->name ?? $customer->full_name) }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No. Telepon --}}
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">No. Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $customer->phone ?? $customer->no_telp) }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tipe Pelanggan --}}
                <div class="mb-3">
                    <label for="customer_type" class="form-label fw-semibold">Tipe Pelanggan</label>
                    <select name="customer_type" id="customer_type" class="form-select @error('customer_type') is-invalid @enderror" required>
                        @php
                            $currentType = old('customer_type', $customer->customer_type);
                        @endphp
                        <option value="Siswa" {{ $currentType == 'Siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="Guru" {{ $currentType == 'Guru' ? 'selected' : '' }}>Guru</option>
                        <option value="Umum" {{ $currentType == 'Umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                    @error('customer_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection