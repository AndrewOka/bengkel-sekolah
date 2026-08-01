@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Daftar Booking Servis</h3>
    <div>
        {{-- Tombol Sampah Hanya Muncul untuk Admin --}}
        @can('isAdmin')
            <a href="{{ route('bookings.trash') }}" class="btn btn-outline-secondary me-2" title="Tempat Sampah">
                <i class="fa-solid fa-trash-can"></i> Sampah
            </a>
        @endcan

        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Buat Booking Baru
        </a>
    </div>
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
            <table class="table table-custom m-0 align-middle">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $index => $b)
                        <tr>
                            <td class="fw-bold text-primary">
                                BK-{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            
                            <td>{{ \Carbon\Carbon::parse($b->booking_date)->format('d M Y') }}</td>
                            
                            <td>
                                {{ $b->vehicle->customer->full_name ?? $b->vehicle->customer->name ?? '-' }}
                            </td>
                            
                            <td>
                                {{ $b->vehicle->model_name ?? $b->vehicle->model ?? '-' }} 
                                <span class="fw-bold">({{ $b->vehicle->plate_number ?? '-' }})</span>
                            </td>
                            
                            <td>
                                {{-- Jika Staff / Admin, Tampilkan Form Quick Change Status --}}
                                @can('update-booking-status')
                                    <form action="{{ route('bookings.updateStatus', $b->booking_id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm fw-bold border-0 bg-light">
                                            @foreach(['Pending', 'Proses', 'Reschedule', 'Finish'] as $st)
                                                <option value="{{ $st }}" {{ $b->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="badge bg-warning text-dark">{{ ucfirst($b->status) }}</span>
                                @endcan
                            </td>
                            
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('bookings.edit', $b->booking_id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    @can('isAdmin')
                                        <form action="{{ route('bookings.destroy', $b->booking_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data booking.</td>
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