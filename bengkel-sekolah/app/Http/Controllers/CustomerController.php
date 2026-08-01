<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Tampil Data Utama
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

   // 2. Form Tambah Pelanggan
public function create()
{
    // Ambil data pelanggan terakhir berdasarkan customer_code (termasuk yang di sampah)
    $lastCustomer = Customer::withTrashed()
        ->where('customer_code', 'LIKE', 'CUST-%')
        ->orderBy('customer_code', 'desc')
        ->first();

    if ($lastCustomer) {
        // Ambil angka dari string 'CUST-0001' (mengambil angka setelah 'CUST-')
        $lastNumber = (int) substr($lastCustomer->customer_code, 5);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }

    // Buat format CUST-0001
    $customerCode = 'CUST-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    return view('customers.create', compact('customerCode'));
}

// 3. Simpan Data Pelanggan Baru
public function store(Request $request)
{
    $request->validate([
        'customer_code' => 'required|unique:customers,customer_code',
        'full_name'     => 'required|string|max:255',
        'phone'         => 'required|string|max:15',
        'customer_type' => 'required|in:Siswa,Guru',
    ]);

    Customer::create([
        'customer_code' => $request->customer_code,
        'full_name'     => $request->full_name,
        'phone'         => $request->phone,
        'customer_type' => $request->customer_type,
    ]);

    return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
}
    // 4. Form Edit
    public function edit($id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        return view('customers.edit', compact('customer'));
    }

    // 5. Update Data
    public function update(Request $request, $id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();

        $request->validate([
            'customer_code' => 'required|unique:customers,customer_code,' . $customer->customer_id . ',customer_id',
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|max:15',
            'customer_type' => 'required|in:Siswa,Guru',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // 6. Soft Delete
    public function destroy($id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan dipindahkan ke sampah.');
    }

    // 7. Halaman Trash
    public function trash()
    {
        $customers = Customer::onlyTrashed()->paginate(10);
        return view('customers.trash', compact('customers'));
    }

    // 8. Restore
    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->firstOrFail();
        $customer->restore();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan berhasil dipulihkan!');
    }

    // 9. Force Delete
    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->firstOrFail();
        $customer->forceDelete();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan dihapus permanen!');
    }
}