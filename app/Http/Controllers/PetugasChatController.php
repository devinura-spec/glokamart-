<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage; // Model untuk menyimpan chat
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class PetugasChatController extends Controller
{
    // Halaman utama chat petugas


public function index()
{
    $petugasId = auth()->id();

    // Ambil user yang pernah chat ke petugas
    $users = User::whereHas('messagesSent', function ($q) use ($petugasId) {
        $q->where('receiver_id', $petugasId);
    })
    ->orWhereHas('messagesReceived', function ($q) use ($petugasId) {
        $q->where('user_id', $petugasId);
    })
    ->where('role_id', '!=', 3) // biar bukan petugas
    ->get();

    // Ambil pesan terakhir tiap user
    foreach ($users as $user) {
        $lastMsg = ChatMessage::where(function ($q) use ($user, $petugasId) {
            $q->where('user_id', $user->id)
              ->where('receiver_id', $petugasId);
        })->orWhere(function ($q) use ($user, $petugasId) {
            $q->where('user_id', $petugasId)
              ->where('receiver_id', $user->id);
        })
        ->latest()
        ->first();

        $user->last_message = $lastMsg->message ?? null;
        $user->last_time = $lastMsg ? $lastMsg->created_at->format('H:i') : null;
    }

    return view('petugas.chat.index', compact('users'));
}

    // Kirim pesan balasan petugas
   public function store(Request $request)
{
    $request->validate([
        'message' => 'required|string',
        'receiver_id' => 'required' // WAJIB
    ]);

    ChatMessage::create([
        'user_id' => Auth::id(), // petugas
        'receiver_id' => $request->receiver_id, // user tujuan
        'message' => $request->message
    ]);

    return back()->with('success', 'Pesan berhasil dikirim.');
}



public function show($userId)
{
    $petugasId = auth()->id();

    $user = User::findOrFail($userId);

    $messages = ChatMessage::where(function ($q) use ($userId, $petugasId) {
        $q->where('user_id', $userId)
          ->where('receiver_id', $petugasId);
    })->orWhere(function ($q) use ($userId, $petugasId) {
        $q->where('user_id', $petugasId)
          ->where('receiver_id', $userId);
    })
    ->orderBy('created_at', 'asc')
    ->get();

    return view('petugas.chat.show', compact('messages', 'user'));
}
}