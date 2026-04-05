<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'category_id',
        'name',
        'slug',
    ];

    /**
     * Relasi Brand → Category
     * Satu brand hanya milik satu kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi Brand → Product
     * Satu brand bisa punya banyak produk
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
