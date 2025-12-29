<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by Stock
        if ($request->has('stock') && $request->stock != '') {
            if ($request->stock == 'low') {
                $query->where('stock', '<', 10);
            } elseif ($request->stock == 'out') {
                $query->where('stock', 0);
            }
        }

        // Sorting
        $query->latest();

        // Pagination
        $products = $query->paginate(10);
        $products->appends($request->all());

        // Categories untuk filter
        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200|unique:products,name',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'status' => 'required|in:ready,preorder,sold_out',
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'category_id.required' => 'Kategori wajib dipilih',
            'name.required' => 'Nama produk wajib diisi',
            'name.unique' => 'Nama produk sudah ada',
            'price.required' => 'Harga wajib diisi',
            'discount_price.lt' => 'Harga diskon harus lebih kecil dari harga normal',
            'stock.required' => 'Stok wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        // Set is_published
        $validated['is_published'] = $request->has('is_published') ? 1 : 0;

        // Upload gambar utama
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Simpan produk
        $product = Product::create($validated);

        // Upload multiple images (galeri)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('products/gallery', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'order' => $key + 1,
                ]);
            }
        }
        ActivityLogger::logCreate($product, "Created product: {$product->name}");

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200|unique:products,name,' . $product->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'status' => 'required|in:ready,preorder,sold_out',
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Update slug jika nama berubah
        if ($validated['name'] != $product->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set is_published
        $validated['is_published'] = $request->has('is_published') ? 1 : 0;

        // Upload gambar utama baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Update produk
        $product->update($validated);

        // Upload gambar galeri baru
        if ($request->hasFile('images')) {
            $lastOrder = $product->images()->max('order') ?? 0;
            
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('products/gallery', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'order' => $lastOrder + $key + 1,
                ]);
            }
        }
        //ActivityLogger::logUpdate($product, $oldValues, "Updated product: {$product->name}");

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Hapus gambar utama dari storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Hapus gambar galeri
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }

            // Soft delete produk
            $product->delete();
            ActivityLogger::logDelete($product, "Deleted product: {$product->name}");
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
    }

    /**
     * Hapus gambar galeri
     */
    public function deleteImage(ProductImage $image)
    {
        try {
            // Hapus file dari storage
            Storage::disk('public')->delete($image->image);
            
            // Hapus dari database
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }
}