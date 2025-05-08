<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPaymentController;
use App\Http\Controllers\EventRegistrationController;
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
    Route::get('timetables-calendar', [TimetableController::class, 'calendar'])->name('timetables.calendar');

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

    // Absences
    Route::resource('absences', AbsenceController::class);

    // Events
    Route::resource('events', EventController::class);
    Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('events-simple-calendar', [EventController::class, 'simpleCalendar'])->name('events.simple_calendar');

    // Event Registrations
    Route::get('event-registrations', [EventRegistrationController::class, 'index'])->name('event_registrations.index');
    Route::get('event-registrations/{registration}', [EventRegistrationController::class, 'show'])->name('event_registrations.show');
    Route::post('events/{event}/register', [EventRegistrationController::class, 'register'])->name('events.register');
    Route::post('event-registrations/{registration}/cancel', [EventRegistrationController::class, 'cancel'])->name('event_registrations.cancel');
    Route::post('event-registrations/{registration}/mark-attended', [EventRegistrationController::class, 'markAttended'])->name('event_registrations.mark_attended');

    // Event Payments
    Route::resource('event_payments', EventPaymentController::class)->except(['edit', 'update', 'destroy']);
    Route::get('event_payments/{eventPayment}/invoice', [EventPaymentController::class, 'generateInvoice'])->name('event_payments.invoice');
});

require __DIR__.'/auth.php';
