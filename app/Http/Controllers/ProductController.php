<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // ==============================
    // HALAMAN UTAMA (HOME)
    // ==============================
    public function index()
    {
        $products = Product::latest()->get();
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    // ==============================
    // HALAMAN KATEGORI (DINAMIS)
    // contoh: /kategori/dslr
    // ==============================
    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->latest()->get();

        return view('products.category', compact('category', 'products'));
    }

    // ==============================
    // HALAMAN DETAIL PRODUK
    // contoh: /produk/5
    // ==============================
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }
}