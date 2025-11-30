<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderReceived extends Notification
{
    use Queueable;

    public $rental;

    // Kita terima data Rental saat notifikasi dibuat
    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Simpan ke database
    }

    public function toArray(object $notifiable): array
    {
        // Data yang akan disimpan di kolom 'data' tabel notifications
        return [
            'rental_id' => $this->rental->id,
            'user_name' => $this->rental->user->name,
            'message'   => 'Pesanan baru #' . $this->rental->id . ' dari ' . $this->rental->user->name,
            'type'      => 'new_order', // Penanda jenis notifikasi
            'link'      => route('admin.notifications.read', $this->rental->id) // Link tujuan (nanti kita buat)
        ];
    }
}
