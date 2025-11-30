<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use Illuminate\Support\Facades\Auth;
use App\Models\Rental;

// Halaman Depan
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Grup Auth (User Biasa & Admin bisa akses, tapi nanti difilter)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- 1. RUTE DASHBOARD USER (RIWAYAT PESANAN) ---
    Route::get('/dashboard', function () {
        // PENGAMANAN: Jika Admin nyasar ke sini, lempar ke dashboard admin
        if (Auth::user()->role === \App\Enums\UserRole::ADMIN) {
            return redirect()->route('admin.dashboard');
        }

        // Ambil data pesanan milik user ini
        $rentals = Rental::where('user_id', Auth::id())
                        ->with('items.item') // Load detail barang
                        ->latest()
                        ->get();

        // Arahkan ke folder 'user'
        return view('user.dashboard', ['rentals' => $rentals]);
    })->name('dashboard');

    // Keranjang & Checkout
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');
    Route::get('/checkout', [RentalController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [RentalController::class, 'store'])->name('checkout.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 2. RUTE DASHBOARD ADMIN (PANEL KELOLA) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelola Data
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
    
    // Kelola Pesanan
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::put('/rentals/{id}', [AdminRentalController::class, 'update'])->name('rentals.update');
});

require __DIR__.'/auth.php';