<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fungsi ini dijalankan saat: php artisan migrate
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            // ID (Primary Key) - Auto Increment
            $table->id();
            
            // Nama Kategori - Wajib diisi, maksimal 100 karakter
            $table->string('name', 100);
            
            // Slug - Untuk URL friendly (contoh: kerajinan-kayu)
            // Unique artinya tidak boleh ada yang sama
            $table->string('slug', 100)->unique();
            
            // Deskripsi - Boleh kosong (nullable)
            $table->text('description')->nullable();
            
            // Icon/Gambar Kategori - Boleh kosong
            $table->string('icon')->nullable();
            
            // Status - Aktif atau Tidak (1 = aktif, 0 = tidak aktif)
            // Default = 1 (aktif)
            $table->boolean('is_active')->default(true);
            
            // Timestamps - created_at & updated_at (otomatis)
            $table->timestamps();
            
            // Soft Delete - untuk hapus data tanpa benar-benar menghapus dari database
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     * Fungsi ini dijalankan saat: php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};