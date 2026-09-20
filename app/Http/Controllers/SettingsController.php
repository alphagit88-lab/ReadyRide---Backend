<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    /**
     * Get all global settings.
     * Returns defaults for known keys so no record = empty string, never an error.
     */
    public function index(Request $request)
    {
        $defaults = [
            'conditions' => '',
        ];

        $rows = Setting::pluck('value', 'key')->toArray();

        return response()->json(array_merge($defaults, $rows));
    }

    /**
     * Upsert a setting value (company admin only).
     */
    public function update(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'company') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'key'   => 'required|string|max:100',
            'value' => 'nullable|string',
        ]);

        Setting::updateOrCreate(
            ['key' => $request->key],
            ['value' => $request->value ?? '']
        );

        return response()->json(['message' => 'Setting saved.']);
    }
}
