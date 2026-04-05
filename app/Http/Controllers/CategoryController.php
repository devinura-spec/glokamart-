<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    // Tampilkan halaman kategori + semua produk di kategori itu
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->latest()->get();

        return view('categories.show', compact('category', 'products'));
    }
}
