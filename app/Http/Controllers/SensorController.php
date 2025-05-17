<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource via API
     */
    public function index()
    {
  return Sensor::orderBy('created_at','desc')->paginate(50);
    }

    /**
     * Display the sensor dashboard view
     */
    public function dashboard()
    {
        return view('index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'temperature' => 'required|numeric',
            'air_quality' => 'required|integer',
            'light' => 'required|numeric',
            'sound' => 'required|integer',
            'system_on' => 'required|boolean',
            'fault' => 'required|boolean',
        ]);

        $sensor = Sensor::create($fields);

        return response()->json([
            'message' => 'Sensor data received!',
            'data' => $fields,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor $sensor)
    {
        return $sensor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor $sensor)
    {
        $fields = $request->validate([
            'temperature' => 'numeric',
            'air_quality' => 'integer',
            'light' => 'numeric',
            'sound' => 'integer',
            'system_on' => 'boolean',
            'fault' => 'boolean',
        ]);

        $sensor->update($fields);

        return $sensor;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor $sensor)
    {
        $sensor->delete();

        return response()->json(null, 204);
    }
}
