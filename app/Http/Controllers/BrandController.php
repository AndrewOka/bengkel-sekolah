<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // 1. Tampil Data Utama
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('brands.index', compact('brands'));
    }

    // 2. Form Tambah
    public function create()
    {
        return view('brands.create');
    }

    // 3. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:100|unique:brands,brand_name',
        ]);

        Brand::create([
            'brand_name' => $request->brand_name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Data brand berhasil ditambahkan!');
    }

    // 4. Form Edit Data
    public function edit($id)
    {
        // Hanya cari berdasarkan brand_id
        $brand = Brand::where('brand_id', $id)->firstOrFail();

        return view('brands.edit', compact('brand'));
    }

    // 5. Update Data
    public function update(Request $request, $id)
    {
        $brand = Brand::where('brand_id', $id)->firstOrFail();

        $request->validate([
            'brand_name' => 'required|string|max:100|unique:brands,brand_name,' . $brand->brand_id . ',brand_id',
        ]);

        $brand->update([
            'brand_name' => $request->brand_name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Data brand berhasil diperbarui!');
    }

    // 6. Hapus Sementara (Soft Delete)
    public function destroy($id)
    {
        $brand = Brand::where('brand_id', $id)->firstOrFail();
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Data brand berhasil dihapus!');
    }

    // 7. Menampilkan Halaman Sampah (Trash)
    public function trash()
    {
        $brands = Brand::onlyTrashed()->paginate(10);
        return view('brands.trash', compact('brands'));
    }

    // 8. Restore Data
    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->where('brand_id', $id)->firstOrFail();
        $brand->restore();

        return redirect()->route('brands.trash')->with('success', 'Data brand berhasil dikembalikan!');
    }

    // 9. Hapus Permanen
    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->where('brand_id', $id)->firstOrFail();
        $brand->forceDelete();

        return redirect()->route('brands.trash')->with('success', 'Data brand berhasil dihapus permanen!');
    }
}