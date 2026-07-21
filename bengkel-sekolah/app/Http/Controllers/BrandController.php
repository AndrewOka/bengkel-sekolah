<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index() {
        $brands = Brand::latest()->paginate(10);
        return view('brands.index', compact('brands'));
    }

   public function store(Request $request)
{
    $request->validate([
        'brand_name' => 'required|unique:brands,brand_name|max:255',
    ]);

    // UBAH DARI: Brand::create($request->all());
    // MENJADI HANYA MENGAMBIL 'brand_name':
    Brand::create($request->only('brand_name'));

    return redirect()->route('brands.index')->with('success', 'Merek kendaraan berhasil ditambahkan.');
}

    public function destroy($id) {
        Brand::findOrFail($id)->delete();
        return redirect()->route('brands.index')->with('success', 'Merek berhasil dihapus.');
    }
}