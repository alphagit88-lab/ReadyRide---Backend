<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\FcmNotificationService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Payment::with(['vehicle', 'driver', 'company']);

        if ($user->role === 'driver') {
            // Driver sees all payments for their assigned vehicle (own + others)
            $vehicle = Vehicle::where('driver_id', $user->id)->first();
            if ($vehicle) {
                $query->where('vehicle_id', $vehicle->id);
            } else {
                return response()->json([]);
            }
        } elseif ($user->role === 'company') {
            $query->where('company_id', $user->id);

            if ($request->filled('vehicle_id')) {
                $query->where('vehicle_id', $request->vehicle_id);
            }
            if ($request->filled('driver_id')) {
                $query->where('driver_id', $request->driver_id);
            }
        } else {
            return response()->json(['message' => 'Unauthorized role'], 403);
        }

        $actualPayments = $query->get();
        $allPayments = collect($actualPayments);

        if ($user->role === 'company') {
            $vehiclesQuery = Vehicle::where('company_id', $user->id)->whereNotNull('driver_id');
            if ($request->filled('vehicle_id')) {
                $vehiclesQuery->where('id', $request->vehicle_id);
            }
            $vehicles = $vehiclesQuery->get();
            
            $driverIds = $vehicles->pluck('driver_id')->toArray();
            if ($request->filled('driver_id')) {
                $driverIds = array_intersect($driverIds, [$request->driver_id]);
            }
            
            $drivers = User::whereIn('id', $driverIds)->whereNotNull('start_date')->get();
            
            $now = \Carbon\Carbon::now();
            $todayDate = $now->toDateString();
            $currentTime = $now->format('H:i:s');
            
            foreach ($drivers as $driver) {
                $vehicle = $vehicles->where('driver_id', $driver->id)->first();
                if (!$vehicle) continue;

                $startDate = \Carbon\Carbon::parse($driver->start_date);
                if ($startDate->isFuture()) continue;
                
                for ($date = $startDate->copy(); $date->lte($now); $date->addDay()) {
                    $dateString = $date->toDateString();
                    
                    if ($dateString === $todayDate) {
                        if (!$driver->payment_time || $currentTime < $driver->payment_time) {
                            continue;
                        }
                    }

                    $hasPayment = $allPayments->where('driver_id', $driver->id)
                                              ->where('vehicle_id', $vehicle->id)
                                              ->where('payment_date', $dateString)
                                              ->isNotEmpty();

                    if (!$hasPayment) {
                        $allPayments->push((object)[
                            'id' => 'past_due_' . $driver->id . '_' . $dateString,
                            'vehicle_id' => $vehicle->id,
                            'driver_id' => $driver->id,
                            'company_id' => $user->id,
                            'payment_date' => $dateString,
                            'amount' => $vehicle->driver_payment_amount,
                            'status' => 'past_due',
                            'created_at' => $date->toDateTimeString(),
                            'vehicle' => $vehicle,
                            'driver' => $driver,
                            'company' => $user,
                        ]);
                    }
                }
            }
        }

        $sortedPayments = $allPayments->sortByDesc(function ($payment) {
            return is_array($payment) 
                ? $payment['payment_date'] . '_' . $payment['created_at']
                : $payment->payment_date . '_' . $payment->created_at;
        })->values();

        return response()->json($sortedPayments);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'driver') {
            return response()->json(['message' => 'Only drivers can make payments.'], 403);
        }

        $request->validate([
            'payment_date' => 'required|date',
            'amount'       => 'required|numeric',
            'slip'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $vehicle = Vehicle::where('driver_id', $user->id)->first();
        if (!$vehicle) {
            return response()->json(['message' => 'You are not assigned to any vehicle.'], 400);
        }

        $slipPath = null;
        if ($request->hasFile('slip')) {
            $slipPath = $request->file('slip')->store('slips', 'public');
        }

        $payment = Payment::create([
            'vehicle_id'   => $vehicle->id,
            'driver_id'    => $user->id,
            'company_id'   => $user->company_id,
            'payment_date' => $request->payment_date,
            'amount'       => $request->amount,
            'slip_path'    => $slipPath,
            'status'       => 'pending',
        ]);

        // Send FCM notification to company
        if ($user->company_id) {
            $company = User::find($user->company_id);
            if ($company) {
                $fcm = new FcmNotificationService();
                $fcm->sendToUser(
                    $company,
                    'New Payment Submitted',
                    "{$user->name} submitted a payment of \${$request->amount} for {$vehicle->license_plate}",
                    [
                        'type'       => 'payment_submitted',
                        'payment_id' => (string) $payment->id,
                        'vehicle_id' => (string) $vehicle->id,
                    ]
                );
            }
        }

        return response()->json($payment->load(['vehicle', 'driver']), 201);
    }

    public function approve(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json(['message' => 'Only companies can approve payments.'], 403);
        }

        $payment = Payment::where('company_id', $user->id)->with('driver')->findOrFail($id);
        
        $payment->status = 'approved';
        $payment->save();

        // Send FCM notification to driver
        if ($payment->driver) {
            $fcm = new FcmNotificationService();
            $fcm->sendToUser(
                $payment->driver,
                'Payment Approved ✓',
                "Your payment of \${$payment->amount} for {$payment->payment_date} has been approved!",
                [
                    'type'       => 'payment_approved',
                    'payment_id' => (string) $payment->id,
                ]
            );
        }

        return response()->json($payment);
    }

    public function todayStatus(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'driver') {
            return response()->json(['message' => 'Only drivers.'], 403);
        }

        $vehicle = Vehicle::where('driver_id', $user->id)->first();
        if (!$vehicle) {
            return response()->json(['is_assigned' => false]);
        }
        
        $today = date('Y-m-d');
        
        $payment = Payment::where('driver_id', $user->id)
            ->where('vehicle_id', $vehicle->id)
            ->whereDate('payment_date', $today)
            ->first();
            
        return response()->json([
            'is_assigned'  => true,
            'vehicle'      => $vehicle,
            'has_paid_today' => $payment ? true : false,
            'payment'      => $payment,
            'amount_due'   => $vehicle->driver_payment_amount,
        ]);
    }
}
