<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['property_id', 'room_number', 'price_per_month', 'status'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
