<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan view 'create.blade.php'
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        // 2. Buat data baru
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-') // Otomatis buat slug (misal: "Alat Makan" -> "alat-makan")
        ]);

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 1. Cari kategori yang mau diedit
        $category = Category::findOrFail($id);

        // 2. Tampilkan view 'edit.blade.php' dan kirim data kategori itu
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Cari kategori yang mau di-update
        $category = Category::findOrFail($id);

        // 2. Validasi data
        $request->validate([
            // 'name' harus unik, TAPI boleh sama dengan nama dia sendiri
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        // 3. Update data di database
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-') // Otomatis update slug juga
        ]);

        // 4. Kembali ke index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
