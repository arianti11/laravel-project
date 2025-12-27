<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎨 Memulai seeding products...');

        // Ambil semua kategori
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('❌ Tidak ada kategori! Jalankan CategorySeeder terlebih dahulu.');
            return;
        }

        // Data produk sample untuk setiap kategori
        $productsData = [
            // Kerajinan Kayu
            [
                'name' => 'Meja Kayu Jati Minimalis',
                'category' => 'kerajinan-kayu',
                'price' => 1500000,
                'discount_price' => 1350000,
                'stock' => 15,
                'weight' => 25000,
                'status' => 'ready',
            ],
            [
                'name' => 'Kursi Kayu Mahoni Set',
                'category' => 'kerajinan-kayu',
                'price' => 2500000,
                'stock' => 8,
                'weight' => 30000,
                'status' => 'ready',
            ],
            [
                'name' => 'Lemari Kayu Ukiran Klasik',
                'category' => 'kerajinan-kayu',
                'price' => 5000000,
                'discount_price' => 4500000,
                'stock' => 3,
                'weight' => 50000,
                'status' => 'preorder',
            ],

            // Batik & Tenun
            [
                'name' => 'Batik Tulis Solo Premium',
                'category' => 'batik-tenun',
                'price' => 350000,
                'discount_price' => 315000,
                'stock' => 25,
                'weight' => 500,
                'status' => 'ready',
            ],
            [
                'name' => 'Kain Tenun Ikat NTT',
                'category' => 'batik-tenun',
                'price' => 450000,
                'stock' => 12,
                'weight' => 600,
                'status' => 'ready',
            ],
            [
                'name' => 'Batik Cap Pekalongan',
                'category' => 'batik-tenun',
                'price' => 250000,
                'stock' => 30,
                'weight' => 400,
                'status' => 'ready',
            ],
            [
                'name' => 'Sarung Tenun Troso',
                'category' => 'batik-tenun',
                'price' => 180000,
                'stock' => 5,
                'weight' => 350,
                'status' => 'ready',
            ],

            // Makanan & Minuman
            [
                'name' => 'Keripik Singkong Balado',
                'category' => 'makanan-minuman',
                'price' => 35000,
                'discount_price' => 30000,
                'stock' => 100,
                'weight' => 250,
                'status' => 'ready',
            ],
            [
                'name' => 'Kopi Arabica Gayo Premium',
                'category' => 'makanan-minuman',
                'price' => 85000,
                'stock' => 50,
                'weight' => 200,
                'status' => 'ready',
            ],
            [
                'name' => 'Dodol Garut Original',
                'category' => 'makanan-minuman',
                'price' => 45000,
                'stock' => 75,
                'weight' => 500,
                'status' => 'ready',
            ],
            [
                'name' => 'Teh Hijau Organik',
                'category' => 'makanan-minuman',
                'price' => 55000,
                'stock' => 8,
                'weight' => 100,
                'status' => 'ready',
            ],

            // Aksesoris
            [
                'name' => 'Gelang Perak Handmade',
                'category' => 'aksesoris',
                'price' => 125000,
                'discount_price' => 100000,
                'stock' => 20,
                'weight' => 50,
                'status' => 'ready',
            ],
            [
                'name' => 'Kalung Mutiara Air Tawar',
                'category' => 'aksesoris',
                'price' => 350000,
                'stock' => 10,
                'weight' => 30,
                'status' => 'ready',
            ],
            [
                'name' => 'Cincin Perak Motif Ukir',
                'category' => 'aksesoris',
                'price' => 95000,
                'stock' => 15,
                'weight' => 20,
                'status' => 'ready',
            ],
            [
                'name' => 'Anting Etnik Cantik',
                'category' => 'aksesoris',
                'price' => 65000,
                'stock' => 0,
                'weight' => 10,
                'status' => 'sold_out',
            ],

            // Fashion
            [
                'name' => 'Kemeja Batik Pria Modern',
                'category' => 'fashion',
                'price' => 250000,
                'discount_price' => 225000,
                'stock' => 25,
                'weight' => 300,
                'status' => 'ready',
            ],
            [
                'name' => 'Dress Batik Wanita Elegan',
                'category' => 'fashion',
                'price' => 350000,
                'stock' => 18,
                'weight' => 400,
                'status' => 'ready',
            ],
            [
                'name' => 'Tas Tenun Etnik',
                'category' => 'fashion',
                'price' => 180000,
                'stock' => 12,
                'weight' => 500,
                'status' => 'ready',
            ],
            [
                'name' => 'Sepatu Kulit Asli Handmade',
                'category' => 'fashion',
                'price' => 450000,
                'stock' => 6,
                'weight' => 800,
                'status' => 'preorder',
            ],
        ];

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($productsData as $productData) {
            // Cari kategori berdasarkan slug
            $category = $categories->where('slug', $productData['category'])->first();
            
            if (!$category) {
                $this->command->warn("⚠️  Kategori '{$productData['category']}' tidak ditemukan, skip produk: {$productData['name']}");
                $skippedCount++;
                continue;
            }

            // Generate slug
            $slug = Str::slug($productData['name']);

            // Cek apakah produk dengan slug ini sudah ada
            $existingProduct = Product::where('slug', $slug)->first();
            
            if ($existingProduct) {
                $this->command->warn("⚠️  Produk '{$productData['name']}' sudah ada, skip...");
                $skippedCount++;
                continue;
            }

            // Buat short description
            $shortDescription = "Produk {$productData['name']} berkualitas tinggi dengan harga terjangkau.";

            // Buat description lengkap
            $description = "
                <p><strong>{$productData['name']}</strong> adalah produk unggulan kami dari kategori {$category->name}.</p>
                <p>Produk ini dibuat dengan material berkualitas tinggi dan dikerjakan oleh pengrajin berpengalaman.</p>
                <h4>Spesifikasi:</h4>
                <ul>
                    <li>Material: Premium Quality</li>
                    <li>Berat: " . ($productData['weight'] / 1000) . " kg</li>
                    <li>Garansi: 1 Tahun</li>
                    <li>Made in Indonesia</li>
                </ul>
                <h4>Keunggulan:</h4>
                <ul>
                    <li>Kualitas terjamin</li>
                    <li>Harga bersaing</li>
                    <li>Pengiriman cepat</li>
                    <li>Pelayanan ramah</li>
                </ul>
            ";

            Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => $slug,
                'short_description' => $shortDescription,
                'description' => $description,
                'price' => $productData['price'],
                'discount_price' => $productData['discount_price'] ?? null,
                'stock' => $productData['stock'],
                'weight' => $productData['weight'],
                'status' => $productData['status'],
                'is_published' => true,
                'views' => rand(10, 500),
            ]);

            $createdCount++;
        }

        $this->command->info('');
        if ($createdCount > 0) {
            $this->command->info("✅ Berhasil membuat {$createdCount} produk baru!");
        }
        if ($skippedCount > 0) {
            $this->command->warn("⚠️  {$skippedCount} produk di-skip (sudah ada)");
        }
        if ($createdCount === 0 && $skippedCount > 0) {
            $this->command->info("ℹ️  Semua produk sudah ada di database");
        }
        $this->command->info('');
        $this->command->warn('⚠️  Catatan: Gambar produk belum diupload. Akan menggunakan default image.');
    }
}php artisan db:seed --class=ProductSeeder