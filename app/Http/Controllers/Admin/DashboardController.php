<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Statistics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::customer()->count();
        $totalStaff = User::staff()->count();

        // Recent products
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'totalStaff',
            'recentProducts'
        ));
    }

    /**
     * Display activity logs (placeholder)
     */
    public function activityLogs()
    {
        // TODO: Implement activity logging system
        // For now, return empty view
        
        return view('admin.activity-logs', [
            'message' => 'Activity log system akan diimplementasi'
        ]);
    }

    /**
     * Display sales report (placeholder)
     */
    public function salesReport()
    {
        // TODO: Implement after order system is ready
        
        return view('admin.reports.sales', [
            'message' => 'Sales report akan diimplementasi setelah order system selesai'
        ]);
    }

    /**
     * Display products report
     */
    public function productsReport()
    {
        $totalProducts = Product::count();
        $publishedProducts = Product::published()->count();
        $draftProducts = Product::where('is_published', false)->count();
        
        $productsByCategory = Category::withCount('products')->get();
        
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->with('category')
            ->get();

        return view('admin.reports.products', compact(
            'totalProducts',
            'publishedProducts',
            'draftProducts',
            'productsByCategory',
            'lowStockProducts'
        ));
    }

    /**
     * Display users report
     */
    public function usersReport()
    {
        $totalUsers = User::count();
        $admins = User::admin()->count();
        $staff = User::staff()->count();
        $customers = User::customer()->count();
        $activeUsers = User::active()->count();
        $inactiveUsers = User::where('is_active', false)->count();

        return view('admin.reports.users', compact(
            'totalUsers',
            'admins',
            'staff',
            'customers',
            'activeUsers',
            'inactiveUsers'
        ));
    }

    /**
     * Display activities report (placeholder)
     */
    public function activitiesReport()
    {
        // TODO: Implement after activity log system
        
        return view('admin.reports.activities', [
            'message' => 'Activities report akan diimplementasi'
        ]);
    }

    /**
     * Display settings page (placeholder)
     */
    public function settings()
    {
        // TODO: Implement settings management
        
        return view('admin.settings.index', [
            'message' => 'Settings page akan diimplementasi'
        ]);
    }

    /**
     * Update settings (placeholder)
     */
    public function updateSettings(Request $request)
    {
        // TODO: Implement settings update logic
        
        return back()->with('success', 'Settings berhasil diupdate!');
    }
}