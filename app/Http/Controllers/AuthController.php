<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use App\Models\Vehicle;

class AuthController extends Controller
{
    /**
     * Normal Register (Companies only)
     */
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->company_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company',
            'api_token' => Str::random(60),
        ]);

        return response()->json([
            'message' => 'Registration successful.',
            'token' => $user->api_token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    /**
     * Normal Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        // Driver assignment check
        $vehicle = null;
        if ($user->role === 'driver') {
            $vehicle = Vehicle::where('driver_id', $user->id)->first();
            if (!$vehicle) {
                return response()->json(['message' => 'You have not been assigned to any vehicle.'], 403);
            }
        }

        if (!$user->api_token) {
            $user->api_token = Str::random(60);
            $user->save();
        }

        return response()->json([
            'message' => 'Login successful.',
            'token' => $user->api_token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'vehicle' => $vehicle ? ['id' => $vehicle->id, 'name' => $vehicle->name, 'license_plate' => $vehicle->license_plate, 'driver_payment_amount' => $vehicle->driver_payment_amount] : null,
            ],
        ]);
    }

    /**
     * Verify Google ID token and login/create user.
     * Expects: { "id_token": "..." }
     */
    public function googleLogin(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $idToken = $request->input('id_token');

        // Verify the token with Google's tokeninfo endpoint
        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $idToken,
        ]);

        if (!$response->ok()) {
            return response()->json([
                'message' => 'Invalid Google token.',
            ], 401);
        }

        $googleUser = $response->json();

        // Validate the audience (must match your web client ID)
        $expectedClientId = config('services.google.client_id');
        if (($googleUser['aud'] ?? '') !== $expectedClientId) {
            return response()->json([
                'message' => 'Token audience mismatch.',
            ], 401);
        }

        $googleId = $googleUser['sub'];
        $email = $googleUser['email'] ?? null;
        $name = $googleUser['name'] ?? ($googleUser['given_name'] ?? 'Google User');
        $avatar = $googleUser['picture'] ?? null;

        // Find or create user by google_id or email
        $user = User::where('google_id', $googleId)->first();

        if (!$user && $email) {
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            // Create new user, google login is ONLY for companies
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'avatar' => $avatar,
                'password' => bcrypt(Str::random(32)), // random password, not used
                'role' => 'company',
            ]);
        } else {
            // Ensure they are logging in as company (or if admin, let them through?)
            if ($user->role === 'driver') {
                return response()->json(['message' => 'Drivers cannot login via Google.'], 403);
            }

            // Update google_id and avatar if missing
            $user->update([
                'google_id' => $googleId,
                'avatar' => $avatar ?? $user->avatar,
            ]);
        }

        // Generate or reuse API token
        if (!$user->api_token) {
            $user->api_token = Str::random(60);
            $user->save();
        }

        return response()->json([
            'message' => 'Login successful.',
            'token' => $user->api_token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $user->role,
            ],
        ]);
    }
}
