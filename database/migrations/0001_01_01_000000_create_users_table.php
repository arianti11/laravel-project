<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel users untuk menyimpan data pengguna
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // ID (Primary Key) - Auto Increment
            $table->id();
            
            // Nama Lengkap - Wajib diisi
            $table->string('name');
            
            // Email - Wajib diisi, unik (tidak boleh sama)
            $table->string('email')->unique();
            
            // Nomor Telepon - Opsional
            $table->string('phone', 15)->nullable();
            
            // Email Verified At - Untuk verifikasi email
            $table->timestamp('email_verified_at')->nullable();
            
            // Password - Wajib diisi (akan di-hash)
            $table->string('password');
            
            // Role - Admin atau User
            // Default = user
            $table->enum('role', ['admin', 'user'])->default('user');
            
            // Avatar/Foto Profil - Opsional
            $table->string('avatar')->nullable();
            
            // Status Aktif - Default aktif (1)
            $table->boolean('is_active')->default(true);
            
            // Remember Token - Untuk "Remember Me" saat login
            $table->rememberToken();
            
            // Timestamps - created_at & updated_at
            $table->timestamps();
            
            // Soft Delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel users
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};