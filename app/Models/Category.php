<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database
     * Laravel otomatis pakai "categories" (plural dari Category)
     */
    protected $table = 'categories';

    /**
     * Kolom yang boleh diisi massal (mass assignment)
     * Contoh: Category::create(['name' => 'Batik'])
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    /**
     * Casting tipe data
     * Mengubah data dari database ke tipe data yang sesuai
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method - Dijalankan otomatis
     * Untuk membuat slug otomatis dari name
     */
    protected static function boot()
    {
        parent::boot();

        // Event: sebelum create (menyimpan data baru)
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Event: sebelum update (mengubah data)
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * RELASI: 1 kategori punya banyak produk (One to Many)
     * 
     * Cara pakai:
     * $category = Category::find(1);
     * $products = $category->products; // Ambil semua produk di kategori ini
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * SCOPE: Hanya ambil kategori yang aktif
     * 
     * Cara pakai:
     * Category::active()->get(); // Ambil semua kategori aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * ACCESSOR: Mendapatkan URL icon
     * 
     * Cara pakai:
     * $category->icon_url
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/' . $this->icon);
        }
        return asset('images/default-category.png');
    }

    /**
     * ACCESSOR: Hitung jumlah produk
     * 
     * Cara pakai:
     * $category->products_count
     */
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
}