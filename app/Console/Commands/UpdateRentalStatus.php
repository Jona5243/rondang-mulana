<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rental;
use Carbon\Carbon;

class UpdateRentalStatus extends Command
{
    // Nama panggilan robot kita
    protected $signature = 'rental:update-status';

    // Deskripsi tugas robot
    protected $description = 'Otomatis ubah status ke Selesai jika tanggal lewat';

    public function handle()
    {
        // Cari rental yang statusnya 'approved' DAN tanggal selesainya sudah lewat dari hari ini
        $expiredRentals = Rental::where('status', 'approved')
            ->whereDate('end_date', '<', Carbon::now())
            ->get();

        $count = 0;

        foreach ($expiredRentals as $rental) {
            // Ubah jadi completed
            $rental->update(['status' => 'completed']);
            $count++;
        }

        $this->info("Berhasil memperbarui {$count} pesanan menjadi Selesai.");
    }
}
