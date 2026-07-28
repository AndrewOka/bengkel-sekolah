<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Method index() untuk Menampilkan Daftar Pelanggan
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    // Helper untuk membuat Kode Pelanggan Otomatis (CUST-0001, CUST-0002, dst)
    private function generateCustomerCode()
    {
        $lastCustomer = Customer::orderBy('customer_id', 'desc')->first();
        if (!$lastCustomer) {
            return 'CUST-0001';
        }
        
        $number = (int) substr($lastCustomer->customer_code ?? 'CUST-0000', 5);
        $newNumber = $number + 1;
        
        return 'CUST-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // 2. Form Tambah Pelanggan
    public function create()
    {
        $customerCode = $this->generateCustomerCode();
        return view('customers.create', compact('customerCode'));
    }

    // 3. Simpan Data Pelanggan Baru
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|numeric|digits_between:7,13',
            'type'      => 'nullable|string',
        ], [
            'phone.numeric'        => 'No. Telepon harus berupa angka!',
            'phone.digits_between' => 'No. Telepon minimal 7 digit dan maksimal 13 digit!',
        ]);

        $customerCode = $request->customer_code ?? $this->generateCustomerCode();

        Customer::create([
            'customer_code' => $customerCode,
            'full_name'     => $request->full_name,
            'phone'         => $request->phone,
            'type'          => $request->type ?? $request->customer_type ?? 'Siswa',
        ]);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // 4. Form Edit Pelanggan
    public function edit($id)
    {
        $customer = Customer::where('customer_id', $id)->orWhere('id', $id)->firstOrFail();
        return view('customers.edit', compact('customer'));
    }

    // 5. Update Data Pelanggan
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|numeric|digits_between:7,13',
            'type'      => 'nullable|string',
        ], [
            'phone.numeric'        => 'No. Telepon harus berupa angka!',
            'phone.digits_between' => 'No. Telepon minimal 7 digit dan maksimal 13 digit!',
        ]);

        $customer = Customer::where('customer_id', $id)->orWhere('id', $id)->firstOrFail();
        
        $customer->update([
            'full_name' => $request->full_name,
            'phone'     => $request->phone,
            'type'      => $request->type ?? $request->customer_type ?? $customer->type,
        ]);

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    // 6. Hapus Pelanggan
    public function destroy($id)
    {
        $customer = Customer::where('customer_id', $id)->orWhere('id', $id)->firstOrFail();
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }

    // 7. Menampilkan Halaman Trash (Tempat Sampah)
    public function trash()
    {
        $customers = Customer::onlyTrashed()->paginate(10);
        return view('customers.trash', compact('customers'));
    }

    // 8. Restore Data Pelanggan dari Trash
    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->orWhere('id', $id)->firstOrFail();
        $customer->restore();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan berhasil dipulihkan!');
    }

    // 9. Hapus Permanen Pelanggan
    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->orWhere('id', $id)->firstOrFail();
        $customer->forceDelete();

        return redirect()->route('customers.trash')->with('success', 'Data pelanggan dihapus permanen!');
    }
}