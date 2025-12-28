<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's order history
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display order detail
     */
    public function show(Order $order)
    {
        // Check if order belongs to current user
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdminOrStaff()) {
            abort(403, 'Unauthorized access to this order');
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        // Check if order belongs to current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Can only cancel pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak dapat dibatalkan!');
        }

        $order->cancel();

        return back()->with('success', 'Order berhasil dibatalkan!');
    }
}