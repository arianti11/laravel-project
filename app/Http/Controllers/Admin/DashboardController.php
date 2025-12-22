<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Hitung total data
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();
        
        // Produk dengan stok rendah (kurang dari 10)
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        
        // Ambil 5 produk terbaru dengan relasi category
        $latestProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();
        
        // Kategori populer (yang punya produk terbanyak)
        $popularCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get();
        
        // Data untuk view
        $data = [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'lowStockProducts' => $lowStockProducts,
            'latestProducts' => $latestProducts,
            'popularCategories' => $popularCategories,
        ];
        
        return view('admin.dashboard', $data);
    }
}