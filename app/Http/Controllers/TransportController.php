<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\Student;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $transports = Transport::paginate(10);
        return view('transports.index', compact('transports'));
    }

    public function create()
    {
        return view('transports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_number' => 'required|string|max:50|unique:transports',
            'driver_name' => 'required|string|max:255',
            'route_description' => 'required|string',
        ]);

        try {
            Transport::create($validated);
            return redirect()->route('transports.index')->with('success', 'Transport created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create transport: ' . $e->getMessage()]);
        }
    }

    public function show(Transport $transport)
    {
        $transport->load('students');
        return view('transports.show', compact('transport'));
    }

    public function edit(Transport $transport)
    {
        return view('transports.edit', compact('transport'));
    }

    public function update(Request $request, Transport $transport)
    {
        $validated = $request->validate([
            'vehicle_number' => 'required|string|max:50|unique:transports,vehicle_number,' . $transport->id,
            'driver_name' => 'required|string|max:255',
            'route_description' => 'required|string',
        ]);

        try {
            $transport->update($validated);
            return redirect()->route('transports.index')->with('success', 'Transport updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update transport: ' . $e->getMessage()]);
        }
    }

    public function destroy(Transport $transport)
    {
        try {
            $transport->delete();
            return redirect()->route('transports.index')->with('success', 'Transport deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete transport: ' . $e->getMessage()]);
        }
    }

    public function assignStudents(Transport $transport)
    {
        $students = Student::all();
        return view('transports.assign-students', compact('transport', 'students'));
    }

    public function storeAssignedStudents(Request $request, Transport $transport)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'start_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $transport->students()->syncWithoutDetaching(
                collect($validated['student_ids'])->mapWithKeys(function ($student_id) use ($validated) {
                    return [$student_id => [
                        'start_date' => $validated['start_date'],
                        'status' => $validated['status'],
                    ]];
                })->toArray()
            );
/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Delete a transport.
     *
     * @param \App\Models\Transport $transport
     * @return \Illuminate\Http\RedirectResponse
     */
/*******  dbb20fab-71c6-4e45-a1c7-9c503c003217  *******/            return redirect()->route('transports.show', $transport)->with('success', 'Students assigned successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to assign students: ' . $e->getMessage()]);
        }
    }
}
