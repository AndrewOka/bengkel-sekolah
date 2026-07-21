<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Brand;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // 1. Method index() untuk Menampilkan Daftar Kendaraan
    public function index()
    {
        // Mengambil data kendaraan beserta relasi pelanggan dan merek
        $vehicles = Vehicle::with(['customer', 'brand'])->latest()->paginate(10);

        return view('vehicles.index', compact('vehicles'));
    }

    // Helper untuk membuat Kode Kendaraan Otomatis (VH-0001, VH-0002, dst)
    private function generateVehicleCode()
    {
        $lastVehicle = Vehicle::orderBy('vehicle_id', 'desc')->first();
        if (!$lastVehicle) {
            return 'VH-0001';
        }
        
        $number = (int) substr($lastVehicle->vehicle_code, 3);
        $newNumber = $number + 1;
        
        return 'VH-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // 2. Form Tambah Kendaraan (Kode terisi otomatis)
    public function create()
    {
        $vehicleCode = $this->generateVehicleCode();
        $customers   = Customer::all();
        $brands      = Brand::all();

        return view('vehicles.create', compact('vehicleCode', 'customers', 'brands'));
    }

    // 3. Simpan Data Kendaraan Baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'  => 'required|exists:customers,customer_id',
            'brand_id'     => 'required|exists:brands,brand_id',
            'plate_number' => 'required|string|unique:vehicles,plate_number',
            'model'        => 'required|string|max:255',
        ]);

        $vehicleCode = $request->vehicle_code ?? $this->generateVehicleCode();

        Vehicle::create([
            'vehicle_code' => $vehicleCode,
            'customer_id'  => $request->customer_id,
            'brand_id'     => $request->brand_id,
            'plate_number' => $request->plate_number,
            'model'        => $request->model,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    // 4. Form Edit Kendaraan
    public function edit($id)
    {
        $vehicle   = Vehicle::findOrFail($id);
        $customers = Customer::all();
        $brands    = Brand::all();

        return view('vehicles.edit', compact('vehicle', 'customers', 'brands'));
    }

    // 5. Update Data Kendaraan
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'customer_id'  => 'required|exists:customers,customer_id',
            'brand_id'     => 'required|exists:brands,brand_id',
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $id . ',vehicle_id',
            'model'        => 'required|string|max:255',
        ]);

        $vehicle->update($request->only(['customer_id', 'brand_id', 'plate_number', 'model']));

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    // 6. Hapus Data Kendaraan
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil dihapus!');
    }
}