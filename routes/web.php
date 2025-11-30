<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NotificationController;
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

    // RUTE KALENDER
    Route::get('/calendar', [AdminRentalController::class, 'calendar'])->name('calendar');

    // Kelola Data
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);

    // Kelola Pesanan
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::put('/rentals/{id}', [AdminRentalController::class, 'update'])->name('rentals.update');

    // Manajemen Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/mark-all', [NotificationController::class, 'markAllRead'])->name('notifications.markAll');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Rute Detail Rental
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/{id}', [AdminRentalController::class, 'show'])->name('rentals.show');
    Route::put('/rentals/{id}', [AdminRentalController::class, 'update'])->name('rentals.update');
    Route::get('/rentals/{id}/print', [AdminRentalController::class, 'print'])->name('rentals.print');
});

require __DIR__ . '/auth.php';
