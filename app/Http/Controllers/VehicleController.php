<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        return response()->json(Vehicle::where('company_id', auth()->id())->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'license_plate' => 'required|string',
            'driver_id' => 'nullable|exists:users,id',
            'driver_payment_amount' => 'nullable|numeric'
        ]);

        $validated['company_id'] = auth()->id();
        $vehicle = Vehicle::create($validated);

        return response()->json($vehicle, 201);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        if ((int) $vehicle->company_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'license_plate' => 'sometimes|required|string',
            'driver_id' => 'nullable|exists:users,id',
            'driver_payment_amount' => 'nullable|numeric'
        ]);

        $vehicle->update($validated);
        return response()->json($vehicle);
    }
}
