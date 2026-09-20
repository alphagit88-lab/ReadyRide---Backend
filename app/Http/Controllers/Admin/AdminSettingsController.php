<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $conditions = Setting::where('key', 'conditions')->value('value') ?? '';
        return view('admin.settings', compact('conditions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'key'   => 'required|string|max:100',
            'value' => 'nullable|string',
        ]);

        Setting::updateOrCreate(
            ['key' => $request->key],
            ['value' => $request->value ?? '']
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings saved successfully.');
    }
}
