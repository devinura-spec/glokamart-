<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Ambil banner terbaru (foto + video)
        $banners = Banner::latest()->get();

        // Kirim ke view home
        return view('home', [
            'categories' => $categories,
            'banners' => $banners
        ]);
    }
}