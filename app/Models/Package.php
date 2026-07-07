<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category', 'duration', 'min_pax', 
        'price', 'description', 'image', 'includes', 'excludes', 'itinerary'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'package_id'); 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}