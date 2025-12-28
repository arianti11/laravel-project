<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\ActivityLogger;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Statistics Cards
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'monthly_revenue' => Order::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
            
            'low_stock_products' => Product::where('stock', '<', 10)->count(),
            'out_of_stock' => Product::where('stock', 0)->count()
        ];

        // Recent Orders
        $recentOrders = Order::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top Selling Products
        $topProducts = OrderItem::select('product_id', 'product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Monthly Sales Chart Data (Last 6 months)
        $monthlySales = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Recent Activity Logs
        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Low Stock Products
        $lowStockProducts = Product::with('category')
            ->where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'monthlySales',
            'recentActivities',
            'lowStockProducts'
        ));
    }

    /**
     * Activity Logs Page
     */
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter by model
        if ($request->has('model') && $request->model != '') {
            $query->where('model', $request->model);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);
        $users = User::adminOrStaff()->get();

        return view('admin.activity-logs', compact('logs', 'users'));
    }

    /**
     * Sales Report
     */
    public function salesReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Total Sales
        $totalSales = Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('payment_status', 'paid')
            ->sum('total');

        // Total Orders
        $totalOrders = Order::whereBetween('created_at', [$dateFrom, $dateTo])->count();

        // Orders by Status
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('status')
            ->get();

        // Sales by Payment Method
        $salesByPayment = Order::select('payment_method', DB::raw('SUM(total) as total_sales'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('payment_status', 'paid')
            ->groupBy('payment_method')
            ->get();

        // Daily Sales
        $dailySales = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_sales')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.reports.sales', compact(
            'totalSales',
            'totalOrders',
            'ordersByStatus',
            'salesByPayment',
            'dailySales',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Products Report
     */
    public function productsReport(Request $request)
    {
        // Top Selling Products
        $topProducts = OrderItem::select(
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->get();

        // Products by Category
        $productsByCategory = Product::select('category_id', DB::raw('COUNT(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Low Stock Products
        $lowStockProducts = Product::with('category')
            ->where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->get();

        // Products by Status
        $productsByStatus = Product::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.reports.products', compact(
            'topProducts',
            'productsByCategory',
            'lowStockProducts',
            'productsByStatus'
        ));
    }

    /**
     * Users Report
     */
    public function usersReport(Request $request)
    {
        // Users by Role
        $usersByRole = User::select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->get();

        // New Users (Last 30 days)
        $newUsers = User::where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();

        // Active Users
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        // Top Customers (by total spending)
        $topCustomers = Order::select('user_id', DB::raw('SUM(total) as total_spent'))
            ->where('payment_status', 'paid')
            ->groupBy('user_id')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->with('user')
            ->get();

        return view('admin.reports.users', compact(
            'usersByRole',
            'newUsers',
            'activeUsers',
            'inactiveUsers',
            'topCustomers'
        ));
    }

    /**
     * Activities Report
     */
    public function activitiesReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Activities by Type
        $activitiesByType = ActivityLog::select('type', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('type')
            ->get();

        // Activities by User
        $activitiesByUser = ActivityLog::select('user_id', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->with('user')
            ->get();

        // Recent Activities
        $recentActivities = ActivityLog::with('user')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('admin.reports.activities', compact(
            'activitiesByType',
            'activitiesByUser',
            'recentActivities',
            'dateFrom',
            'dateTo'
        ));
    }
}