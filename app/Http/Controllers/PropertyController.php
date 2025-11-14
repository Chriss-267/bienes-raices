<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function show($id)
    {
        $property = Property::find($id);

        return view('property.show', compact('property'));
    }
}
