<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin|accountant']);
    }

    public function index()
    {
        $payments = Payment::with('student')->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::all();
        return view('payments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,completed,failed',
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            Payment::create($validated);
            return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create payment: ' . $e->getMessage()]);
        }
    }

    public function show(Payment $payment)
    {
        $payment->load('student');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();
        return view('payments.edit', compact('payment', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,completed,failed',
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            $payment->update($validated);
            return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update payment: ' . $e->getMessage()]);
        }
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete payment: ' . $e->getMessage()]);
        }
    }
}
