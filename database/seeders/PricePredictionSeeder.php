<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricePrediction;
use App\Models\Location;
use App\Models\Property;
use Carbon\Carbon;

class PricePredictionSeeder extends Seeder
{
    public function run()
    {
        // Ensure we have some locations
        if (Location::count() == 0) {
            Location::create(['name' => 'San Salvador']);
            Location::create(['name' => 'Santa Tecla']);
            Location::create(['name' => 'Antiguo Cuscatlán']);
        }
        
        $locations = Location::all();
        $properties = Property::all();

        // Clear existing predictions to avoid confusion during dev
        PricePrediction::truncate();

        foreach ($locations as $location) {
            // Create a "Barata" prediction
            PricePrediction::create([
                'location_id' => $location->id,
                'property_id' => $properties->isNotEmpty() ? $properties->random()->id : null,
                'prediction_date' => Carbon::now(),
                'predicted_price' => rand(50000, 150000) + (rand(0, 99) / 100),
                'model_used' => 'Barata',
            ]);

            // Create a "Cara" prediction
            PricePrediction::create([
                'location_id' => $location->id,
                'property_id' => $properties->isNotEmpty() ? $properties->random()->id : null,
                'prediction_date' => Carbon::now(),
                'predicted_price' => rand(250000, 500000) + (rand(0, 99) / 100),
                'model_used' => 'Cara',
            ]);
        }
    }
}
