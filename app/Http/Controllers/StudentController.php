<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        
        $this->middleware(['role:admin'])->except(['index', 'show']);
        $this->middleware(['role:admin|guardian'], ['only' => ['show']]);
    }

    public function index()
    {
        $students = Student::with('schoolClass')->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $guardians = Guardian::all();
        return view('students.create', compact('classes', 'guardians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'gender' => 'nullable|string|max:10',
            'marital_status' => 'nullable|string|max:20',
            'nationality' => 'nullable|string',
            'identity_number' => 'nullable|string',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'guardian_address' => 'nullable|string',
            'birth_date' => 'required|date',
            'class_id' => 'required|exists:school_classes,id',
            'guardian_ids' => 'nullable|array',
            'guardian_ids.*' => 'exists:guardians,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole('student');

            $student = Student::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'gender' => $validated['gender'],
                'marital_status' => $validated['marital_status'],
                'nationality' => $validated['nationality'],
                'identity_number' => $validated['identity_number'],
                'guardian_name' => $validated['guardian_name'],
                'guardian_phone' => $validated['guardian_phone'],
                'guardian_address' => $validated['guardian_address'],
                'birth_date' => $validated['birth_date'],
                'class_id' => $validated['class_id'],
            ]);

            if (!empty($validated['guardian_ids'])) {
                $student->guardians()->sync($validated['guardian_ids']);
            }

            return redirect()->route('students.index')->with('success', 'Student created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create student: ' . $e->getMessage()]);
        }
    }

    public function show(Student $student)
    {
        $student->load(['schoolClass', 'guardians']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        $guardians = Guardian::all();
        return view('students.edit', compact('student', 'classes', 'guardians'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'gender' => 'nullable|string|max:10',
            'marital_status' => 'nullable|string|max:20',
            'nationality' => 'nullable|string',
            'identity_number' => 'nullable|string',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'guardian_address' => 'nullable|string',
            'birth_date' => 'required|date',
            'class_id' => 'required|exists:school_classes,id',
            'guardian_ids' => 'nullable|array',
            'guardian_ids.*' => 'exists:guardians,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $student->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'gender' => $validated['gender'],
                'marital_status' => $validated['marital_status'],
                'nationality' => $validated['nationality'],
                'identity_number' => $validated['identity_number'],
                'guardian_name' => $validated['guardian_name'],
                'guardian_phone' => $validated['guardian_phone'],
                'guardian_address' => $validated['guardian_address'],
                'birth_date' => $validated['birth_date'],
                'class_id' => $validated['class_id'],
            ]);

            $user = $student->user;
            $user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            ]);

            $student->guardians()->sync($validated['guardian_ids'] ?? []);

            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update student: ' . $e->getMessage()]);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $student->user->delete(); // Cascade deletes student
            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete student: ' . $e->getMessage()]);
        }
    }
}
