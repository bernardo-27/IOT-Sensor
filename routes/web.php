<?php

use Illuminate\Support\Facades\Route;
use App\Models\Sensor;
use App\Http\Controllers\SensorController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     $sensors = Sensor::all();
//     return view('index', compact('sensors'));
// });

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/sensors', function () {
    return view('sensors.index');
})->name('sensors.index');

Route::get('/about', function () {
    return view('about');
})->name('about');
