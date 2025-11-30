<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications;

        return view('admin.notifications.index', compact('notifications'));
    }

    // Method untuk menangani KLIK notifikasi
    public function read($id)
    {
        // 1. Cari notifikasi berdasarkan ID
        $notification = Auth::user()->notifications()->findOrFail($id);

        // 2. Tandai sebagai sudah dibaca
        $notification->markAsRead();

        // 3. Cek Tipe Notifikasi (Smart Redirect)
        if (isset($notification->data['type']) && $notification->data['type'] == 'new_order') {
            // Jika pesanan baru, arahkan ke halaman detail khusus
            return redirect()->route('admin.rentals.show', $notification->data['rental_id']);
        }

        // Jika tipe lain (misal stok menipis), kembali ke index notifikasi
        return redirect()->route('admin.notifications.index');
    }

    // 1. Tandai SEMUA sebagai sudah dibaca
    public function markAllRead()
    {
        \Illuminate\Support\Facades\Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca.');
    }

    // 2. Hapus SEMUA notifikasi (Bersih-bersih)
    public function deleteAll()
    {
        \Illuminate\Support\Facades\Auth::user()->notifications()->delete();
        return redirect()->back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    // 3. Hapus SATU notifikasi saja
    public function destroy($id)
    {
        $notification = \Illuminate\Support\Facades\Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return redirect()->back()->with('success', 'Notifikasi dihapus.');
    }
}
