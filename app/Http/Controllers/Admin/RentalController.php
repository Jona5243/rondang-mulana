<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // 1. Tampilkan Semua Pesanan Masuk
    public function index()
    {
        // Ambil data rental beserta siapa usernya dan barang apa saja
        $rentals = Rental::with(['user', 'items.item'])->latest()->get();

        return view('admin.rentals.index', [
            'rentals' => $rentals
        ]);
    }

    // 2. Ubah Status Pesanan (Approve / Cancel / Complete)
    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled'
        ]);

        $rental->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
