<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Tampilkan Semua Pelanggan
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customers.index', compact('customers'));
    }

    // 2. Form Tambah Pelanggan
public function create()
{
    // Mengambil semua customer (termasuk yang di sampah jika menggunakan SoftDeletes)
    $query = method_exists(Customer::class, 'withTrashed') 
        ? Customer::withTrashed() 
        : Customer::query();

    // Cari kode dengan angka terbesar (misal: CUST-0005)
    $lastCustomer = $query->where('customer_code', 'LIKE', 'CUST-%')
        ->orderByRaw("CAST(SUBSTRING(customer_code, 6) AS UNSIGNED) DESC")
        ->first();

    if ($lastCustomer) {
        // Ambil angka setelah 'CUST-'
        $lastNumber = (int) substr($lastCustomer->customer_code, 5);
        $nextNumber = sprintf('%04d', $lastNumber + 1);
    } else {
        $nextNumber = '0001';
    }

    $customerCode = 'CUST-' . $nextNumber; 

    return view('customers.create', compact('customerCode'));
}

    // 3. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required|unique:customers,customer_code',
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|max:13',
            'customer_type' => 'required',
        ]);

        Customer::create([
            'customer_code' => $request->customer_code,
            'full_name'     => $request->full_name,
            'phone'         => $request->phone,
            'customer_type' => $request->customer_type,
        ]);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // 4. Form Edit Pelanggan
    public function edit($id)
    {
        $customer = Customer::where('customer_id', $id)->first() ?? Customer::findOrFail($id);

        return view('customers.edit', compact('customer'));
    }

    // 5. Update Data Pelanggan
    public function update(Request $request, $id)
    {
        $request->validate([
            'phone'         => 'required|string|max:20',
            'customer_type' => 'required',
        ]);

        $customer = Customer::where('customer_id', $id)->first() ?? Customer::findOrFail($id);
        $inputName = $request->input('full_name') ?? $request->input('name');

        if (array_key_exists('full_name', $customer->getAttributes())) {
            $customer->full_name = $inputName;
        } else {
            $customer->name = $inputName;
        }

        if (array_key_exists('no_telp', $customer->getAttributes())) {
            $customer->no_telp = $request->phone;
        } else {
            $customer->phone = $request->phone;
        }

        $customer->customer_type = $request->customer_type;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    // 6. Hapus Pelanggan (Soft Delete)
    public function destroy($id)
{
    // Cari customer berdasarkan customer_id atau id
    $customer = Customer::where('customer_id', $id)->first() ?? Customer::findOrFail($id);
    
    // Panggil delete() -> Jika Model pakai SoftDeletes, data otomatis terisi deleted_at
    $customer->delete();

    return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dipindahkan ke sampah!');
}
  // 7. Tampilkan Data Sampah (Fitur Trash)
public function trash()
{
    // Langsung panggil onlyTrashed() tanpa pengecekan method_exists
    $customers = Customer::onlyTrashed()->latest()->get();

    return view('customers.trash', compact('customers'));
}
  // 8. Pulihkan Data dari Sampah (Restore)
    public function restore($id)
    {
        // Cari data berdasarkan customer_id
        $customer = Customer::withTrashed()
            ->where('customer_id', $id)
            ->firstOrFail();

        // Pulihkan data
        $customer->restore();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan berhasil dipulihkan!');
    }

    // 9. Hapus Permanen (Force Delete)
    public function forceDelete($id)
    {
        // Cari data berdasarkan customer_id
        $customer = Customer::withTrashed()
            ->where('customer_id', $id)
            ->firstOrFail();

        // Hapus permanen
        $customer->forceDelete();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan berhasil dihapus permanen!');
    }
}