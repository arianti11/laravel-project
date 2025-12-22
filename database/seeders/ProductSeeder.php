<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kategori yang sudah ada
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('❌ Tidak ada kategori! Jalankan CategorySeeder terlebih dahulu.');
            return;
        }

        // Data produk sample
        $products = [
            // Batik & Tenun
            [
                'category_id' => 1,
                'name' => 'Batik Tulis Premium Motif Parang',
                'short_description' => 'Kain batik tulis premium dengan motif parang klasik',
                'description' => 'Kain batik tulis premium dengan motif parang klasik yang dibuat dengan teknik tradisional. Menggunakan pewarna alami dan kain berkualitas tinggi.',
                'price' => 450000,
                'discount_price' => 400000,
                'stock' => 15,
                'weight' => 500,
                'status' => 'ready',
            ],
            [
                'category_id' => 1,
                'name' => 'Kain Tenun Ikat NTT',
                'short_description' => 'Tenun ikat tradisional dari Nusa Tenggara Timur',
                'description' => 'Kain tenun ikat asli NTT dengan motif tradisional yang kaya akan makna budaya. Dibuat oleh pengrajin lokal dengan teknik turun temurun.',
                'price' => 350000,
                'discount_price' => null,
                'stock' => 8,
                'weight' => 400,
                'status' => 'ready',
            ],

            // Keramik & Gerabah
            [
                'category_id' => 2,
                'name' => 'Vas Keramik Glasir Alami',
                'short_description' => 'Vas keramik dengan glasir natural dan desain minimalis',
                'description' => 'Vas keramik dengan finishing glasir alami yang memberikan tampilan elegan dan natural. Cocok untuk dekorasi ruang tamu atau kamar.',
                'price' => 175000,
                'discount_price' => 150000,
                'stock' => 25,
                'weight' => 1500,
                'status' => 'ready',
            ],
            [
                'category_id' => 2,
                'name' => 'Set Piring Keramik 6 Pcs',
                'short_description' => 'Set piring keramik handmade untuk sajian spesial',
                'description' => 'Set 6 piring keramik dengan desain unik dan warna-warna natural. Aman untuk makanan dan microwave.',
                'price' => 280000,
                'discount_price' => null,
                'stock' => 12,
                'weight' => 3000,
                'status' => 'ready',
            ],

            // Anyaman
            [
                'category_id' => 3,
                'name' => 'Tas Rotan Anyaman Premium',
                'short_description' => 'Tas rotan anyaman tangan dengan desain modern',
                'description' => 'Tas rotan anyaman 100% handmade dengan desain modern dan finishing halus. Dilengkapi dengan tali kulit asli.',
                'price' => 320000,
                'discount_price' => 280000,
                'stock' => 10,
                'weight' => 800,
                'status' => 'ready',
            ],
            [
                'category_id' => 3,
                'name' => 'Keranjang Pandan Wangi',
                'short_description' => 'Keranjang anyaman pandan untuk penyimpanan',
                'description' => 'Keranjang anyaman dari pandan wangi dengan ukuran sedang. Cocok untuk menyimpan pakaian, mainan, atau barang-barang rumah.',
                'price' => 125000,
                'discount_price' => null,
                'stock' => 20,
                'weight' => 600,
                'status' => 'ready',
            ],

            // Ukiran Kayu
            [
                'category_id' => 4,
                'name' => 'Patung Ukiran Jepara',
                'short_description' => 'Patung kayu jati ukiran Jepara',
                'description' => 'Patung ukiran dari kayu jati dengan detail yang sangat halus. Dibuat oleh pengrajin berpengalaman dari Jepara.',
                'price' => 850000,
                'discount_price' => null,
                'stock' => 5,
                'weight' => 2000,
                'status' => 'ready',
            ],
            [
                'category_id' => 4,
                'name' => 'Hiasan Dinding Relief Wayang',
                'short_description' => 'Relief wayang dari kayu mahoni',
                'description' => 'Hiasan dinding berupa relief wayang dengan detail ukiran yang indah. Terbuat dari kayu mahoni pilihan.',
                'price' => 450000,
                'discount_price' => 420000,
                'stock' => 7,
                'weight' => 1500,
                'status' => 'ready',
            ],

            // Perhiasan
            [
                'category_id' => 5,
                'name' => 'Kalung Perak Motif Etnik',
                'short_description' => 'Kalung perak 925 dengan motif etnik Indonesia',
                'description' => 'Kalung dari perak 925 dengan desain motif etnik tradisional Indonesia. Dikerjakan dengan teknik handmade oleh pengrajin berpengalaman.',
                'price' => 380000,
                'discount_price' => 350000,
                'stock' => 15,
                'weight' => 50,
                'status' => 'ready',
            ],
            [
                'category_id' => 5,
                'name' => 'Gelang Manik-manik Natural',
                'short_description' => 'Gelang dari manik-manik batu natural',
                'description' => 'Gelang cantik dari manik-manik batu natural dengan kombinasi warna yang menarik. Cocok untuk gaya casual maupun formal.',
                'price' => 150000,
                'discount_price' => null,
                'stock' => 30,
                'weight' => 30,
                'status' => 'ready',
            ],

            // Tekstil & Bordir
            [
                'category_id' => 6,
                'name' => 'Bantal Bordir Tangan Bunga',
                'short_description' => 'Bantal dengan bordir tangan motif bunga',
                'description' => 'Sarung bantal dengan bordir tangan motif bunga yang cantik dan detail. Bahan katun premium yang lembut dan nyaman.',
                'price' => 185000,
                'discount_price' => 165000,
                'stock' => 18,
                'weight' => 300,
                'status' => 'ready',
            ],
            [
                'category_id' => 6,
                'name' => 'Taplak Meja Sulam',
                'short_description' => 'Taplak meja dengan sulaman tradisional',
                'description' => 'Taplak meja dengan sulaman tradisional yang elegan. Cocok untuk acara spesial atau penggunaan sehari-hari.',
                'price' => 220000,
                'discount_price' => null,
                'stock' => 12,
                'weight' => 400,
                'status' => 'ready',
            ],

            // Lukisan & Seni
            [
                'category_id' => 7,
                'name' => 'Lukisan Abstrak Akrilik',
                'short_description' => 'Lukisan abstrak di kanvas dengan cat akrilik',
                'description' => 'Lukisan abstrak original dengan cat akrilik di kanvas. Cocok untuk dekorasi ruang tamu, kamar, atau kantor modern.',
                'price' => 650000,
                'discount_price' => 600000,
                'stock' => 6,
                'weight' => 2000,
                'status' => 'ready',
            ],
            [
                'category_id' => 7,
                'name' => 'Lukisan Pemandangan Bali',
                'short_description' => 'Lukisan pemandangan sawah terasering Bali',
                'description' => 'Lukisan pemandangan sawah terasering khas Bali dengan teknik cat minyak. Warna yang hidup dan detail yang indah.',
                'price' => 550000,
                'discount_price' => null,
                'stock' => 4,
                'weight' => 1800,
                'status' => 'ready',
            ],

            // Aksesori Fashion
            [
                'category_id' => 8,
                'name' => 'Syal Tenun Songket',
                'short_description' => 'Syal dari tenun songket dengan motif tradisional',
                'description' => 'Syal cantik dari tenun songket dengan motif tradisional yang elegan. Cocok untuk melengkapi outfit formal maupun casual.',
                'price' => 280000,
                'discount_price' => 250000,
                'stock' => 14,
                'weight' => 200,
                'status' => 'ready',
            ],
            [
                'category_id' => 8,
                'name' => 'Topi Pandan Pantai',
                'short_description' => 'Topi anyaman pandan untuk pantai',
                'description' => 'Topi stylish dari anyaman pandan yang cocok untuk ke pantai atau aktivitas outdoor. Ringan dan nyaman dipakai.',
                'price' => 95000,
                'discount_price' => null,
                'stock' => 25,
                'weight' => 150,
                'status' => 'ready',
            ],
        ];

        // Insert produk ke database
        $productCount = 0;
        foreach ($products as $productData) {
            // Generate kode produk otomatis
            $productData['code'] = 'PRD' . str_pad($productCount + 1, 5, '0', STR_PAD_LEFT);
            
            // Generate slug dari nama
            $productData['slug'] = Str::slug($productData['name']);
            
            // Cek apakah kategori ada
            if ($productData['category_id'] <= $categories->count()) {
                Product::create($productData);
                $productCount++;
            }
        }

        $this->command->info('✅ ' . $productCount . ' produk berhasil dibuat!');
    }
}