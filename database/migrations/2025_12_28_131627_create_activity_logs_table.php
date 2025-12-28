<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel untuk menyimpan semua aktivitas user di sistem
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // User yang melakukan aktivitas
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            
            // Tipe aktivitas (create, update, delete, login, logout, dll)
            $table->string('type', 50);
            
            // Model yang diakses (Product, Category, User, Order, dll)
            $table->string('model')->nullable();
            
            // ID dari model yang diakses
            $table->unsignedBigInteger('model_id')->nullable();
            
            // Deskripsi aktivitas
            $table->text('description');
            
            // Data sebelum perubahan (untuk update/delete)
            $table->json('old_values')->nullable();
            
            // Data setelah perubahan (untuk create/update)
            $table->json('new_values')->nullable();
            
            // IP Address user
            $table->string('ip_address', 45)->nullable();
            
            // User Agent (browser info)
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index('user_id');
            $table->index('type');
            $table->index('model');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};