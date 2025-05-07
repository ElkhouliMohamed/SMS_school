@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Payment Details</h1>
    <div class="mb-4">
        <strong>Student:</strong> {{ $payment->student->first_name }} {{ $payment->student->last_name }}
    </div>
    <div class="mb-4">
        <strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}
    </div>
    <div class="mb-4">
        <strong>Payment Date:</strong> {{ $payment->payment_date->format('Y-m-d') }}
    </div>
    <div class="mb-4">
        <strong>Status:</strong> {{ ucfirst($payment->status) }}
    </div>
    <div class="mb-4">
        <strong>Payment Method:</strong> {{ $payment->payment_method ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <strong>Notes:</strong> {{ $payment->notes ?? 'N/A' }}
    </div>
    <a href="{{ route('payments.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to List</a>
@endsection