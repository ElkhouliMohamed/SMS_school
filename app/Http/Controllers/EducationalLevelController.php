<?php

namespace App\Http\Controllers;

use App\Models\EducationalLevel;
use Illuminate\Http\Request;

class EducationalLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $levels = EducationalLevel::paginate(10);
        return view('educational_levels.index', compact('levels'));
    }

    public function create()
    {
        return view('educational_levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:educational_levels',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        try {
            EducationalLevel::create($validated);
            return redirect()->route('educational_levels.index')->with('success', 'Educational Level created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create educational level: ' . $e->getMessage()]);
        }
    }

    public function show(EducationalLevel $educationalLevel)
    {
        $educationalLevel->load('schoolClasses');
        return view('educational_levels.show', compact('educationalLevel'));
    }

    public function edit(EducationalLevel $educationalLevel)
    {
        return view('educational_levels.edit', compact('educationalLevel'));
    }

    public function update(Request $request, EducationalLevel $educationalLevel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:educational_levels,name,' . $educationalLevel->id,
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        try {
            $educationalLevel->update($validated);
            return redirect()->route('educational_levels.index')->with('success', 'Educational Level updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update educational level: ' . $e->getMessage()]);
        }
    }

    public function destroy(EducationalLevel $educationalLevel)
    {
        try {
            $educationalLevel->delete();
            return redirect()->route('educational_levels.index')->with('success', 'Educational Level deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete educational level: ' . $e->getMessage()]);
        }
    }
}
