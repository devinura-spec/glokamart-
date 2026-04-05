@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">

    <h1 class="text-3xl font-bold text-green-600 mb-6 text-center">
        💬 Chat Pelanggan
    </h1>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden max-h-[600px] overflow-y-auto">

        @forelse($users as $u)
            @php
                // Ambil pesan terakhir yang dikirim user ke petugas atau petugas ke user
                $lastMessage = \App\Models\ChatMessage::where(function($q) use ($u) {
                    $q->where('user_id', $u->id)
                      ->where('receiver_id', auth()->id());
                })->orWhere(function($q) use ($u) {
                    $q->where('user_id', auth()->id())
                      ->where('receiver_id', $u->id);
                })->latest()->first();
            @endphp

            <a href="{{ route('petugas.chat.show', $u->id) }}"
               class="flex items-center gap-4 p-4 hover:bg-green-50 transition relative">

                <!-- FOTO AVATAR -->
                <div class="w-14 h-14 bg-gray-300 rounded-full flex items-center justify-center text-xl font-bold">
                    {{ strtoupper(substr($u->name,0,1)) }}
                </div>

                <!-- NAMA & PESAN TERAKHIR -->
                <div class="flex-1">
                    <h2 class="font-semibold text-lg">{{ $u->name }}</h2>
                    <p class="text-sm text-gray-500 truncate">
                        @if($lastMessage)
                            {!! $lastMessage->user_id == $u->id ? '🟢 ' : '' !!}
                            {{ $lastMessage->message }}
                        @else
                            <span class="text-gray-300 italic">Belum ada pesan</span>
                        @endif
                    </p>
                </div>

                <!-- WAKTU PESAN TERAKHIR -->
                <div class="text-xs text-gray-400">
                    {{ $lastMessage ? $lastMessage->created_at->format('H:i') : '' }}
                </div>

                <!-- INDIKATOR PESAN BARU -->
                @if($lastMessage && $lastMessage->user_id == $u->id && !$lastMessage->read_by_petugas)
                    <span class="absolute top-3 right-3 w-3 h-3 bg-green-500 rounded-full"></span>
                @endif
            </a>

        @empty
            <p class="text-center text-gray-500 py-20">Belum ada pelanggan yang chat</p>
        @endforelse

    </div>

</div>
@endsection