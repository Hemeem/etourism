<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model // Mengubah 'reservation' menjadi 'Reservation' (Huruf Kapital)
{   
    use HasFactory;

    protected $table = 'reservations';
    
    protected $fillable = [
        'user_id',
        'package_id',
        'order_id',
        'travel_date', 
        'quantity',   
        'total_price',
        'snap_token',  
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package() 
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}