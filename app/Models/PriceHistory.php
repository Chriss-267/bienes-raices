<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    protected $table = 'price_history';
    protected $fillable = [
        'property_id',
        'date',
        'price',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
