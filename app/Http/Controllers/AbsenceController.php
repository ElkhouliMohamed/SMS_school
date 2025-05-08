<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Guardian;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|teacher|student|guardian');
        // Only admin and teachers can create, update or delete absences
        $this->middleware('role:admin|teacher')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $studentId = $request->query('student');
        $classId = $request->query('class');
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        // Get classes for filter dropdown
        $classes = [];

        if ($user->hasRole('student')) {
            // If the user is a student, show only their absences
            $student = Student::where('user_id', $user->id)->first();
            $query = Absence::with(['student.schoolClass', 'subject'])
                ->where('student_id', $student ? $student->id : 0);
        } elseif ($user->hasRole('guardian')) {
            // If the user is a guardian, show only their wards' absences
            $guardian = Guardian::where('user_id', $user->id)->first();
            $wardIds = $guardian ? $guardian->students->pluck('id')->toArray() : [];

            // Get classes of guardian's students for filter
            if ($guardian) {
                $classes = SchoolClass::whereIn('id', $guardian->students->pluck('class_id')->filter()->unique())->get();
            }

            if ($studentId && $guardian) {
                // Check if the requested student belongs to this guardian
                if (in_array($studentId, $wardIds)) {
                    $query = Absence::with(['student.schoolClass', 'subject'])
                        ->where('student_id', $studentId);
                } else {
                    // If student doesn't belong to this guardian, show no results
                    $query = Absence::where('id', 0);
                }
            } else {
                // Show all wards' absences
                $query = Absence::with(['student.schoolClass', 'subject'])
                    ->whereIn('student_id', $wardIds);

                // Filter by class if specified
                if ($classId) {
                    $studentsInClass = Student::where('class_id', $classId)->whereIn('id', $wardIds)->pluck('id');
                    $query->whereIn('student_id', $studentsInClass);
                }
            }
        } elseif ($user->hasRole('teacher')) {
            // If the user is a teacher, show absences for subjects they teach
            $teacher = Teacher::where('user_id', $user->id)->first();
            $teacherSubjectIds = $teacher ? $teacher->subjects->pluck('id')->toArray() : [];

            // Get classes taught by this teacher for filter
            if ($teacher) {
                $classes = SchoolClass::whereHas('subjects', function($query) use ($teacher) {
                    $query->whereIn('id', $teacher->subjects->pluck('id'));
                })->get();
            }

            $query = Absence::with(['student.schoolClass', 'subject'])
                ->whereIn('subject_id', $teacherSubjectIds);

            if ($studentId) {
                $query->where('student_id', $studentId);
            }

            // Filter by class if specified
            if ($classId) {
                $studentsInClass = Student::where('class_id', $classId)->pluck('id');
                $query->whereIn('student_id', $studentsInClass);
            }
        } else {
            // For admin, show all absences with filters
            $query = Absence::with(['student.schoolClass', 'subject']);

            // Get all classes for admin filter
            $classes = SchoolClass::orderBy('name')->get();

            if ($studentId) {
                $query->where('student_id', $studentId);
            }

            // Filter by class if specified
            if ($classId) {
                $studentsInClass = Student::where('class_id', $classId)->pluck('id');
                $query->whereIn('student_id', $studentsInClass);
            }
        }

        // Apply date range filters if specified
        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        // Get the final paginated results
        $absences = $query->latest()->paginate(10)->appends($request->query());

        return view('absences.index', compact('absences', 'classes', 'classId', 'fromDate', 'toDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Récupérer les filtres
        $search = $request->query('search');
        $classId = $request->query('class_id');
        $subjectId = $request->query('subject_id');
        $dateFilter = $request->query('date_filter');

        // Récupérer toutes les classes pour le filtre
        $classes = SchoolClass::orderBy('name')->get();

        // Filtrer les étudiants
        $studentsQuery = Student::with(['schoolClass', 'grades'])
            ->orderBy('last_name')
            ->orderBy('first_name');

        if ($search) {
            $studentsQuery->where(function($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($classId) {
            $studentsQuery->where('class_id', $classId);
        }

        $students = $studentsQuery->get();

        // Récupérer les matières
        $subjects = Subject::orderBy('name')->get();

        // Récupérer les matières filtrées par classe si une classe est sélectionnée
        $filteredSubjects = $subjects;
        if ($classId) {
            $filteredSubjects = Subject::where('class_id', $classId)->orderBy('name')->get();
            if ($filteredSubjects->isEmpty()) {
                $filteredSubjects = $subjects;
            }
        }

        // Récupérer les absences récentes pour référence
        $recentAbsences = Absence::with(['student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('absences.create', compact(
            'students',
            'subjects',
            'filteredSubjects',
            'classes',
            'search',
            'classId',
            'subjectId',
            'dateFilter',
            'recentAbsences'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'reason' => 'nullable|string|max:255',
        ]);

        Absence::create($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absence enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absence $absence)
    {
        return view('absences.show', compact('absence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Absence $absence)
    {
        // Récupérer les filtres
        $search = $request->query('search');
        $classId = $request->query('class_id');

        // Récupérer toutes les classes pour le filtre
        $classes = SchoolClass::orderBy('name')->get();

        // Filtrer les étudiants
        $studentsQuery = Student::with('schoolClass')
            ->orderBy('last_name')
            ->orderBy('first_name');

        if ($search) {
            $studentsQuery->where(function($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($classId) {
            $studentsQuery->where('class_id', $classId);
        }

        $students = $studentsQuery->get();

        // Récupérer les matières
        $subjects = Subject::orderBy('name')->get();

        return view('absences.edit', compact('absence', 'students', 'subjects', 'classes', 'search', 'classId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'reason' => 'nullable|string|max:255',
        ]);

        $absence->update($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absence mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absence $absence)
    {
        $absence->delete();

        return redirect()->route('absences.index')
            ->with('success', 'Absence supprimée avec succès.');
    }
}
