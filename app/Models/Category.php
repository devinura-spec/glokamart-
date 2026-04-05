<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // relasi ke produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // relasi ke brand (Canon, Sony, dll)
    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
}
