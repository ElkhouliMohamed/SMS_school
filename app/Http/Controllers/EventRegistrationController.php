<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('student')) {
            $student = Student::where('user_id', $user->id)->first();
            $registrations = EventRegistration::with(['event', 'payment'])
                ->where('student_id', $student ? $student->id : 0)
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('guardian')) {
            $guardian = \App\Models\Guardian::where('user_id', $user->id)->first();
            $wardIds = $guardian ? $guardian->students->pluck('id')->toArray() : [];

            $registrations = EventRegistration::with(['event', 'payment', 'student'])
                ->whereIn('student_id', $wardIds)
                ->latest()
                ->paginate(10);
        } else {
            // Admin, teacher, accountant
            $registrations = EventRegistration::with(['event', 'payment', 'student'])
                ->latest()
                ->paginate(10);
        }

        return view('event_registrations.index', compact('registrations'));
    }

    /**
     * Register a student for an event.
     */
    public function register(Event $event)
    {
        // Check if the event is full
        if ($event->is_full) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Cet événement est complet.');
        }

        // Get the current student
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Vous devez être un étudiant pour vous inscrire à un événement.');
        }

        // Check if the student is already registered
        $existingRegistration = EventRegistration::where('event_id', $event->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Vous êtes déjà inscrit à cet événement.');
        }

        // Create the registration
        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'student_id' => $student->id,
            'status' => 'registered',
            'payment_required' => $event->requires_payment,
            'payment_completed' => false,
        ]);

        return redirect()->route('events.show', $event)
            ->with('success', 'Vous êtes inscrit à cet événement.');
    }

    /**
     * Cancel a registration.
     */
    public function cancel(EventRegistration $registration)
    {
        // Check if the user is authorized to cancel this registration
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        if (!$user->hasRole('admin') && !$user->hasRole('teacher') &&
            (!$student || $student->id != $registration->student_id)) {
            return redirect()->route('events.show', $registration->event_id)
                ->with('error', 'Vous n\'êtes pas autorisé à annuler cette inscription.');
        }

        // Update the registration status
        $registration->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('events.show', $registration->event_id)
            ->with('success', 'Inscription annulée avec succès.');
    }

    /**
     * Mark a student as attended.
     */
    public function markAttended(EventRegistration $registration)
    {
        // Only admin and teachers can mark attendance
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('teacher')) {
            return redirect()->route('events.show', $registration->event_id)
                ->with('error', 'Vous n\'êtes pas autorisé à marquer la présence.');
        }

        // Update the registration status
        $registration->update([
            'status' => 'attended'
        ]);

        return redirect()->route('events.show', $registration->event_id)
            ->with('success', 'Présence marquée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventRegistration $registration)
    {
        $registration->load(['event', 'student', 'payment']);

        return view('event_registrations.show', compact('registration'));
    }
}
