<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PriceHistoryController extends Controller
{
    public function index()
    {
        // Fetch properties that have price history, eager loading location
        $properties = Property::whereHas('priceHistory')
            ->with(['priceHistory' => function($query) {
                $query->orderBy('date', 'asc');
            }, 'location'])
            ->get();

        // Fetch location statistics
        $locations = \App\Models\Location::withCount('properties')
            ->withAvg('properties', 'price')
            ->get();

        return view('price_history.index', compact('properties', 'locations'));
    }
}
