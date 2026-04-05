<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Kolom tersembunyi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke user_details
     */
    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function role()
{
    return $this->belongsTo(Role::class);
}

public function messagesSent()
{
    return $this->hasMany(\App\Models\ChatMessage::class, 'user_id');
}

public function messagesReceived()
{
    return $this->hasMany(\App\Models\ChatMessage::class, 'receiver_id');
}


}
