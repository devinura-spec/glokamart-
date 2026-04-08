<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'invoice_code',
        'start_date',
        'end_date',
        'total_price',
        'payment_method',
        'payment_status',
        
    ];

    // Relasi ke Product
   public function product()
{
    return $this->belongsTo(\App\Models\Product::class);
}

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}