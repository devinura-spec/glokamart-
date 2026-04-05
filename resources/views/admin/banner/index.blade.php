@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10">

    <h1 class="text-3xl font-bold mb-6">🎬 Kelola Banner</h1>

    <!-- FORM UPLOAD -->
   <form id="formBanner" action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="file">
  <button type="submit" onclick="alert('FORM BANNER KEKLIK')">Upload</button>
</form>

    <!-- LIST BANNER -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($banners as $banner)
            <div class="bg-white p-2 rounded-xl shadow hover:shadow-lg transition">
                @if($banner->type === 'image')
                    <img src="{{ asset('storage/'.$banner->file) }}" 
     class="w-full h-24 object-cover rounded-lg">
                @elseif($banner->type === 'video')
                    <video class="w-full h-40 object-cover rounded-lg" controls>
                        <source src="{{ asset('storage/'.$banner->file) }}" type="video/mp4">
                    </video>
                @endif

                <form action="{{ route('admin.banner.delete', $banner->id) }}" 
                      method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 text-white w-full py-1 rounded hover:bg-red-600">
                        Hapus
                    </button>
                </form>

            </div>
        @endforeach
    </div>

</div>
@endsection