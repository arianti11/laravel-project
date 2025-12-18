<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'product_images';

    /**
     * Kolom yang boleh diisi massal (mass assignment)
     */
    protected $fillable = [
        'product_id',
        'image',
        'order',
        'caption',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELASI: Gambar ini milik 1 produk (Belongs To)
     * 
     * Cara pakai:
     * $image = ProductImage::find(1);
     * $product = $image->product; // Ambil produk dari gambar ini
     * echo $image->product->name; // Nama produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * ACCESSOR: Mendapatkan URL gambar lengkap
     * 
     * Cara pakai:
     * $image->image_url
     * Output: http://localhost/storage/products/image.jpg
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.png');
    }

    /**
     * SCOPE: Urutkan berdasarkan order (ascending)
     * 
     * Cara pakai:
     * ProductImage::ordered()->get();
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * SCOPE: Gambar berdasarkan produk tertentu
     * 
     * Cara pakai:
     * ProductImage::byProduct(1)->get();
     */
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}