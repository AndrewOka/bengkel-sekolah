@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">Edit Data Kendaraan</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        {{-- Tampilkan Pesan Error Validasi Jika Ada --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vehicles.update', $vehicle->vehicle_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kode Kendaraan (Readonly) --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Kode Kendaraan</label>
                <input type="text" name="vehicle_code" class="form-control bg-light" value="{{ $vehicle->vehicle_code }}" readonly>
            </div>

            {{-- Pemilik (Customer) --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Pemilik (Customer)</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach($customers as $c)
                        @php $cId = $c->id ?? $c->customer_id; @endphp
                        <option value="{{ $cId }}" {{ old('customer_id', $vehicle->customer_id) == $cId ? 'selected' : '' }}>
                            {{ $c->full_name }} ({{ $c->customer_type }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Merek Kendaraan --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Merek Kendaraan</label>
                <select name="brand_id" class="form-select" required>
                    <option value="">-- Pilih Merek --</option>
                    @foreach($brands as $b)
                        @php $bId = $b->id ?? $b->brand_id; @endphp
                        <option value="{{ $bId }}" {{ old('brand_id', $vehicle->brand_id) == $bId ? 'selected' : '' }}>
                            {{ $b->brand_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nomor Plat --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor Plat (Unik)</label>
                <input type="text" name="plate_number" class="form-control" placeholder="DK 1234 AB" value="{{ old('plate_number', $vehicle->plate_number) }}" required>
            </div>

            {{-- Model / Seri Motor --}}
            <div class="mb-3">
                <label for="model" class="form-label fw-bold">Model / Seri Motor</label>
                <input type="text" 
                       name="model" 
                       id="model" 
                       class="form-control" 
                       placeholder="Contoh: Vario 150 / Mio M3" 
                       value="{{ old('model', $vehicle->model) }}" 
                       required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Kendaraan</button>
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection