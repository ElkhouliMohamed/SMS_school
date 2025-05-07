<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin|teacher']);
    }

    public function index()
    {
        
        $grades = Grade::with(['student', 'subject'])->paginate(10);
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('grades.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:20',
            'date' => 'nullable|date',
        ]);

        try {
            Grade::create($validated);
            return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create grade: ' . $e->getMessage()]);
        }
    }

    public function show(Grade $grade)
    {
        $grade->load(['student', 'subject']);
        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('grades.edit', compact('grade', 'students', 'subjects'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:20',
            'date' => 'nullable|date',
        ]);

        try {
            $grade->update($validated);
            return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update grade: ' . $e->getMessage()]);
        }
    }

    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();
            return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete grade: ' . $e->getMessage()]);
        }
    }
}
