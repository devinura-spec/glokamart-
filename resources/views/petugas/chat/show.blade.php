@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">

    <!-- HEADER -->
    <div class="flex items-center gap-4 mb-4 bg-white p-4 rounded-2xl shadow">

        <!-- BACK -->
       <a href="{{ route('petugas.chat.index') }}">⬅</a>
         

        <!-- FOTO -->
        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
            👤
        </div>

        <!-- NAMA USER -->
        <div>
            <h2 class="font-semibold text-lg">
                {{ $user->name }}
            </h2>
            <p class="text-xs text-gray-400">
                Chat pelanggan
            </p>
        </div>

    </div>

    <!-- CHAT BOX -->
    <div id="chat-box" 
         class="bg-white shadow-xl rounded-2xl p-4 h-[450px] overflow-y-auto flex flex-col gap-3">

        @forelse($messages as $msg)
            @php
                $isPetugas = $msg->user_id == auth()->id();
            @endphp

            <div class="flex {{ $isPetugas ? 'justify-end' : 'justify-start' }}">

                <div class="
                    px-4 py-2 rounded-2xl max-w-xs break-words shadow
                    {{ $isPetugas 
                        ? 'bg-green-500 text-white rounded-br-none' 
                        : 'bg-gray-200 text-gray-800 rounded-bl-none' }}">
                    
                    {{ $msg->message }}

                    <div class="text-[10px] mt-1 
                        {{ $isPetugas ? 'text-green-100 text-right' : 'text-gray-500' }}">
                        {{ $msg->created_at->format('H:i') }}
                    </div>

                </div>
            </div>

        @empty
            <p class="text-center text-gray-500 mt-20">
                Belum ada pesan
            </p>
        @endforelse

    </div>

    <!-- FORM KIRIM -->
    <form action="{{ route('petugas.chat.store') }}" method="POST" 
          class="flex gap-2 mt-4">
        @csrf

        <!-- USER TUJUAN -->
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">

        <!-- INPUT -->
        <input type="text" name="message"
            class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
            placeholder="Ketik pesan..." required>

        <!-- BUTTON -->
        <button type="submit"
            class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-full shadow">
            ➤
        </button>
    </form>

</div>

<!-- AUTO SCROLL -->
<script>
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>

@endsection