<?php


    namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Order extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'user_id',
        'product_id',
        'total_price',
        'payment_status',
        
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ RELASI KE PRODUCT
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}