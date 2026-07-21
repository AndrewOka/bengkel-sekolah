@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">Tambah Kendaraan Baru</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf
           <div class="mb-3">
    <label class="form-label fw-bold">Kode Kendaraan</label>
    <input type="text" name="vehicle_code" class="form-control bg-light" value="{{ $vehicleCode }}" readonly>
</div>
            <div class="mb-3">
                <label class="form-label fw-bold">Pemilik (Customer)</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->customer_id }}">{{ $c->full_name }} ({{ $c->customer_type }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Merek Kendaraan</label>
                <select name="brand_id" class="form-select" required>
                    <option value="">-- Pilih Merek --</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->brand_id }}">{{ $b->brand_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor Plat (Unik)</label>
                <input type="text" name="plate_number" class="form-control" placeholder="DK 1234 AB" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Model / Seri Motor</label>
                <input type="text" name="model" class="form-control" placeholder="Vario 150 / Mio M3" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Kendaraan</button>
        </form>
    </div>
</div>
@endsection