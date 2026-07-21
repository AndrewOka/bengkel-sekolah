<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Method index() untuk Menampilkan Daftar Pelanggan
  public function index()
{
    // Ubah ::get() menjadi ::paginate(10)
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
        
        $number = (int) substr($lastCustomer->customer_code, 5);
        $newNumber = $number + 1;
        
        return 'CUST-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // 2. Form Tambah Pelanggan (Kode langsung terisi otomatis)
    public function create()
    {
        $customerCode = $this->generateCustomerCode();
        return view('customers.create', compact('customerCode'));
    }

    // 3. Simpan Data Pelanggan Baru
    public function store(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|min:7|max:15',
            'customer_type' => 'required|string',
        ]);

        $customerCode = $request->customer_code ?? $this->generateCustomerCode();

        Customer::create([
            'customer_code' => $customerCode,
            'full_name'     => $request->full_name,
            'phone'         => $request->phone,
            'customer_type' => $request->customer_type,
        ]);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // 4. Form Edit Pelanggan
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    // 5. Update Data Pelanggan
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|min:7|max:15',
            'customer_type' => 'required|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->only(['full_name', 'phone', 'customer_type']));

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    // 6. Hapus Pelanggan
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}