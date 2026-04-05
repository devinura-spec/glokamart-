<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;

    // Bisa diisi mass assignable
   protected $fillable = [
    'user_id',
    'receiver_id',
    'message',
];
    

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}