<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $teachers = Teacher::with('user')->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole('teacher');

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
            ]);

            return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create teacher: ' . $e->getMessage()]);
        }
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'classes']);
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id . '|unique:users,email,' . $teacher->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $teacher->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
            ]);

            $user = $teacher->user;
            $user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            ]);

            return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update teacher: ' . $e->getMessage()]);
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->user->delete(); // Cascade deletes teacher via foreign key
            return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete teacher: ' . $e->getMessage()]);
        }
    }
}
