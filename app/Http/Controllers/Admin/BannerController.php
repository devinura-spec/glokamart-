<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner.index', compact('banners'));
    }

   public function store(Request $request)
{
    $request->validate([
        'file' => 'required',
        'file.*' => 'file|mimes:jpg,jpeg,png,mp4|max:20480'
    ]);

    $files = $request->file('file');

    // 🔥 paksa jadi array
    if (!is_array($files)) {
        $files = [$files];
    }

    foreach ($files as $file) {

        $path = $file->store('banners', 'public');

        $type = str_contains($file->getMimeType(), 'video') 
                ? 'video' 
                : 'image';

        Banner::create([
            'file' => $path,
            'type' => $type
        ]);
    }

    return back()->with('success', 'Semua banner berhasil ditambahkan!');
}

    public function destroy($id)
    {
        Banner::findOrFail($id)->delete();
        return back()->with('success', 'Banner dihapus');
    }
}