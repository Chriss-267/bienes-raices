<?php

namespace App\Models;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['location', 'normalized_location'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function pricePredictions()
    {
        return $this->hasMany(PricePrediction::class);
    }
}
