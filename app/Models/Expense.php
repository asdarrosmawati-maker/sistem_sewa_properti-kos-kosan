<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['property_id', 'description', 'amount', 'expense_date'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
