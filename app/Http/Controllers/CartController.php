<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Constructor - Middleware untuk proteksi
     */
    public function __construct()
    {
        // Semua method di CartController harus login
        $this->middleware('auth');
    }

    /**
     * Display cart
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $productId)
    {
        // Validasi
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Jumlah produk wajib diisi',
            'quantity.integer' => 'Jumlah harus berupa angka',
            'quantity.min' => 'Jumlah minimal 1',
        ]);

        $product = Product::findOrFail($productId);

        // Cek stok
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi! Tersedia: ' . $product->stock);
        }

        // Cek apakah produk sudah ada di cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;

            // Cek stok lagi
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Tidak bisa menambahkan. Total akan melebihi stok!');
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'subtotal' => $newQuantity * $cartItem->price,
            ]);

            return back()->with('success', 'Jumlah produk di keranjang berhasil diupdate!');
        }

        // Tambah ke cart
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => $request->quantity,
            'price' => $product->discount_price ?? $product->price,
            'subtotal' => $request->quantity * ($product->discount_price ?? $product->price),
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cek stok
        if ($cartItem->product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Tersedia: ' . $cartItem->product->stock
            ], 400);
        }

        // Update
        $cartItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * $cartItem->price,
        ]);

        // Hitung ulang total
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum('subtotal');

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate!',
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'item_subtotal' => number_format($cartItem->subtotal, 0, ',', '.'),
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($cartId)
    {
        $cartItem = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'count' => $count
        ]);
    }
}