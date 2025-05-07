<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin|teacher'])->except(['index', 'show']);
    }

    public function index()
    {
        $subjects = Subject::with(['schoolClass', 'teacher'])->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $teachers = Teacher::all();
        return view('subjects.create', compact('classes', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        try {
            Subject::create($validated);
            return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create subject: ' . $e->getMessage()]);
        }
    }

    public function show(Subject $subject)
    {
        $subject->load(['schoolClass', 'teacher']);
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $classes = SchoolClass::all();
        $teachers = Teacher::all();
        return view('subjects.edit', compact('subject', 'classes', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        try {
            $subject->update($validated);
            return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update subject: ' . $e->getMessage()]);
        }
    }

    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete subject: ' . $e->getMessage()]);
        }
    }
}
