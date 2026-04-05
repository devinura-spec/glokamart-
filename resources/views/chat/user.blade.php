@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold text-center mb-6">
        💬 Chat Petugas
    </h1>

    <!-- BOX CHAT -->
    <div id="chat-box" class="bg-white shadow-lg rounded-xl p-4 h-96 overflow-y-auto mb-4 flex flex-col gap-2">

        @forelse($messages as $msg)
            @php
                $isUser = $msg->user_id == auth()->id();
                $justify = $isUser ? 'justify-end' : 'justify-start';
                $animation = $isUser ? 'slide-in-right' : 'slide-in-left';
            @endphp

            <div class="flex {{ $justify }} animate__animated {{ $animation }}">
                <div class="{{ $isUser 
                    ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-2xl max-w-xs break-words shadow relative' 
                    : 'bg-gradient-to-r from-gray-200 to-gray-300 text-gray-900 px-4 py-2 rounded-2xl max-w-xs break-words shadow-inner' }}">
                    {{ $msg->message }}
                    <span class="{{ $isUser ? 'text-blue-200 text-right' : 'text-gray-500' }} block text-xs mt-1">
                        {{ $msg->created_at->format('H:i') }}
                    </span>
                </div>
            </div>

        @empty
            <p class="text-center text-gray-500 mt-20">Belum ada pesan</p>
        @endforelse

    </div>

    <!-- FORM KIRIM -->
    <form id="chat-form" action="{{ route('chat.user.send') }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="message"
            class="flex-1 border rounded-2xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Tulis pesan ke petugas..." required>

        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-2xl shadow-md">
            Kirim
        </button>
    </form>

</div>

<!-- ANIMASI SLIDE & SCROLL OTOMATIS -->
<style>
@keyframes slide-in-right { from {opacity:0; transform:translateX(50px);} to {opacity:1; transform:translateX(0);} }
@keyframes slide-in-left { from {opacity:0; transform:translateX(-50px);} to {opacity:1; transform:translateX(0);} }
.animate__animated.slide-in-right { animation: slide-in-right 0.3s ease-out; }
.animate__animated.slide-in-left { animation: slide-in-left 0.3s ease-out; }
</style>

<script>
const chatBox = document.getElementById('chat-box');
const chatForm = document.getElementById('chat-form');

// Scroll otomatis ke bawah
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}
scrollToBottom();

// Optional: AJAX submit supaya halaman tidak reload
chatForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(chatForm);
    const message = formData.get('message');

    if (!message.trim()) return;

    // Kirim ke server
    const token = document.querySelector('input[name="_token"]').value;
    const response = await fetch(chatForm.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: formData
    });

    if (response.ok) {
        const data = await response.json();

        // Append pesan baru ke chatBox
        const div = document.createElement('div');
        div.className = 'flex justify-end animate__animated slide-in-right';
        div.innerHTML = `
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-2xl max-w-xs break-words shadow relative">
                ${data.message}
                <span class="text-blue-200 block text-xs mt-1">${data.time}</span>
            </div>
        `;
        chatBox.appendChild(div);
        chatForm.reset();
        scrollToBottom();
    }
});
</script>
@endsection