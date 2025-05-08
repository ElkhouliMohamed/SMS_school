<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware(['role:admin|teacher|student|guardian'])->only(['index', 'show', 'calendar']);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('student')) {
            // If the user is a student, show only their class timetables
            $student = Student::where('user_id', $user->id)->first();
            $studentClassId = $student ? $student->school_class_id : 0;
            $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])
                ->where('school_class_id', $studentClassId)
                ->paginate(10);
        } elseif ($user->hasRole('teacher')) {
            // If the user is a teacher, show timetables for classes they teach
            $teacher = Teacher::where('user_id', $user->id)->first();
            if ($teacher) {
                $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])
                    ->where('teacher_id', $teacher->id)
                    ->paginate(10);
            } else {
                $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])->paginate(10);
            }
        } else {
            // For admin or guardian, show all timetables
            $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])->paginate(10);
        }

        return view('timetables.index', compact('timetables'));
    }

    public function create()
    {
        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('timetables.create', compact('schoolClasses', 'subjects', 'teachers', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:255',
        ]);

        // Check for scheduling conflicts
        $conflict = Timetable::where('school_class_id', $validated['school_class_id'])
            ->where('day', $validated['day'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['error' => 'This class is already scheduled at this time.']);
        }

        // Check teacher availability
        $teacherConflict = Timetable::where('teacher_id', $validated['teacher_id'])
            ->where('day', $validated['day'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($teacherConflict) {
            return back()->withErrors(['error' => 'This teacher is already scheduled at this time.']);
        }

        try {
            Timetable::create($validated);
            return redirect()->route('timetables.index')->with('success', 'Timetable entry created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create timetable entry: ' . $e->getMessage()]);
        }
    }

    public function show(Timetable $timetable)
    {
        $timetable->load(['schoolClass', 'subject', 'teacher']);
        return view('timetables.show', compact('timetable'));
    }

    public function edit(Timetable $timetable)
    {
        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('timetables.edit', compact('timetable', 'schoolClasses', 'subjects', 'teachers', 'days'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:255',
        ]);

        // Check for scheduling conflicts (exclude current timetable)
        $conflict = Timetable::where('school_class_id', $validated['school_class_id'])
            ->where('day', $validated['day'])
            ->where('id', '!=', $timetable->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['error' => 'This class is already scheduled at this time.']);
        }

        // Check teacher availability
        $teacherConflict = Timetable::where('teacher_id', $validated['teacher_id'])
            ->where('day', $validated['day'])
            ->where('id', '!=', $timetable->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($teacherConflict) {
            return back()->withErrors(['error' => 'This teacher is already scheduled at this time.']);
        }

        try {
            $timetable->update($validated);
            return redirect()->route('timetables.index')->with('success', 'Timetable entry updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update timetable entry: ' . $e->getMessage()]);
        }
    }

    public function destroy(Timetable $timetable)
    {
        try {
            $timetable->delete();
            return redirect()->route('timetables.index')->with('success', 'Timetable entry deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete timetable entry: ' . $e->getMessage()]);
        }
    }

    public function calendar(Request $request)
    {
        $user = auth()->user();
        $selectedClassId = $request->input('class_id');
        $classes = SchoolClass::all();

        // Get timetables based on user role and selected class
        if ($selectedClassId) {
            $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])
                ->where('school_class_id', $selectedClassId)
                ->get();
        } elseif ($user->hasRole('student')) {
            $student = Student::where('user_id', $user->id)->first();
            $studentClassId = $student ? $student->school_class_id : 0;
            $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])
                ->where('school_class_id', $studentClassId)
                ->get();
            $selectedClassId = $studentClassId;
        } elseif ($user->hasRole('teacher')) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if ($teacher) {
                $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])
                    ->where('teacher_id', $teacher->id)
                    ->get();
            } else {
                $timetables = Timetable::with(['schoolClass', 'subject', 'teacher'])->get();
            }
        } else {
            // For admin or guardian, show all timetables if no class is selected
            $timetables = $selectedClassId
                ? Timetable::with(['schoolClass', 'subject', 'teacher'])->where('school_class_id', $selectedClassId)->get()
                : Timetable::with(['schoolClass', 'subject', 'teacher'])->get();
        }

        // Organize timetables by day and time for the calendar view
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $timeSlots = $this->generateTimeSlots();
        $calendarData = [];

        foreach ($days as $day) {
            $calendarData[$day] = [];
            foreach ($timeSlots as $timeSlot) {
                $calendarData[$day][$timeSlot] = null;
            }
        }

        foreach ($timetables as $timetable) {
            $startTime = $timetable->start_time->format('H:i');
            $endTime = $timetable->end_time->format('H:i');

            // Find the closest time slot
            foreach ($timeSlots as $timeSlot) {
                if ($startTime <= $timeSlot && $endTime > $timeSlot) {
                    $calendarData[$timetable->day][$timeSlot] = $timetable;
                    break;
                }
            }
        }

        return view('timetables.calendar', compact('calendarData', 'days', 'timeSlots', 'classes', 'selectedClassId'));
    }

    private function generateTimeSlots()
    {
        $timeSlots = [];
        $startHour = 8; // 8 AM
        $endHour = 18;  // 6 PM

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $timeSlots[] = sprintf('%02d:00', $hour);
            $timeSlots[] = sprintf('%02d:30', $hour);
        }

        return $timeSlots;
    }
}
