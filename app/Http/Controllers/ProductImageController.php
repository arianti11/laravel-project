<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index()
    {
        $images = ProductImage::all();
        return response()->json($images);
    }

    public function show($id)
    {
        $image = ProductImage::findOrFail($id);
        return response()->json($image);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|string',
            'order' => 'integer',
            'caption' => 'nullable|string',
        ]);
        $image = ProductImage::create($validated);
        return response()->json($image, 201);
    }

    public function update(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|string',
            'order' => 'integer',
            'caption' => 'nullable|string',
        ]);
        $image->update($validated);
        return response()->json($image);
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        $image->delete();
        return response()->json(['message' => 'Product image deleted']);
    }
}
