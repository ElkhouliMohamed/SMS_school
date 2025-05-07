<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $guardians = Guardian::with('user')->paginate(10);
        return view('guardians.index', compact('guardians'));
    }

    public function create()
    {
        return view('guardians.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:guardians,email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole('guardian');

            Guardian::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
            ]);

            return redirect()->route('guardians.index')->with('success', 'Guardian created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create guardian: ' . $e->getMessage()]);
        }
    }

    public function show(Guardian $guardian)
    {
        $guardian->load(['user', 'students']);
        return view('guardians.show', compact('guardian'));
    }

    public function edit(Guardian $guardian)
    {
        return view('guardians.edit', compact('guardian'));
    }

    public function update(Request $request, Guardian $guardian)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:guardians,email,' . $guardian->id . '|unique:users,email,' . $guardian->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $guardian->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
            ]);

            $user = $guardian->user;
            $user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            ]);

            return redirect()->route('guardians.index')->with('success', 'Guardian updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update guardian: ' . $e->getMessage()]);
        }
    }

    public function destroy(Guardian $guardian)
    {
        try {
            $guardian->user->delete(); // Cascade deletes guardian
            return redirect()->route('guardians.index')->with('success', 'Guardian deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete guardian: ' . $e->getMessage()]);
        }
    }
}
