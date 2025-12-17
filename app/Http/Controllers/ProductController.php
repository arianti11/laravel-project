<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:products',
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:products',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            // tambahkan validasi lain sesuai kebutuhan
        ]);
        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:products,code,' . $id,
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:products,slug,' . $id,
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            // tambahkan validasi lain sesuai kebutuhan
        ]);
        $product->update($validated);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
