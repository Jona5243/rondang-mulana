<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Statistik
        $totalPendapatan = Rental::where('status', 'completed')->sum('total_price');
        $totalPesanan = Rental::count();
        $pesananPending = Rental::where('status', 'pending')->count();

        // 5 Pesanan Terbaru
        $rentals = Rental::with(['user', 'items.item'])->latest()->take(5)->get();

        return view('admin.dashboard', [
            'rentals' => $rentals,
            'total_pendapatan' => $totalPendapatan,
            'total_pesanan' => $totalPesanan,
            'pesanan_pending' => $pesananPending
        ]);
    }
}
