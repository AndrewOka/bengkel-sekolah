<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Menampilkan Daftar Pelanggan
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    // 2. Menampilkan Form Tambah Pelanggan
    // 2. Menampilkan Form Tambah Pelanggan
// 2. Menampilkan Form Tambah Pelanggan dengan Kode Otomatis
public function create()
{
    // Hitung data yang aktif saja + 1
    $nextNumber = Customer::count() + 1;

    // Sesuai ERD: CUST-001 (atau CUST-0001)
    $customerCode = 'CUST-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    return view('customers.create', compact('customerCode'));
}
    // 3. Menyimpan Data Pelanggan Baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required|unique:customers,customer_code',
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|max:15',
            'customer_type'  => 'required|in:Siswa,Guru',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // 4. Menampilkan Form Edit Pelanggan
    public function edit($id)
    {
        // PERBAIKAN: Cari berdasarkan customer_id
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        return view('customers.edit', compact('customer'));
    }

    // 5. Mengupdate Data Pelanggan
    public function update(Request $request, $id)
    {
        // PERBAIKAN: Cari berdasarkan customer_id
        $customer = Customer::where('customer_id', $id)->firstOrFail();

        $request->validate([
            'customer_code' => 'required|unique:customers,customer_code,' . $customer->customer_id . ',customer_id',
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|max:15',
            'customer_type'  => 'required|in:Siswa,Guru',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // 6. Hapus Sementara (Soft Delete)
    public function destroy($id)
    {
        // PERBAIKAN: Cari berdasarkan customer_id (Baris 95)
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan dipindahkan ke sampah.');
    }

    // 7. Menampilkan Halaman Trash (Tempat Sampah)
    public function trash()
    {
        $customers = Customer::onlyTrashed()->paginate(10);
        return view('customers.trash', compact('customers'));
    }

    // 8. Mengembalikan Data dari Trash
    public function restore($id)
    {
        // PERBAIKAN: Cari berdasarkan customer_id
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->firstOrFail();
        $customer->restore();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan berhasil dipulihkan!');
    }

    // 9. Menghapus Permanen
    public function forceDelete($id)
    {
        // PERBAIKAN: Cari berdasarkan customer_id
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->firstOrFail();
        $customer->forceDelete();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan dihapus permanen!');
    }
}