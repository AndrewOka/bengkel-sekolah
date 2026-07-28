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

    // 2. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|unique:brands,brand_name|max:255',
        ]);

        Brand::create($request->only('brand_name'));

        return redirect()->route('brands.index')->with('success', 'Merek kendaraan berhasil ditambahkan.');
    }

    // 3. Form Edit Data
    public function edit($id)
    {
        $brand = Brand::where('brand_id', $id)->orWhere('id', $id)->firstOrFail();
        return view('brands.edit', compact('brand'));
    }

    // 4. Update Data Merek
    public function update(Request $request, $id)
    {
        $brand = Brand::where('brand_id', $id)->orWhere('id', $id)->firstOrFail();

        $primaryKeyColumn = $brand->getKeyName();
        $primaryKeyValue  = $brand->getKey();

        $request->validate([
            'brand_name' => 'required|max:255|unique:brands,brand_name,' . $primaryKeyValue . ',' . $primaryKeyColumn,
        ]);

        $brand->update($request->only('brand_name'));

        return redirect()->route('brands.index')->with('success', 'Merek kendaraan berhasil diperbarui.');
    }

    // 5. Hapus Sementara (Soft Delete)
    public function destroy($id)
    {
        $brand = Brand::where('brand_id', $id)->orWhere('id', $id)->firstOrFail();
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Merek dipindahkan ke sampah.');
    }

    // 6. Tampil Halaman Trash
    public function trash()
    {
        $brands = Brand::onlyTrashed()->paginate(10);
        return view('brands.trash', compact('brands'));
    }

    // 7. Restore Data dari Trash
    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->where('brand_id', $id)->orWhere('id', $id)->firstOrFail();
        $brand->restore();

        return redirect()->route('brands.trash')->with('success', 'Merek kendaraan berhasil dipulihkan!');
    }

    // 8. Hapus Permanen
    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->where('brand_id', $id)->orWhere('id', $id)->firstOrFail();
        $brand->forceDelete();

        return redirect()->route('brands.trash')->with('success', 'Merek kendaraan dihapus permanen!');
    }
}