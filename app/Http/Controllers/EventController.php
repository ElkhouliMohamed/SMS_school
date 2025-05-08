<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Only admin and teachers can create, update or delete events
        $this->middleware('role:admin|teacher')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('creator')->latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        // Set is_free based on price
        $data['is_free'] = ($request->price == 0);

        $event = Event::create($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Événement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['creator', 'registrations.student']);

        // Check if current user is a student and is registered
        $isRegistered = false;
        $registration = null;

        if (Auth::user()->hasRole('student')) {
            $student = Student::where('user_id', Auth::id())->first();
            if ($student) {
                $registration = $event->registrations()
                    ->where('student_id', $student->id)
                    ->first();
                $isRegistered = (bool) $registration;
            }
        }

        return view('events.show', compact('event', 'isRegistered', 'registration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        // Set is_free based on price
        $data['is_free'] = ($request->price == 0);

        $event->update($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Événement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Événement supprimé avec succès.');
    }

    /**
     * Display events in calendar view.
     */
    public function calendar()
    {
        $events = Event::all();
        return view('events.calendar', compact('events'));
    }

    /**
     * Display events in a simplified calendar view.
     */
    public function simpleCalendar()
    {
        $events = Event::all();

        return view('events.simple_calendar', compact('events'));
    }
}
