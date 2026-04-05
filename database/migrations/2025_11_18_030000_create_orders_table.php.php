<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi user
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Total semua item (gunakan decimal)
            $table->decimal('total_amount', 12, 2);

            // Status pesanan
            $table->enum('status', [
                'pending',
                'processing',
                'shipping',
                'completed',
                'cancelled'
            ])->default('pending');

            // Metode pembayaran
            $table->string('payment_method')->nullable();

            // Alamat pengiriman (opsional)
            $table->unsignedBigInteger('shipping_address_id')->nullable();

            $table->timestamps();

            // Foreign key: shipping address
            $table->foreign('shipping_address_id')
                  ->references('id')
                  ->on('shipping_addresses')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
