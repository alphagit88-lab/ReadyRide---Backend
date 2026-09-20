<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverDocumentController extends Controller
{
    public function store(Request $request, $driverId)
    {
        $company = $request->user();

        // Verify this driver belongs to the company
        $driver = User::where('id', $driverId)
            ->where('role', 'driver')
            ->where('company_id', $company->id)
            ->firstOrFail();

        $request->validate([
            'documents' => 'required|array',
            'documents.*.type' => 'required|string',
            'documents.*.file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $saved = [];
        foreach ($request->file('documents') as $index => $doc) {
            $type = $request->input("documents.{$index}.type");
            $path = $doc['file']->store("driver_docs/{$driver->id}", 'public');

            $existingDoc = \App\Models\DriverDocument::where('driver_id', $driver->id)
                ->where('document_type', $type)
                ->first();

            if ($existingDoc) {
                if (Storage::disk('public')->exists($existingDoc->file_path)) {
                    Storage::disk('public')->delete($existingDoc->file_path);
                }
                $existingDoc->update(['file_path' => $path]);
            } else {
                \App\Models\DriverDocument::create([
                    'driver_id' => $driver->id,
                    'document_type' => $type,
                    'file_path' => $path,
                ]);
            }

            $saved[] = ['type' => $type, 'path' => $path];
        }

        return response()->json(['message' => 'Documents uploaded successfully', 'documents' => $saved], 201);
    }
}