<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database
     */
    protected $table = 'products';

    /**
     * Kolom yang boleh diisi massal (mass assignment)
     */
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'discount_price',
        'stock',
        'weight',
        'image',
        'status',
        'is_published',
        'views',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'weight' => 'integer',
        'views' => 'integer',
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method - Dijalankan otomatis
     */
    protected static function boot()
    {
        parent::boot();

        // Event: sebelum create (menyimpan data baru)
        static::creating(function ($product) {
            // Generate slug otomatis dari name
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            // Generate kode produk otomatis jika kosong
            if (empty($product->code)) {
                $product->code = 'PRD' . str_pad(Product::count() + 1, 5, '0', STR_PAD_LEFT);
            }
        });

        // Event: sebelum update
        static::updating(function ($product) {
            // Update slug jika name berubah
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * RELASI: Produk punya 1 kategori (Belongs To)
     * 
     * Cara pakai:
     * $product = Product::find(1);
     * $category = $product->category; // Ambil kategori produk ini
     * echo $product->category->name; // Nama kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * RELASI: Produk punya banyak gambar (One to Many)
     * 
     * Cara pakai:
     * $product = Product::find(1);
     * $images = $product->images; // Ambil semua gambar produk
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('order');
    }

    /**
     * SCOPE: Hanya produk yang dipublish
     * 
     * Cara pakai:
     * Product::published()->get();
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * SCOPE: Produk berdasarkan kategori
     * 
     * Cara pakai:
     * Product::byCategory(1)->get();
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * SCOPE: Produk dengan stok tersedia
     * 
     * Cara pakai:
     * Product::inStock()->get();
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * SCOPE: Search produk berdasarkan nama atau kode
     * 
     * Cara pakai:
     * Product::search('batik')->get();
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('code', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    /**
     * ACCESSOR: Mendapatkan URL gambar utama
     * 
     * Cara pakai:
     * $product->image_url
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.png');
    }

    /**
     * ACCESSOR: Hitung persentase diskon
     * 
     * Cara pakai:
     * $product->discount_percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * ACCESSOR: Harga final (jika ada diskon, pakai harga diskon)
     * 
     * Cara pakai:
     * $product->final_price
     */
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * ACCESSOR: Format harga dengan Rupiah
     * 
     * Cara pakai:
     * $product->formatted_price // Rp 350.000
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * ACCESSOR: Format harga diskon dengan Rupiah
     * 
     * Cara pakai:
     * $product->formatted_discount_price
     */
    public function getFormattedDiscountPriceAttribute()
    {
        if ($this->discount_price) {
            return 'Rp ' . number_format($this->discount_price, 0, ',', '.');
        }
        return null;
    }

    /**
     * ACCESSOR: Cek apakah produk sedang diskon
     * 
     * Cara pakai:
     * if ($product->is_on_sale) { ... }
     */
    public function getIsOnSaleAttribute()
    {
        return $this->discount_price && $this->discount_price < $this->price;
    }

    /**
     * ACCESSOR: Status badge color
     * 
     * Cara pakai:
     * $product->status_badge
     */
    public function getStatusBadgeAttribute()
    {
        return [
            'ready' => 'success',
            'preorder' => 'warning',
            'sold_out' => 'danger',
        ][$this->status] ?? 'secondary';
    }

    /**
     * METHOD: Tambah view count
     * 
     * Cara pakai:
     * $product->incrementViews();
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * METHOD: Kurangi stok
     * 
     * Cara pakai:
     * $product->decreaseStock(5); // Kurangi 5
     */
    public function decreaseStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            
            // Ubah status jadi sold_out jika stok habis
            if ($this->stock == 0) {
                $this->update(['status' => 'sold_out']);
            }
            
            return true;
        }
        return false;
    }

    /**
     * METHOD: Tambah stok
     * 
     * Cara pakai:
     * $product->increaseStock(10); // Tambah 10
     */
    public function increaseStock($quantity)
    {
        $this->increment('stock', $quantity);
        
        // Ubah status jadi ready jika sebelumnya sold_out
        if ($this->status == 'sold_out') {
            $this->update(['status' => 'ready']);
        }
    }
}