<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Tampilkan semua brand per kategori
     */
    public function index()
    {
        $categories = Category::with('brands')->get();
        return view('admin.brands.index', compact('categories'));
    }

    /**
     * Form tambah brand
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.brands.create', compact('categories'));
    }

    /**
     * Simpan brand baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255|unique:brands,name',
        ]);

        // Buat slug unik otomatis
        $slug = Str::slug($request->name);
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Brand::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $slug,
        ]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand berhasil ditambahkan');
    }

    /**
     * Form edit brand
     */
    public function edit(Brand $brand)
    {
        $categories = Category::all();
        return view('admin.brands.edit', compact('brand', 'categories'));
    }

    /**
     * Update brand
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255|unique:brands,name,' . $brand->id,
        ]);

        $slug = Str::slug($request->name);
        $count = Brand::where('slug', $slug)
            ->where('id', '!=', $brand->id)
            ->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $brand->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $slug,
        ]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand berhasil diupdate');
    }

    /**
     * Hapus brand
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand berhasil dihapus');
    }
}
