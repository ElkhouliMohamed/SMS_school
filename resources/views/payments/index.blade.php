@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Payments</h1>
    @hasrole('admin|accountant')
        <a href="{{ route('payments.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Payment</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Student</th>
                <th class="border p-2">Amount</th>
                <th class="border p-2">Payment Date</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Payment Method</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td class="border p-2">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</td>
                    <td class="border p-2">${{ number_format($payment->amount, 2) }}</td>
                    <td class="border p-2">{{ $payment->payment_date->format('Y-m-d') }}</td>
                    <td class="border p-2">{{ ucfirst($payment->status) }}</td>
                    <td class="border p-2">{{ $payment->payment_method ?? 'N/A' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('payments.show', $payment) }}" class="text-blue-500">View</a>
                        @hasrole('admin|accountant')
                            <a href="{{ route('payments.edit', $payment) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endhasrole
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $payments->links() }}
@endsection