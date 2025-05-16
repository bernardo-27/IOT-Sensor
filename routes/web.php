<?php

use Illuminate\Support\Facades\Route;
use App\Models\Sensor;
use App\Http\Controllers\SensorController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/sensors', [SensorController::class, 'index'])->name('sensors.index');
