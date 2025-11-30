<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\NewOrderReceived;
use App\Enums\UserRole;

class RentalController extends Controller
{
    // 1. Tampilkan Halaman Checkout (Formulir)
    public function checkout()
    {
        // Cek jika keranjang kosong
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('landing');
        }

        return view('checkout'); // Kita akan buat view ini nanti
    }

    // 2. Proses Simpan Pesanan ke Database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'address' => 'required|string|max:500',
        ]);

        // Ambil keranjang
        $cart = session('cart');
        $totalPrice = 0;

        // Hitung total harga (Harga per hari * Jumlah Barang * Durasi Hari)
        // Untuk sederhananya, kita anggap total di keranjang dikali 1 hari dulu, 
        // atau Anda bisa menambahkan logika hitung hari di sini.
        // Mari kita hitung durasi hari:
        $start = \Carbon\Carbon::parse($request->start_date);
        $end = \Carbon\Carbon::parse($request->end_date);
        $days = $start->diffInDays($end) + 1; // Minimal 1 hari

        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'] * $days;
        }

        // Gunakan DB Transaction agar data aman (semua tersimpan atau tidak sama sekali)
        DB::transaction(function () use ($request, $cart, $totalPrice, $days) {
            // A. Simpan Data Rental Utama
            $rental = Rental::create([
                'user_id' => Auth::id(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'address' => $request->address,
                'total_price' => $totalPrice,
                'status' => 'pending', // Default status menunggu konfirmasi
            ]);

            // B. Simpan Detail Barang (Rental Items)
            foreach ($cart as $id => $details) {
                RentalItem::create([
                    'rental_id' => $rental->id,
                    'item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price_per_day' => $details['price'],
                    'total_price' => $details['price'] * $details['quantity'] * $days,
                ]);
            }
        });

        // 1. Cari Admin (bisa lebih dari 1)
        $admins = User::where('role', UserRole::ADMIN)->get();

        // 2. Kirim Notifikasi ke semua Admin
        // Pastikan variabel $rental tersedia (ambil dari return transaction atau query ulang)
        // Agar aman, kita ambil rental terakhir user ini:
        $latestRental = Rental::where('user_id', Auth::id())->latest()->first();

        foreach ($admins as $admin) {
            $admin->notify(new NewOrderReceived($latestRental));
        }

        // 3. Kosongkan Keranjang
        session()->forget('cart');

        // 4. Redirect ke halaman dashboard user (riwayat)
        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi admin.');
    }
}
