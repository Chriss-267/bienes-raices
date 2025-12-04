<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/property/{id}', [PropertyController::class, 'show'])->name('property.show');
Route::get('/predicciones', App\Livewire\PricePredictions::class)->name('price_predictions.index');
Route::get('/historicos', [App\Http\Controllers\PriceHistoryController::class, 'index'])->name('price_history.index');
Route::view('/favoritos', 'favorites.index')->name('favorites.index');
