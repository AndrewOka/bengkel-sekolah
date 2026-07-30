<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Brand;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // 1. Tampil Data Utama
    public function index()
    {
        $vehicles = Vehicle::with(['customer', 'brand'])->latest()->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    // 2. Form Tambah
   public function create()
{
    $customers = Customer::all();
    $brands = Brand::all();

    // Hitung data kendaraan yang aktif + 1
    $nextNumber = Vehicle::count() + 1;
    $vehicleCode = 'VH-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    return view('vehicles.create', compact('vehicleCode', 'customers', 'brands'));
}
    // 3. Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:15|unique:vehicles,plate_number',
            'customer_id'  => 'required',
            'brand_id'     => 'required',
            'model_name'   => 'required|string|max:100',
        ]);

        $latestId = Vehicle::withTrashed()->max('vehicle_id') ?? 0;

        Vehicle::create([
            'vehicle_code' => $request->vehicle_code ?? 'VH-' . str_pad($latestId + 1, 4, '0', STR_PAD_LEFT),
            'plate_number' => $request->plate_number,
            'customer_id'  => $request->customer_id,
            'brand_id'     => $request->brand_id,
            'model_name'   => $request->model_name,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    // 4. Form Edit
    public function edit($id)
    {
        $vehicle = Vehicle::where('vehicle_id', $id)->firstOrFail();
        $customers = Customer::all();
        $brands = Brand::all();

        return view('vehicles.edit', compact('vehicle', 'customers', 'brands'));
    }

    // 5. Update Data
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('vehicle_id', $id)->firstOrFail();

        $request->validate([
            'plate_number' => 'required|string|max:15|unique:vehicles,plate_number,' . $vehicle->vehicle_id . ',vehicle_id',
            'customer_id'  => 'required',
            'brand_id'     => 'required',
            'model_name'   => 'required|string|max:100',
        ]);

        $vehicle->update([
            'plate_number' => $request->plate_number,
            'customer_id'  => $request->customer_id,
            'brand_id'     => $request->brand_id,
            'model_name'   => $request->model_name,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    // 6. Hapus Ke Sampah (Soft Delete)
    public function destroy($id)
    {
        $vehicle = Vehicle::where('vehicle_id', $id)->firstOrFail();
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil dipindahkan ke sampah!');
    }

    // 7. Menampilkan Halaman Trash
    public function trash()
    {
        $vehicles = Vehicle::onlyTrashed()->with(['customer', 'brand'])->paginate(10);
        return view('vehicles.trash', compact('vehicles'));
    }

    // 8. Restore Data
    public function restore($id)
    {
        $vehicle = Vehicle::onlyTrashed()->where('vehicle_id', $id)->firstOrFail();
        $vehicle->restore();

        return redirect()->route('vehicles.trash')->with('success', 'Data kendaraan berhasil dipulihkan!');
    }

    // 9. Hapus Permanen
    public function forceDelete($id)
    {
        $vehicle = Vehicle::onlyTrashed()->where('vehicle_id', $id)->firstOrFail();
        $vehicle->forceDelete();

        return redirect()->route('vehicles.trash')->with('success', 'Data kendaraan dihapus permanen!');
    }
}