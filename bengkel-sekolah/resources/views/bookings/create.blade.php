@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Buat Booking Servis Baru</h3>
    <a href="{{ route('bookings.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Kendaraan & Customer</label>
                <select name="vehicle_id" class="form-select" required>
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->vehicle_id }}">
                            {{ $vehicle->plate_number }} - {{ $vehicle->model }} (Pemilik: {{ $vehicle->customer->full_name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Booking</label>
                <input type="date" name="booking_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                <small class="text-muted">Tanggal booking harus hari ini atau tanggal setelahnya.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Catatan Servis / Keluhan</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Contoh: Ganti oli, rem berbunyi..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan Booking</button>
        </form>
    </div>
</div>
@endsection