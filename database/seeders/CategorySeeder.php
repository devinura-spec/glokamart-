<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Elektronik',
            'Kecantikan',
            'Makanan',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)], // cek duplikat berdasarkan slug
                ['name' => $name]            // jika belum ada, buat baru
            );
        }

        $this->command->info('✅ Kategori berhasil di-seed!');
    }
}
