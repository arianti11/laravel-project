<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by stock level
        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('stock', '<=', 10)->where('stock', '>', 0);
            } elseif ($request->stock === 'out') {
                $query->where('stock', 0);
            }
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::active()->get();

        return view('staff.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('staff.products.create', compact('categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'status' => 'required|in:ready,preorder,sold_out',
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload main image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Create product
        $product = Product::create($validated);

        // Upload additional images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('staff.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load('category', 'images');
        return view('staff.products.show', compact('product'));
    }

    /**
     * Show the form for editing the product
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $product->load('images');
        
        return view('staff.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'status' => 'required|in:ready,preorder,sold_out',
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload new main image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Update product
        $product->update($validated);

        // Upload additional images if provided
        if ($request->hasFile('additional_images')) {
            $lastOrder = $product->images()->max('order') ?? 0;
            
            foreach ($request->file('additional_images') as $index => $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'order' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('staff.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * Delete product image
     */
    public function deleteImage(ProductImage $image)
    {
        // Delete file from storage
        Storage::disk('public')->delete($image->image);
        
        // Delete record from database
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}