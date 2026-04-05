@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold text-center mb-6">
        💬 Chat Petugas
    </h1>

    <!-- BOX CHAT -->
    <div class="bg-white shadow rounded-lg p-4 h-96 overflow-y-auto mb-4">

        @forelse($messages as $msg)

            <!-- CHAT USER -->
            @if($msg->user_id == auth()->id())
                <div class="flex justify-end mb-2">
                    <div class="bg-blue-500 text-white px-4 py-2 rounded-lg max-w-xs">
                        {{ $msg->message }}
                    </div>
                </div>

            <!-- CHAT PETUGAS -->
            @else
                <div class="flex justify-start mb-2">
                    <div class="bg-gray-200 px-4 py-2 rounded-lg max-w-xs">
                        {{ $msg->message }}
                    </div>
                </div>
            @endif

        @empty
            <p class="text-center text-gray-500">Belum ada pesan</p>
        @endforelse

    </div>

    <!-- FORM KIRIM -->
    <form action="{{ route('chat.user.send') }}" method="POST">
        @csrf

        <div class="flex gap-2">
            <input type="text" name="message"
                class="w-full border px-3 py-2 rounded-lg"
                placeholder="Tulis pesan ke petugas..." required>

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 rounded-lg">
                Kirim
            </button>
        </div>

    </form>

</div>
@endsection