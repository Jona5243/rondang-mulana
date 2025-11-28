<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'address',
    ];

    // Relasi: Rental milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Rental punya banyak Item
    public function items()
    {
        return $this->hasMany(RentalItem::class);
    }
}
