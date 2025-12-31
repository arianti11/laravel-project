<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display staff dashboard
     */
    public function index()
    {
        // Simple statistics
        $stats = [
            'total_products' => Product::count(),
            'low_stock_products' => Product::where('stock', '<', 10)->count(),
            'total_categories' => Category::count(),
        ];

        // Recent products
        $recentProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // Pass data to view
        return view('staff.dashboard', [
            'stats' => $stats,
            'recentProducts' => $recentProducts,
            'lowStockProducts' => $lowStockProducts
        ]);
    }

    /**
     * Products Report (Staff - Limited)
     */
    public function productsReport(Request $request)
    {
        // Low stock products (< 20)
        $lowStockProducts = Product::with('category')
            ->where('stock', '<', 20)
            ->orderBy('stock', 'asc')
            ->get();

        // Products by category
        $productsByCategory = Product::select('category_id', DB::raw('COUNT(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Products by status
        $productsByStatus = Product::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        return view('staff.reports.products', compact(
            'lowStockProducts',
            'productsByCategory',
            'productsByStatus'
        ));
    }

    /**
     * Orders Report (Staff - Limited)
     */
    public function ordersReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Total orders
        $totalOrders = Order::whereBetween('created_at', [$dateFrom, $dateTo])->count();

        // Orders by status
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('status')
            ->get();

        // Recent orders
        $recentOrders = Order::with(['user', 'items'])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('staff.reports.orders', compact(
            'totalOrders',
            'ordersByStatus',
            'recentOrders',
            'dateFrom',
            'dateTo'
        ));
    }
}