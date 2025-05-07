<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\EducationalLevel;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin'])->except(['index', 'show']);
    }

    public function index()
    {
        $classes = SchoolClass::with('educationalLevel')->paginate(10);
        return view('school_classes.index', compact('classes'));
    }

    public function create()
    {
        $levels = EducationalLevel::all();
        $teachers = Teacher::all();
        return view('school_classes.create', compact('levels', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'educational_level_id' => 'required|exists:educational_levels,id',
            'description' => 'nullable|string',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        try {
            $class = SchoolClass::create($validated);
            if (!empty($validated['teacher_ids'])) {
                $class->teachers()->sync($validated['teacher_ids']);
            }
            return redirect()->route('school_classes.index')->with('success', 'Class created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create class: ' . $e->getMessage()]);
        }
    }

    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->load(['educationalLevel', 'teachers', 'students']);
        return view('school_classes.show', compact('schoolClass'));
    }

    public function edit(SchoolClass $schoolClass)
    {
        $levels = EducationalLevel::all();
        $teachers = Teacher::all();
        return view('school_classes.edit', compact('schoolClass', 'levels', 'teachers'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'educational_level_id' => 'required|exists:educational_levels,id',
            'description' => 'nullable|string',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        try {
            $schoolClass->update($validated);
            $schoolClass->teachers()->sync($validated['teacher_ids'] ?? []);
            return redirect()->route('school_classes.index')->with('success', 'Class updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update class: ' . $e->getMessage()]);
        }
    }

    public function destroy(SchoolClass $schoolClass)
    {
        try {
            $schoolClass->delete();
            return redirect()->route('school_classes.index')->with('success', 'Class deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete class: ' . $e->getMessage()]);
        }
    }
}
