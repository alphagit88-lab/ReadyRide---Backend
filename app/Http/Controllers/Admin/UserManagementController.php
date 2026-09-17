<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users    = $query->with('company')->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $companies = User::where('role', 'company')->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'companies'));
    }

    public function create()
    {
        $companies = User::where('role', 'company')->orderBy('name')->get();
        return view('admin.users.form', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'role'         => ['required', Rule::in(['company', 'driver'])],
            'company_id'   => 'nullable|exists:users,id',
            'start_date'   => 'nullable|date',
            'payment_time' => 'nullable|date_format:H:i',
        ]);

        $data['password'] = Hash::make($data['password']);

        if ($data['role'] !== 'driver') {
            $data['company_id']   = null;
            $data['start_date']   = null;
            $data['payment_time'] = null;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $companies = User::where('role', 'company')->orderBy('name')->get();
        return view('admin.users.form', compact('user', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'     => 'nullable|string|min:6',
            'role'         => ['required', Rule::in(['company', 'driver'])],
            'company_id'   => 'nullable|exists:users,id',
            'start_date'   => 'nullable|date',
            'payment_time' => 'nullable|date_format:H:i',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if ($data['role'] !== 'driver') {
            $data['company_id']   = null;
            $data['start_date']   = null;
            $data['payment_time'] = null;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    /**
     * Return companies list as JSON for live role switching in form.
     */
    public function companiesJson()
    {
        return response()->json(User::where('role', 'company')->orderBy('name')->get(['id', 'name']));
    }
}
