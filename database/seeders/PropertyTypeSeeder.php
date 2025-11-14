<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Casa', 'Apartamento', 'Terreno', 'Local Comercial'];

        foreach ($types as $type) {
            PropertyType::create(['name' => $type]);
        }
    }
}
