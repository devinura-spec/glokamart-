<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'name',
        'price',
        'price_hour',   // harga per jam
        'category_id',
        'brand_id',
        'image',
        'description',
        'stock',
        'rules',        // peraturan rental
    ];

    // relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // relasi ke Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
