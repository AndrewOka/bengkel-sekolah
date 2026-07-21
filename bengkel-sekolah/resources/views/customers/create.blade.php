@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">Tambah Pelanggan Baru</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
           <div class="mb-3">
    <label class="form-label fw-bold">Kode Pelanggan</label>
    <input type="text" name="customer_code" class="form-control bg-light" value="{{ $customerCode }}" readonly>
</div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">No. Telepon (7 - 13 Digit)</label>
                <input type="text" name="phone" class="form-control" placeholder="08123456789" value="{{ old('phone') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tipe Pelanggan</label>
                <select name="customer_type" class="form-select" required>
                    <option value="Siswa">Siswa</option>
                    <option value="Guru">Guru</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Customer</button>
        </form>
    </div>
</div>
@endsection