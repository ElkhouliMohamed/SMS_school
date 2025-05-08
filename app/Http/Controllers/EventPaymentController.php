<?php

namespace App\Http\Controllers;

use App\Models\EventPayment;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventPaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Only admin and accountants can manage payments
        $this->middleware('role:admin|accountant')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = EventPayment::with(['registration.event', 'registration.student', 'receiver'])
            ->latest()
            ->paginate(10);

        return view('event_payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $registrationId = $request->query('registration');
        $registration = null;

        if ($registrationId) {
            $registration = EventRegistration::with(['event', 'student'])
                ->findOrFail($registrationId);
        } else {
            // Get all registrations that require payment but haven't paid yet
            $registrations = EventRegistration::with(['event', 'student'])
                ->where('payment_required', true)
                ->where('payment_completed', false)
                ->where('status', '!=', 'cancelled')
                ->get();
        }

        return view('event_payments.create', compact('registration', 'registrations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_registration_id' => 'required|exists:event_registrations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,other',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Check if the registration already has a payment
        $existingPayment = EventPayment::where('event_registration_id', $request->event_registration_id)->first();

        if ($existingPayment) {
            return redirect()->route('event_payments.create', ['registration' => $request->event_registration_id])
                ->with('error', 'Cette inscription a déjà un paiement enregistré.');
        }

        // Generate invoice number
        $invoiceNumber = EventPayment::generateInvoiceNumber();

        // Create the payment
        $payment = EventPayment::create([
            'event_registration_id' => $request->event_registration_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'completed',
            'payment_date' => $request->payment_date,
            'invoice_number' => $invoiceNumber,
            'notes' => $request->notes,
            'received_by' => Auth::id(),
        ]);

        // Update the registration
        $registration = EventRegistration::find($request->event_registration_id);
        $registration->markPaymentCompleted();

        return redirect()->route('event_payments.show', $payment)
            ->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventPayment $eventPayment)
    {
        $eventPayment->load(['registration.event', 'registration.student', 'receiver']);

        return view('event_payments.show', compact('eventPayment'));
    }

    /**
     * Generate an invoice PDF.
     */
    public function generateInvoice(EventPayment $eventPayment)
    {
        $eventPayment->load(['registration.event', 'registration.student', 'receiver']);

        // Here you would generate a PDF invoice
        // For now, we'll just return a view that could be printed

        return view('event_payments.invoice', compact('eventPayment'));
    }
}
