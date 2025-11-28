<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'item_id',
        'quantity',
        'price_per_day',
        'total_price',
    ];

    // Relasi ke Barang
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
