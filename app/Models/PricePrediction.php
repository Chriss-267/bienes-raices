<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricePrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'property_id',
        'prediction_date',
        'predicted_price',
        'model_used',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
