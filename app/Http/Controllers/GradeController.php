<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Guardian;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|teacher|student|guardian');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('student')) {
            // If the user is a student, show only their grades
            $student = Student::where('user_id', $user->id)->first();
            $grades = Grade::with(['student', 'subject'])
                ->where('student_id', $student ? $student->id : 0)
                ->paginate(10);
        } elseif ($user->hasRole('guardian')) {
            // If the user is a guardian, show only their wards' grades
            $guardian = Guardian::where('user_id', $user->id)->first();
            $wardIds = $guardian ? $guardian->students->pluck('id')->toArray() : [];
            $grades = Grade::with(['student', 'subject'])
                ->whereIn('student_id', $wardIds)
                ->paginate(10);
        } elseif ($user->hasRole('teacher')) {
            // If the user is a teacher, show grades for subjects they teach
            $teacher = Teacher::where('user_id', $user->id)->first();
            $teacherSubjectIds = $teacher ? $teacher->subjects->pluck('id')->toArray() : [];
            $grades = Grade::with(['student', 'subject'])
                ->whereIn('subject_id', $teacherSubjectIds)
                ->paginate(10);
        } else {
            // For admin, show all grades
            $grades = Grade::with(['student', 'subject'])->paginate(10);
        }

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
