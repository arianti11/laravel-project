<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display shopping cart
     */
    public function index()
    {
        if (Auth::check()) {
            // Untuk user yang login
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            // Untuk guest (session-based cart)
            $cartItems = collect(session('cart', []));
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $shippingCost = 0; // Bisa dihitung dinamis
        $total = $subtotal + $shippingCost;

        return view('cart.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi. Tersedia: ' . $product->stock);
        }

        if (Auth::check()) {
            // User yang login - simpan ke database
            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cart) {
                // Update quantity jika sudah ada
                $newQuantity = $cart->quantity + $request->quantity;
                
                if ($newQuantity > $product->stock) {
                    return back()->with('error', 'Jumlah melebihi stok tersedia');
                }
                
                $cart->update(['quantity' => $newQuantity]);
            } else {
                // Tambah item baru
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $product->discount_price ?? $product->price
                ]);
            }
        } else {
            // Guest - simpan ke session
            $cart = session('cart', []);
            
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $request->quantity;
            } else {
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->discount_price ?? $product->price,
                    'quantity' => $request->quantity,
                    'image' => $product->image
                ];
            }
            
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cart) {
                $cart->update(['quantity' => $request->quantity]);
            }
        } else {
            $cart = session('cart', []);
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] = $request->quantity;
                session(['cart' => $cart]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate'
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session('cart', []);
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    /**
     * Clear all cart
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }

        return back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Get cart count (for navbar badge)
     */
    public function count()
    {
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            $count = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json(['count' => $count]);
    }
}