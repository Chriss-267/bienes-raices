<?php

namespace App\Models;

use App\Models\Location;
use App\Models\PriceHistory;
use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
     use HasFactory;

    protected $fillable = [
        'title', 'description', 'price',
        'property_type_id', 'location_id',
        'bedrooms', 'bathrooms', 'area',
        'published_at', 'image_url', 'source'
    ];

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function priceHistory()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
