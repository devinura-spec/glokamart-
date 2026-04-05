<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();

        $table->string('name');          // nama produk
        $table->integer('price');        // harga
        $table->string('image')->nullable(); // gambar
        $table->text('description')->nullable(); // deskripsi

        $table->unsignedBigInteger('category_id');
        $table->unsignedBigInteger('brand_id');

        $table->timestamps();

        // relasi
        $table->foreign('category_id')
              ->references('id')
              ->on('categories')
              ->onDelete('cascade');

        $table->foreign('brand_id')
              ->references('id')
              ->on('brands')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
