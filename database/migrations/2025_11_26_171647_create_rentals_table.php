<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            // Siapa yang menyewa?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kapan sewanya?
            $table->date('start_date'); // Tanggal mulai
            $table->date('end_date');   // Tanggal selesai

            // Info pembayaran & Status
            $table->decimal('total_price', 15, 2); // Total biaya
            // Status: pending (menunggu konfirmasi), approved (disetujui), completed (selesai/dikembalikan), cancelled (batal)
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled'])->default('pending');

            // Info pengiriman
            $table->text('address')->nullable(); // Alamat pesta

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
