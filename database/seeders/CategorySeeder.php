<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data kategori kerajinan tangan
        $categories = [
            [
                'name' => 'Batik & Tenun',
                'slug' => 'batik-tenun',
                'description' => 'Kain batik tulis, batik cap, dan tenun tradisional dari berbagai daerah di Indonesia',
                'icon' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Keramik & Gerabah',
                'slug' => 'keramik-gerabah',
                'description' => 'Produk keramik dan gerabah dengan motif tradisional dan modern',
                'icon' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Anyaman',
                'slug' => 'anyaman',
                'description' => 'Tas, keranjang, dan produk anyaman dari rotan, bambu, dan pandan',
                'icon' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Ukiran Kayu',
                'slug' => 'ukiran-kayu',
                'description' => 'Produk ukiran kayu seperti patung, hiasan dinding, dan furniture',
                'icon' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Perhiasan',
                'slug' => 'perhiasan',
                'description' => 'Perhiasan handmade dari perak, emas, dan bahan natural',
                'icon' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Tekstil & Bordir',
                'slug' => 'tekstil-bordir',
                'description' => 'Produk tekstil dengan bordir tangan dan sulaman tradisional',
                'icon' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Lukisan & Seni',
                'slug' => 'lukisan-seni',
                'description' => 'Lukisan kanvas, seni abstrak, dan karya seni kontemporer',
                'icon' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Aksesori Fashion',
                'slug' => 'aksesori-fashion',
                'description' => 'Aksesori fashion handmade seperti syal, topi, dan tas',
                'icon' => null,
                'is_active' => true,
            ],
        ];

        // Insert data ke database
        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ ' . count($categories) . ' kategori berhasil dibuat!');
    }
}