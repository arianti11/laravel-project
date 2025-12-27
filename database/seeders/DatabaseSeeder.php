<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Jalankan dengan command:
     * php artisan db:seed
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding database...');
        $this->command->info('');

        // ============================================
        // 1. BUAT ADMIN DEFAULT
        // ============================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Administrator',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('✅ Admin baru berhasil dibuat!');
        } else {
            // Update role jika sudah ada tapi role-nya salah
            if ($admin->role !== 'admin') {
                $admin->update(['role' => 'admin']);
                $this->command->info('✅ Admin role berhasil diupdate!');
            } else {
                $this->command->warn('⚠️  Admin sudah ada, skip...');
            }
        }

        // ============================================
        // 2. BUAT STAFF DEFAULT
        // ============================================
        $staff = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff Operator',
                'phone' => '081234567891',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        if ($staff->wasRecentlyCreated) {
            $this->command->info('✅ Staff baru berhasil dibuat!');
        } else {
            // Update role jika sudah ada tapi role-nya salah
            if ($staff->role !== 'staff') {
                $staff->update(['role' => 'staff']);
                $this->command->info('✅ Staff role berhasil diupdate!');
            } else {
                $this->command->warn('⚠️  Staff sudah ada, skip...');
            }
        }

        // ============================================
        // 3. BUAT USER/CUSTOMER DEMO
        // ============================================
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Customer Demo',
                'phone' => '081234567892',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->command->info('✅ Customer demo baru berhasil dibuat!');
        } else {
            // Update role jika sudah ada tapi role-nya salah
            if ($user->role !== 'user') {
                $user->update(['role' => 'user']);
                $this->command->info('✅ Customer role berhasil diupdate!');
            } else {
                $this->command->warn('⚠️  Customer demo sudah ada, skip...');
            }
        }

        // ============================================
        // 4. BUAT KATEGORI SAMPLE
        // ============================================
        $categories = [
            [
                'name' => 'Kerajinan Kayu',
                'slug' => 'kerajinan-kayu',
                'description' => 'Berbagai produk kerajinan dari kayu berkualitas tinggi',
                'is_active' => true,
            ],
            [
                'name' => 'Batik & Tenun',
                'slug' => 'batik-tenun',
                'description' => 'Koleksi batik dan tenun asli Indonesia',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'description' => 'Produk makanan dan minuman khas daerah',
                'is_active' => true,
            ],
            [
                'name' => 'Aksesoris',
                'slug' => 'aksesoris',
                'description' => 'Aksesoris handmade dengan desain unik',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Produk fashion lokal berkualitas',
                'is_active' => true,
            ],
        ];

        $this->command->info('');
        $categoryCount = 0;
        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            if ($category->wasRecentlyCreated) {
                $categoryCount++;
            }
        }

        if ($categoryCount > 0) {
            $this->command->info("✅ {$categoryCount} kategori baru berhasil dibuat!");
        } else {
            $this->command->warn('⚠️  Semua kategori sudah ada, skip...');
        }

        // ============================================
        // 5. INFO OUTPUT
        // ============================================
        $this->command->info('');
        // ============================================
        // 6. SEED PRODUCTS (OPTIONAL)
        // ============================================
        $this->command->info('');
        if ($this->command->confirm('Apakah Anda ingin membuat produk sample?', true)) {
            $this->call(ProductSeeder::class);
        }

        // ============================================
        // 7. INFO OUTPUT
        // ============================================
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('🎉 Seeder berhasil dijalankan!');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('👑 LOGIN ADMIN (Super User):');
        $this->command->info('   Email    : admin@example.com');
        $this->command->info('   Password : password');
        $this->command->info('   Role     : Administrator');
        $this->command->info('');
        $this->command->info('👨‍💼 LOGIN STAFF (Operator):');
        $this->command->info('   Email    : staff@example.com');
        $this->command->info('   Password : password');
        $this->command->info('   Role     : Staff');
        $this->command->info('');
        $this->command->info('👤 LOGIN USER (Customer):');
        $this->command->info('   Email    : user@example.com');
        $this->command->info('   Password : password');
        $this->command->info('   Role     : Customer');
        $this->command->info('');
        $this->command->warn('⚠️  PENTING: Ganti password di production!');
        $this->command->info('═══════════════════════════════════════════════');
    }
}