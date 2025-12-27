<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display staff dashboard
     */
    public function index()
    {
        // Total products
        $totalProducts = Product::published()->count();

        // Low stock products (stok <= 10)
        $lowStockProducts = Product::published()
            ->where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->count();

        // Today orders (nanti akan diimplementasi)
        $todayOrders = 0; // Placeholder

        // Pending orders (nanti akan diimplementasi)
        $pendingOrders = 0; // Placeholder

        // Recent products (5 terbaru)
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'todayOrders',
            'pendingOrders',
            'recentProducts'
        ));
    }

    /**
     * Display products report
     */
    public function productsReport()
    {
        // Total products
        $totalProducts = Product::count();
        $publishedProducts = Product::published()->count();
        $draftProducts = Product::where('is_published', false)->count();

        // Products by status
        $readyProducts = Product::where('status', 'ready')->count();
        $preorderProducts = Product::where('status', 'preorder')->count();
        $soldOutProducts = Product::where('status', 'sold_out')->count();

        // Stock statistics
        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->count();

        // Most viewed products
        $mostViewedProducts = Product::with('category')
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        // Products by category
        $productsByCategory = Product::selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function($item) {
                return [
                    'category' => $item->category->name,
                    'total' => $item->total
                ];
            });

        return view('staff.reports.products', compact(
            'totalProducts',
            'publishedProducts',
            'draftProducts',
            'readyProducts',
            'preorderProducts',
            'soldOutProducts',
            'totalStock',
            'lowStockProducts',
            'mostViewedProducts',
            'productsByCategory'
        ));
    }

    /**
     * Display orders report (placeholder)
     */
    public function ordersReport()
    {
        // Placeholder untuk orders report
        // Akan diimplementasi setelah order system dibuat

        return view('staff.reports.orders', [
            'message' => 'Order system belum diimplementasi'
        ]);
    }
}