<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Migration ini akan cek dulu kolom mana yang sudah ada
     * Dan mengupdate enum role untuk menambahkan 'staff'
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan kolom 'phone' jika belum ada
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)
                      ->nullable()
                      ->after('email');
            }
            
            // Cek dan tambahkan kolom 'avatar' jika belum ada
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')
                      ->nullable()
                      ->after('phone');
            }
            
            // Cek dan tambahkan kolom 'is_active' jika belum ada
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')
                      ->default(true)
                      ->after('avatar');
            }
        });

        // Update atau buat kolom role dengan 3 pilihan: admin, staff, user
        if (Schema::hasColumn('users', 'role')) {
            // Jika kolom role sudah ada, kita perlu modify enum-nya
            // Cara paling aman adalah dengan raw SQL
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'staff', 'user') NOT NULL DEFAULT 'user'");
        } else {
            // Jika belum ada, tambahkan kolom role baru
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'staff', 'user'])
                      ->default('user')
                      ->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hanya drop kolom yang ada
            $columnsToDrop = [];
            
            if (Schema::hasColumn('users', 'phone')) {
                $columnsToDrop[] = 'phone';
            }
            if (Schema::hasColumn('users', 'avatar')) {
                $columnsToDrop[] = 'avatar';
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $columnsToDrop[] = 'is_active';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });

        // Kembalikan role ke 2 pilihan saja
        if (Schema::hasColumn('users', 'role')) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
        }
    }
};