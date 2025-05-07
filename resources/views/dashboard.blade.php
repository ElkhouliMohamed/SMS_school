@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome to Your Dashboard</h1>
        <p class="text-gray-600 mt-2">Here's an overview of your school management system.</p>
    </div>

    <!-- Role-Specific Content -->
    @if(auth()->user()->hasRole('admin'))
        <!-- Stats Grid for Admins -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Students Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Students</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $student_count }}</p>
                </div>
            </div>

            <!-- Teachers Card with Link -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Teachers</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $teacher_count }}</p>
                    <a href="{{ route('teachers.index') }}" class="text-sm text-green-600 hover:underline">Manage Teachers</a>
                </div>
            </div>

            <!-- Classes Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Classes</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $class_count }}</p>
                </div>
            </div>

            <!-- Subjects Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Subjects</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $subject_count }}</p>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Pending Payments</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $pending_payments }}</p>
                </div>
            </div>

            <!-- Transports Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 8h18M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M6 21h12a1 1 0 001-1v-3H5v3a1 1 0 001 1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Active Transports</h3>
                    <p class="text-2xl font-bold text-indigo-600">{{ $transport_count }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Payments Table for Admins -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Payments</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-gray-600">ID</th>
                            <th class="px-4 py-2 text-left text-gray-600">Student</th>
                            <th class="px-4 py-2 text-left text-gray-600">Amount</th>
                            <th class="px-4 py-2 text-left text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left text-gray-600">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_payments as $payment)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $payment->id }}</td>
                                <td class="px-4 py-2">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</td>
                                <td class="px-4 py-2">{{ $payment->amount }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded-full text-sm {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' }}">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $payment->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @elseif(auth()->user()->hasRole('teacher'))
        <!-- Teacher-Specific Content -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Assigned Classes</h2>
            <p class="text-gray-600">You are currently assigned to <span class="font-bold text-purple-600">{{ $assigned_classes }}</span> class(es).</p>
            @if($assigned_classes > 0)
                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Class Details</h3>
                    <ul class="list-disc pl-5 text-gray-600">
                        @foreach($teacher_classes as $class)
                            <li>{{ $class->name }} ({{ $class->students()->count() }} students)</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

    @elseif(auth()->user()->hasRole('guardian'))
        <!-- Guardian-Specific Content -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Wards</h2>
            <p class="text-gray-600 mb-4">You are responsible for <span class="font-bold text-blue-600">{{ $ward_count }}</span> student(s).</p>
            
            @if($ward_count > 0)
                <div class="space-y-6">
                    @foreach($wards as $ward)
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $ward->first_name }} {{ $ward->last_name }}</h3>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Payment Information -->
                                <div>
                                    <h4 class="text-md font-semibold text-gray-700">Payments</h4>
                                    @if($ward->payments->isEmpty())
                                        <p class="text-gray-600">No payments recorded.</p>
                                    @else
                                        <table class="min-w-full table-auto mt-2">
                                            <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="px-2 py-1 text-left text-gray-600 text-sm">Amount</th>
                                                    <th class="px-2 py-1 text-left text-gray-600 text-sm">Status</th>
                                                    <th class="px-2 py-1 text-left text-gray-600 text-sm">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ward->payments as $payment)
                                                    <tr class="border-b">
                                                        <td class="px-2 py-1 text-sm">{{ $payment->amount }}</td>
                                                        <td class="px-2 py-1 text-sm">
                                                            <span class="px-2 py-1 rounded-full text-xs {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' }}">
                                                                {{ $payment->status }}
                                                            </span>
                                                        </td>
                                                        <td class="px-2 py-1 text-sm">{{ $payment->created_at->format('d M Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                                <!-- Transport Information -->
                                <div>
                                    <h4 class="text-md font-semibold text-gray-700">Transport</h4>
                                    @if($ward->transport)
                                        <p class="text-gray-600">Status: <span class="font-bold {{ $ward->transport->status === 'active' ? 'text-green-600' : 'text-red-600' }}">{{ $ward->transport->status }}</span></p>
                                        <p class="text-gray-600">Route: {{ $ward->transport->route ?? 'N/A' }}</p>
                                    @else
                                        <p class="text-gray-600">No transport assigned.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No wards assigned to you.</p>
            @endif
        </div>

    @else
        <!-- Fallback for Other Roles (e.g., accountant, student) -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Dashboard</h2>
            <p class="text-gray-600">Welcome to the school management system. Your role does not have specific dashboard details configured.</p>
        </div>
    @endif
</div>
@endsection