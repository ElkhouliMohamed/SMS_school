<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Payment;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with role-specific metrics and information.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ensure only authenticated users can access the dashboard
        $this->middleware('auth');

        // Fetch the authenticated user and eager-load relationships
        $user = Auth::user()->load('teacher', 'guardian');

        // Initialize base data with default values
        $data = [
            'student_count'     => 0,
            'teacher_count'     => 0,
            'class_count'       => 0,
            'subject_count'     => 0,
            'pending_payments'  => 0,
            'transport_count'   => 0,
            'recent_payments'   => [],
            'assigned_classes'  => 0,
            'teacher_classes'   => [],
            'ward_count'       => 0,
            'wards'            => [],
        ];

        // Admin-specific data
        if ($user->hasRole('admin')) {
            $data['student_count'] = Student::count();
            $data['teacher_count'] = Teacher::count();
            $data['class_count'] = SchoolClass::count();
            $data['subject_count'] = Subject::count();
            $data['pending_payments'] = Payment::where('status', 'pending')->count();
            $data['transport_count'] = Transport::count();
            $data['recent_payments'] = Payment::with('student')->latest()->take(5)->get();
        }

        // Teacher-specific data
        if ($user->hasRole('teacher') && $user->teacher) {
            $data['assigned_classes'] = $user->teacher->classes()->count();
            $data['teacher_classes'] = $user->teacher->classes()->get();
        }

        // Guardian-specific data
        if ($user->hasRole('guardian') && $user->guardian) {
            $wards = $user->guardian->students()->with(['payments', 'transports'])->get();
            $data['ward_count'] = $wards->count();
            $data['wards'] = $wards;
        }

        return view('dashboard', $data);
    }
}
