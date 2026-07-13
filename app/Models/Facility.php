<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['property_id', 'name', 'icon', 'description'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
