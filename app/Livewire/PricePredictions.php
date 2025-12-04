<?php

namespace App\Livewire;

use App\Models\Location;
use App\Models\PricePrediction;
use Livewire\Component;
use Livewire\WithPagination;

class PricePredictions extends Component
{
    use WithPagination;

    public $selectedLocation = '';

    public function render()
    {
        $locationsList = Location::all();

        $predictions = PricePrediction::query()
            ->when($this->selectedLocation, function ($query) {
                $query->where('location_id', $this->selectedLocation);
            })
            ->with(['location', 'property'])
            ->orderBy('location_id') // Group by location visually
            ->orderBy('predicted_price') // Order by price (Barata first usually)
            ->get();

        return view('livewire.price-predictions', [
            'locationsList' => $locationsList,
            'predictions' => $predictions,
        ])->extends('layouts.layout')->section('content');
    }

    public function updatedSelectedLocation()
    {
        $this->resetPage();
    }
}
