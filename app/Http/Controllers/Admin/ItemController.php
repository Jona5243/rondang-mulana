<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 'with('category')' adalah Eager Loading
        // Ini mencegah query N+1 & membuat loading lebih cepat
        $items = Item::with('category')->get();

        return view('admin.items.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua kategori untuk pilihan dropdown
        $categories = Category::all();

        // Tampilkan form dan kirim data kategori
        return view('admin.items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi (Tambahkan validasi image)
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_day' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
        ]);

        // 2. Siapkan variabel untuk path gambar (default null)
        $imagePath = null;

        // 3. Cek apakah user meng-upload gambar?
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'items' di dalam storage public
            // Hasilnya misal: "items/nama-file-acak.jpg"
            $imagePath = $request->file('image')->store('items', 'public');
        }

        // 4. Simpan ke Database
        Item::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'image' => $imagePath, // Simpan path gambar ke database
        ]);

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil ditambahkan.');
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
        $item = Item::findOrFail($id);
        $categories = Category::all(); // Kita butuh ini untuk dropdown

        return view('admin.items.edit', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_day' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Image opsional saat edit
        ]);

        // Ambil data inputan dasar
        $data = $request->except('image');

        // LOGIKA UPDATE GAMBAR
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            // 2. Upload gambar baru
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        // Update database
        $item->update($data);

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);

        // 1. Hapus gambar dari folder penyimpanan
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        // 2. Hapus data dari database
        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
