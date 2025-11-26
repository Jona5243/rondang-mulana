<?php

namespace App\Http\Controllers;

use App\Models\Item; // Jangan lupa impor Model Item
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman depan (Katalog)
     */
    public function index()
    {
        // Ambil semua barang, urutkan dari yang terbaru
        // 'with' category agar kita bisa tampilkan nama kategorinya
        $items = Item::with('category')->latest()->get();

        return view('landing', [
            'items' => $items
        ]);
    }
}
