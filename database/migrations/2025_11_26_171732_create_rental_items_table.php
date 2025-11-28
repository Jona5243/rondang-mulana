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
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();

            // Terhubung ke transaksi mana?
            $table->foreignId('rental_id')->constrained()->onDelete('cascade');

            // Barang apa yang disewa?
            $table->foreignId('item_id')->constrained()->onDelete('cascade');

            // Detail transaksi
            $table->integer('quantity'); // Jumlah (misal: 50 kursi)
            $table->integer('price_per_day'); // Harga saat transaksi terjadi (untuk arsip jika harga naik nanti)
            $table->integer('total_price'); // (quantity * price * hari)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
