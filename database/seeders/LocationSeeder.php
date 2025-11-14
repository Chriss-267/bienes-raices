<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $locations = [
            ['location' => 'San Salvador', 'normalized_location' => 'san-salvador'],
            ['location' => 'Santa Tecla', 'normalized_location' => 'santa-tecla'],
            ['location' => 'Soyapango', 'normalized_location' => 'soyapango'],
            ['location' => 'La Libertad', 'normalized_location' => 'la-libertad'],
        ];

        foreach ($locations as $loc) {
            Location::create($loc);
        }
    }
}
