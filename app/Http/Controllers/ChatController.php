<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;

class ChatController extends Controller
{
    public function userChat()
    {
        $petugas = User::where('role_id', 3)->first();
        if (!$petugas) {
            abort(404, 'Petugas tidak ditemukan');
        }

        $messages = ChatMessage::where(function($q) use ($petugas){
            $q->where('user_id', auth()->id())
              ->where('receiver_id', $petugas->id);
        })->orWhere(function($q) use ($petugas){
            $q->where('user_id', $petugas->id)
              ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        return view('chat.user', compact('messages'));
    }

  public function sendUser(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:1000'
    ]);

    $petugas = User::where('role_id', 3)->first();
    if (!$petugas) {
        abort(404, 'Petugas tidak ditemukan');
    }

    // Simpan ke variabel $chat
    $chat = ChatMessage::create([
        'user_id' => auth()->id(),
        'receiver_id' => $petugas->id,
        'message' => $request->message
    ]);

    // Jika pakai AJAX → return JSON
    return response()->json([
        'message' => $chat->message,
        'time' => $chat->created_at->format('H:i')
    ]);
}



}