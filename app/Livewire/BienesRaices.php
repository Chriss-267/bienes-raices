<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\PropertyType;
use Livewire\WithPagination;

class BienesRaices extends Component
{

    use WithPagination;

    public $showFilters = false;
    public $price = 0;
    public $minPrice;
    public $maxPrice;

    public $search = '';
    public $type = '';

    protected $queryString = ['search', 'type', 'price'];


    public function mount()
    {
        $this->minPrice = Property::min('price') ?? 0;
        $this->maxPrice = Property::max('price') ?? 1000000;
        $this->price = $this->maxPrice; // valor inicial
    }

    public function updatedPrice()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedType()
    {
        $this->resetPage();
    }
    public function render()
    {
        $query = Property::with(['type', 'location']);

        if ($this->search) {
             $query->where(function ($q) {
            $q->whereHas('location', function ($loc) {
                $loc->where('location', 'like', '%' . $this->search . '%');
            })
            ->orWhere('title', 'like', '%' . $this->search . '%');
        });
        }

        if ($this->type) {
            $query->where('property_type_id', $this->type);
        }

       if ($this->price) {
            $query->where('price', '<=', $this->price);
        }

        $properties = $query->paginate(6);
        $types = PropertyType::all();

        return view('livewire.bienes-raices', [
            'properties' => $properties,
            'types' => $types,
        ]);
    }
}
