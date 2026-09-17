<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyDriverController extends Controller
{
    public function index(Request $request)
    {
        // Assuming middleware authenticates and sets the user
        $companyId = $request->user()->id;
        
        $drivers = User::where('role', 'driver')
            ->where('company_id', $companyId)
            ->get();
            
        return response()->json($drivers);
    }

    public function store(Request $request)
    {
        $companyId = $request->user()->id;

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6',
            'start_date'   => 'nullable|date',
            'payment_time' => 'nullable|date_format:H:i',
        ]);

        $driver = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'driver',
            'company_id'   => $companyId,
            'start_date'   => $request->start_date,
            'payment_time' => $request->payment_time,
        ]);

        return response()->json($driver, 201);
    }

    public function update(Request $request, $id)
    {
        $companyId = $request->user()->id;

        $driver = User::where('role', 'driver')
            ->where('company_id', $companyId)
            ->findOrFail($id);

        $request->validate([
            'name'         => 'string|max:255',
            'email'        => 'string|email|max:255|unique:users,email,'.$driver->id,
            'password'     => 'nullable|string|min:6',
            'start_date'   => 'nullable|date',
            'payment_time' => 'nullable|date_format:H:i',
        ]);

        if ($request->has('name'))         $driver->name         = $request->name;
        if ($request->has('email'))        $driver->email        = $request->email;
        if ($request->has('password') && $request->password)
            $driver->password = Hash::make($request->password);
        if ($request->has('start_date'))   $driver->start_date   = $request->start_date;
        if ($request->has('payment_time')) $driver->payment_time = $request->payment_time;

        $driver->save();

        return response()->json($driver);
    }

    public function destroy(Request $request, $id)
    {
        $companyId = $request->user()->id;

        $driver = User::where('role', 'driver')
            ->where('company_id', $companyId)
            ->findOrFail($id);

        $driver->delete();

        return response()->json(['message' => 'Driver deleted successfully']);
    }
}
