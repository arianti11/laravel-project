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
        Schema::create('products', function (Blueprint $table) {
            // ID (Primary Key) - Auto Increment
            $table->id();
            
            // Foreign Key ke tabel categories
            // unsignedBigInteger = tipe data yang sama dengan id di categories
            // Kalau kategori dihapus, produk akan ikut dihapus (cascade)
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            
            // Kode Produk - Wajib diisi, unik (tidak boleh sama)
            // Contoh: PRD001, PRD002
            $table->string('code', 50)->unique();
            
            // Nama Produk - Wajib diisi
            $table->string('name', 200);
            
            // Slug - Untuk URL friendly
            $table->string('slug', 200)->unique();
            
            // Deskripsi Singkat - Ditampilkan di list produk
            $table->string('short_description', 500)->nullable();
            
            // Deskripsi Lengkap - Detail produk
            $table->text('description')->nullable();
            
            // Harga - Menggunakan decimal untuk angka desimal
            // decimal(15,2) = maksimal 15 digit, 2 digit di belakang koma
            // Contoh: 1.000.000,50
            $table->decimal('price', 15, 2);
            
            // Harga Diskon - Opsional
            $table->decimal('discount_price', 15, 2)->nullable();
            
            // Stok - Jumlah barang tersedia
            $table->integer('stock')->default(0);
            
            // Berat - Untuk keperluan pengiriman (dalam gram)
            $table->integer('weight')->nullable();
            
            // Gambar Utama - Featured Image
            $table->string('image')->nullable();
            
            // Status Produk
            // Enum = pilihan tetap (ready, preorder, sold_out)
            $table->enum('status', ['ready', 'preorder', 'sold_out'])->default('ready');
            
            // Status Publish (1 = publish, 0 = draft)
            $table->boolean('is_published')->default(true);
            
            // Views/Dilihat - Berapa kali produk dilihat
            $table->integer('views')->default(0);
            
            // Timestamps - created_at & updated_at
            $table->timestamps();
            
            // Soft Delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     * Fungsi ini dijalankan saat: php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};