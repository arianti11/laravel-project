<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua kategori
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Category::query();

        // Search berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $status = $request->status == 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        // Pagination dengan sorting terbaru
        $categories = $query->latest()->paginate(10);

        // Append query string ke pagination links
        $categories->appends($request->all());

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan kategori baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah ada',
            'name.max' => 'Nama kategori maksimal 100 karakter',
            'description.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        // Generate slug otomatis dari nama
        $validated['slug'] = Str::slug($validated['name']);

        // Set default is_active jika tidak ada
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Simpan ke database
        Category::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail kategori (optional)
     */
    public function show(Category $category)
    {
        // Load relasi products
        $category->load('products');
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form edit kategori
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * Update data kategori
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input (kecuali nama yang sama dengan kategori ini)
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah ada',
            'name.max' => 'Nama kategori maksimal 100 karakter',
            'description.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        // Update slug jika nama berubah
        if ($validated['name'] != $category->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Update ke database
        $category->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     * Hapus kategori (soft delete)
     */
    public function destroy(Category $category)
    {
        try {
            // Cek apakah kategori punya produk
            if ($category->products()->count() > 0) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki ' . $category->products()->count() . ' produk!');
            }

            // Soft delete
            $category->delete();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}