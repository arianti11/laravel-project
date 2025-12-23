<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Dashboard untuk user biasa
     */
    public function index()
    {
        $totalProducts = Product::published()->count();
        $totalCategories = Category::active()->count();
        
        // Produk terbaru
        $latestProducts = Product::published()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();
        
        // Kategori
        $categories = Category::active()
            ->withCount('products')
            ->take(6)
            ->get();
        
        return view('user.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'latestProducts',
            'categories'
        ));
    }

    /**
     * Halaman profile user
     */
    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update profile user
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'Profile berhasil diupdate!');
    }
}