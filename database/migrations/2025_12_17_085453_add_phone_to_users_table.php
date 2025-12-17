<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom phone & role ke tabel users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom phone setelah kolom email
            $table->string('phone', 15)->nullable()->after('email');
            
            // Tambah kolom role (admin, user)
            // Default = user
            $table->enum('role', ['admin', 'user'])->default('user')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kolom yang ditambahkan
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role']);
        });
    }
};