<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel untuk menyimpan shopping cart user
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Foreign Key ke products
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            // Quantity/Jumlah barang
            $table->integer('quantity')->default(1);
            
            // Harga saat ditambahkan ke cart (snapshot)
            $table->decimal('price', 15, 2);
            
            $table->timestamps();
            
            // Index untuk performa
            $table->index('user_id');
            $table->index('product_id');
            
            // Unique: 1 user hanya bisa punya 1 item yang sama di cart
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};