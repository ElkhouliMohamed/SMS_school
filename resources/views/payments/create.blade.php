@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create Payment</h1>
    <form action="{{ route('payments.store') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="student_id" class="block text-gray-700">Student</label>
            <select name="student_id" id="student_id" class="w-full border rounded p-2">
                <option value="">Select Student</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
            @error('student_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="amount" class="block text-gray-700">Amount ($)</label>
            <input type="number" name="amount" id="amount" class="w-full border rounded p-2" value="{{ old('amount') }}" step="0.01" min="0.01">
            @error('amount')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="payment_date" class="block text-gray-700">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" class="w-full border rounded p-2" value="{{ old('payment_date') }}">
            @error('payment_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status</label>
            <select name="status" id="status" class="w-full border rounded p-2">
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="payment_method" class="block text-gray-700">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="w-full border rounded p-2" value="{{ old('payment_method') }}">
            @error('payment_method')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="notes" class="block text-gray-700">Notes</label>
            <textarea name="notes" id="notes" class="w-full border rounded p-2">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Payment</button>
    </form>
@endsection