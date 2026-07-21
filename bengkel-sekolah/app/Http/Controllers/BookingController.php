<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['vehicle.customer', 'vehicle.brand', 'user']);

        // Search Plat Nomor / Nama Customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('vehicle', function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($c) use ($search) {
                      $c->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('booking_date', [$request->start_date, $request->end_date]);
        }

        $bookings = $query->latest()->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    public function create() {
        $vehicles = Vehicle::with('customer')->get();
        return view('bookings.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        // Validasi Tanggal >= Hari Ini
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'booking_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string',
        ], [
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu (harus ≥ hari ini).'
        ]);

        Booking::create([
            'vehicle_id' => $request->vehicle_id,
            'user_id' => auth()->id(),
            'booking_date' => $request->booking_date,
            'status' => 'Pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking baru berhasil dibuat');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Proses,Reschedule,Finish'
        ]);

        // Cari berdasarkan booking_id sesuai primary key di ERD
        $booking = Booking::where('booking_id', $id)->firstOrFail();
        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status booking berhasil diubah');
    }
}