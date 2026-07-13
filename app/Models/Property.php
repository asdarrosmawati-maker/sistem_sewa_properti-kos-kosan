<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
