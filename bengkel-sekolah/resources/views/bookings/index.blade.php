@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Daftar Booking Servis</h3>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Buat Booking Baru</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('bookings.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari Plat No / Nama Customer..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    @foreach(['Pending', 'Proses', 'Reschedule', 'Finish'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-secondary w-100"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID Booking</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Kendaraan / Plat</th>
                        <th>Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><strong>#BK-{{ $booking->booking_id }}</strong></td>
                        <td>{{ $booking->booking_date }}</td>
                        <td>
                            {{ $booking->vehicle->customer->full_name ?? '-' }} 
                            <span class="badge bg-secondary">{{ $booking->vehicle->customer->customer_type ?? 'Umum' }}</span>
                        </td>
                        <td>{{ $booking->vehicle->model ?? '-' }} (<strong>{{ $booking->vehicle->plate_number ?? '-' }}</strong>)</td>
                        <td>
                            <span class="badge 
                                {{ $booking->status == 'Pending' ? 'bg-warning text-dark' : '' }}
                                {{ $booking->status == 'Proses' ? 'bg-info text-white' : '' }}
                                {{ $booking->status == 'Reschedule' ? 'bg-secondary' : '' }}
                                {{ $booking->status == 'Finish' ? 'bg-success' : '' }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('bookings.updateStatus', $booking->booking_id) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach(['Pending', 'Proses', 'Reschedule', 'Finish'] as $st)
                                        <option value="{{ $st }}" {{ $booking->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Data booking tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white pt-3">
        {{ $bookings->links() }}
    </div>
</div>
@endsection