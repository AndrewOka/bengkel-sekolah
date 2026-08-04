@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-danger"><i class="fa-solid fa-trash-can me-2"></i>Tempat Sampah Booking</h3>
    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom m-0 align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Dihapus Pada</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $index => $b)
                        <tr>
                            <td>{{ $bookings->firstItem() + $index }}</td>
                            <td class="fw-bold text-primary">#BK-{{ $b->booking_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->booking_date)->format('d M Y') }}</td>
                            <td>{{ $b->vehicle->customer->full_name ?? $b->vehicle->customer->name ?? '-' }}</td>
                            <td class="text-muted">{{ $b->deleted_at->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <form action="{{ route('bookings.restore', $b->booking_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Kembalikan Data">
                                            <i class="fa-solid fa-rotate-left"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('bookings.forceDelete', $b->booking_id) }}" method="POST" onsubmit="return confirm('Yakin ingin MENGHAPUS PERMANEN data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                            <i class="fa-solid fa-dumpster"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tempat sampah kosong.</td>
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