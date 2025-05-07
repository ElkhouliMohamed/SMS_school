@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Grade Details</h1>
    <div class="mb-4">
        <strong>Student:</strong> {{ $grade->student->first_name }} {{ $grade->student->last_name }}
    </div>
    <div class="mb-4">
        <strong>Subject:</strong> {{ $grade->subject->name }}
    </div>
    <div class="mb-4">
        <strong>Grade:</strong> {{ number_format($grade->grade, 2) }}/20
    </div>
    <div class="mb-4">
        <strong>Date:</strong> {{ $grade->date ? $grade->date->format('Y-m-d') : 'N/A' }}
    </div>
    <a href="{{ route('grades.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to List</a>
@endsection