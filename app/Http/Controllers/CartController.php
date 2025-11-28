<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. Menampilkan isi keranjang
    public function index()
    {
        return view('cart'); // Nanti kita buat view ini
    }

    // 2. Menambahkan barang ke keranjang
    public function addToCart($id)
    {
        $item = Item::findOrFail($id);

        // Ambil data keranjang dari session (jika ada)
        $cart = session()->get('cart', []);

        // Jika barang sudah ada di keranjang, tambah jumlahnya
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, masukkan data barang baru
            $cart[$id] = [
                "name" => $item->name,
                "quantity" => 1,
                "price" => $item->price_per_day,
                "image" => $item->image
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Barang berhasil masuk keranjang!');
    }

    // 3. Menghapus barang dari keranjang
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Barang dihapus dari keranjang.');
        }
    }
}
