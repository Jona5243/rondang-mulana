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

    // 3. FITUR KALENDER
    public function calendar(Request $request)
    {
        // Jika request datang dari AJAX (permintaan data oleh FullCalendar)
        if ($request->ajax()) {
            // Ambil semua rental yang statusnya BUKAN 'cancelled'
            $rentals = Rental::where('status', '!=', 'cancelled')
                ->with('user')
                ->get();

            $events = [];

            foreach ($rentals as $rental) {
                // Tentukan warna berdasarkan status
                $color = '#3b82f6'; // Biru (Pending)
                if ($rental->status == 'approved') $color = '#10b981'; // Hijau
                if ($rental->status == 'completed') $color = '#6b7280'; // Abu-abu

                $events[] = [
                    'id' => $rental->id,
                    'title' => '#' . $rental->id . ' - ' . $rental->user->name,
                    'start' => $rental->start_date,
                    // FullCalendar menganggap end date itu eksklusif (tidak termasuk),
                    // jadi kita harus tambah 1 hari agar tampilan visualnya pas.
                    'end'   => date('Y-m-d', strtotime($rental->end_date . ' +1 day')),
                    'color' => $color,
                    'url'   => route('admin.rentals.index'), // Jika diklik lari ke tabel
                ];
            }

            return response()->json($events);
        }

        // Jika request biasa, tampilkan halaman view
        return view('admin.calendar.index');
    }

    // 4. Menampilkan Detail Satu Pesanan
    public function show($id)
    {
        $rental = Rental::with(['user', 'items.item'])->findOrFail($id);
        return view('admin.rentals.show', compact('rental'));
    }

    // 5. Cetak Invoice / Surat Jalan
    public function print($id)
    {
        // Ambil data pesanan
        $rental = Rental::with(['user', 'items.item'])->findOrFail($id);
        
        // Tampilkan view khusus print
        return view('admin.rentals.print', compact('rental'));
    }
}
