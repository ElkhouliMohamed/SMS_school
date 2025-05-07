<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EducationalLevelController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TransportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('subjects', SubjectController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Resource Routes with Authentication Middleware
Route::middleware('auth')->group(function () {
    // Educational Levels
    Route::resource('educational_levels', EducationalLevelController::class);

    // School Classes
    Route::resource('school_classes', SchoolClassController::class);

    // Teachers
    Route::resource('teachers', TeacherController::class);

    // Students
    Route::resource('students', StudentController::class);

    // Guardians
    Route::resource('guardians', GuardianController::class);

    // Subjects
    Route::resource('subjects', SubjectController::class);

    // Timetables
    Route::resource('timetables', TimetableController::class);

    // Transports
    Route::resource('transports', TransportController::class);

// Assign Students to Transport


Route::resource('transports', TransportController::class)->middleware('role:admin');
Route::get('transports/{transport}/assign-students', [TransportController::class, 'assignStudents'])->name('transports.assign-students');
Route::post('transports/{transport}/assign-students', [TransportController::class, 'storeAssignedStudents'])->name('transports.store-assigned-students');
    // Grades
    Route::resource('grades', GradeController::class);

    // Payments
    Route::resource('payments', PaymentController::class);
});

require __DIR__.'/auth.php';
