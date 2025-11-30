<?php

namespace App\Http\Controllers;

use App\Models\Item; // Jangan lupa impor Model Item
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman depan (Katalog)
     */
    public function index(Request $request)
    {
        // Mulai query dengan eager loading 'category'
        $query = Item::with('category')->latest();

        // LOGIKA PENCARIAN
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $items = $query->get();

        return view('landing', [
            'items' => $items
        ]);
    }
}
