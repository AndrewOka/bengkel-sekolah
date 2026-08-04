<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Customer;
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
                      // HANYA mencari berdasarkan 'full_name' sesuai kolom DB
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

    public function create()
    {
        $customers = Customer::all();

        // 1. Ambil ID kendaraan yang sedang memiliki status booking AKTIF
        $activeVehicleIds = Booking::whereIn('status', ['Pending', 'Proses', 'Reschedule'])
            ->pluck('vehicle_id')
            ->toArray();

        // 2. Ambil hanya kendaraan yang TIDAK ADA dalam daftar booking aktif
        $vehicles = Vehicle::whereNotIn('vehicle_id', $activeVehicleIds)->get();

        // Hitung urutan kode booking
        $count = Booking::count(); 
        $nextNumber = $count + 1;
        $bookingCode = 'BK-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('bookings.create', compact('bookingCode', 'customers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,vehicle_id',
            'booking_date' => 'required|date|after_or_equal:today',
            'notes'        => 'nullable|string',
        ]);

        // Cegah Double Booking jika diakses bersamaan
        $isAlreadyBooked = Booking::where('vehicle_id', $request->vehicle_id)
            ->whereIn('status', ['Pending', 'Proses', 'Reschedule'])
            ->exists();

        if ($isAlreadyBooked) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['vehicle_id' => 'Kendaraan ini sedang dalam proses booking/servis aktif!']);
        }

        Booking::create([
            'vehicle_id'   => $request->vehicle_id,
            'user_id'      => auth()->id(),
            'booking_date' => $request->booking_date,
            'status'       => 'Pending',
            'notes'        => $request->notes,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking baru berhasil dibuat');
    }

    public function edit($id)
    {
        $booking   = Booking::where('booking_id', $id)->firstOrFail();
        $customers = Customer::all();
        $vehicles  = Vehicle::with('customer')->get();

        return view('bookings.edit', compact('booking', 'customers', 'vehicles'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('booking_id', $id)->firstOrFail();

        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,vehicle_id',
            'booking_date' => 'required|date',
            'status'       => 'required|in:Pending,Proses,Reschedule,Finish,Batal',
            'notes'        => 'nullable|string',
        ]);

        $booking->update([
            'vehicle_id'   => $request->vehicle_id,
            'booking_date' => $request->booking_date,
            'status'       => $request->status,
            'notes'        => $request->notes,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Data booking berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Proses,Reschedule,Finish,Batal'
        ]);

        $booking = Booking::where('booking_id', $id)->firstOrFail();
        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status booking berhasil diubah');
    }

    public function destroy($id)
    {
        $booking = Booking::where('booking_id', $id)->firstOrFail();
        $booking->delete(); // Soft delete

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dipindahkan ke tempat sampah!');
    }

    // --- FITUR TRASH / SAMPAH ---
    public function trash()
    {
        $bookings = Booking::onlyTrashed()->with(['vehicle.customer'])->latest()->paginate(10);
        return view('bookings.trash', compact('bookings'));
    }

    public function restore($id)
    {
        $booking = Booking::onlyTrashed()->where('booking_id', $id)->firstOrFail();
        $booking->restore();

        return redirect()->route('bookings.trash')->with('success', 'Data booking berhasil dikembalikan!');
    }

    public function forceDelete($id)
    {
        $booking = Booking::onlyTrashed()->where('booking_id', $id)->firstOrFail();
        $booking->forceDelete();

        return redirect()->route('bookings.trash')->with('success', 'Data booking berhasil dihapus permanen!');
    }
}