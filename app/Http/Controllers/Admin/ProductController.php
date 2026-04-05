<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ==============================
    // TAMPILKAN SEMUA PRODUK
    // ==============================
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // ==============================
    // FORM TAMBAH PRODUK
    // ==============================
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    // ==============================
    // SIMPAN PRODUK BARU
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'price_hour'  => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'rules'       => 'nullable|string',
        ]);

        $data = $request->only([
            'name',
            'price',
            'price_hour',
            'category_id',
            'brand_id',
            'stock',
            'description',
            'rules',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // ==============================
    // FORM EDIT PRODUK
    // ==============================
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // ==============================
    // UPDATE PRODUK
    // ==============================
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'price_hour'  => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'rules'       => 'nullable|string',
        ]);

        $data = $request->only([
            'name',
            'price',
            'price_hour',
            'category_id',
            'brand_id',
            'stock',
            'description',
            'rules',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    // ==============================
    // HAPUS PRODUK
    // ==============================
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
