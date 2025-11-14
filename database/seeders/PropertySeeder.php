<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = PropertyType::all();
        $locations = Location::all();

        foreach (range(1, 30) as $i) {
            Property::create([
                'title' => "Propiedad $i",
                'description' => "Hermosa propiedad número $i con amplios espacios y excelente ubicación.",
                'price' => rand(50000, 300000),
                'property_type_id' => $types->random()->id,
                'location_id' => $locations->random()->id,
                'bedrooms' => rand(1, 5),
                'bathrooms' => rand(1, 3),
                'area' => rand(60, 250) . ' m²',
                'published_at' => now()->toDateString(),
                'image_url' => 'https://via.placeholder.com/400x250',
                'source' => 'https://example.com/property/' . Str::slug("Propiedad $i"),
            ]);
        }
    }
}
