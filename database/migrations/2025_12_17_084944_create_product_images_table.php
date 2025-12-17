<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fungsi ini dijalankan saat: php artisan migrate
     * 
     * Tabel ini untuk menyimpan MULTIPLE GAMBAR produk (galeri)
     * 1 produk bisa punya banyak gambar
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            // ID (Primary Key) - Auto Increment
            $table->id();
            
            // Foreign Key ke tabel products
            // Relasi: 1 produk bisa punya banyak gambar
            // Kalau produk dihapus, semua gambarnya ikut terhapus (cascade)
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            // Path/Nama File Gambar
            // Contoh: products/batik1.jpg
            $table->string('image');
            
            // Urutan Gambar (untuk sorting)
            // Gambar dengan order terkecil ditampilkan duluan
            // Default = 0
            $table->integer('order')->default(0);
            
            // Caption/Keterangan Gambar - Opsional
            $table->string('caption')->nullable();
            
            // Timestamps - created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Fungsi ini dijalankan saat: php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};