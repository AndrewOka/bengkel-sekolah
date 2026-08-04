@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Edit Booking #BK-{{ $booking->booking_id }}</h3>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('bookings.update', $booking->booking_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="customer_id" class="form-label fw-bold">Pelanggan</label>
                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->customer_id ?? $customer->id }}" 
                                {{ old('customer_id', $booking->vehicle->customer_id ?? '') == ($customer->customer_id ?? $customer->id) ? 'selected' : '' }}>
                                {{ $customer->full_name ?? $customer->name }} {{ isset($customer->type) ? '('.$customer->type.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="vehicle_id" class="form-label fw-bold">Kendaraan</label>
                    <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->vehicle_id }}" {{ old('vehicle_id', $booking->vehicle_id) == $v->vehicle_id ? 'selected' : '' }}>
                                {{ $v->plate_number ?? '-' }} - {{ $v->model_name ?? $v->model ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="booking_date" class="form-label fw-bold">Tanggal Booking</label>
                    <input type="date" name="booking_date" id="booking_date" class="form-control @error('booking_date') is-invalid @enderror" value="{{ old('booking_date', $booking->booking_date) }}" required>
                    @error('booking_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach(['Pending', 'Proses', 'Reschedule', 'Finish', 'Batal'] as $st)
                            <option value="{{ $st }}" {{ old('status', $booking->status) == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label fw-bold">Catatan / Keluhan</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection