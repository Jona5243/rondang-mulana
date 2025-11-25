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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // Menghubungkan ke tabel categories
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->string('name'); // Nama barang
            $table->text('description')->nullable(); // Deskripsi (boleh kosong)
            $table->integer('price_per_day'); // Harga sewa per hari
            $table->integer('stock'); // Stok barang
            $table->string('image')->nullable(); // Lokasi foto (boleh kosong)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
