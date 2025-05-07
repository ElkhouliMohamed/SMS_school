@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $schoolClass->name }}</h1>
    <div class="mb-4">
        <strong>Educational Level:</strong> {{ $schoolClass->educationalLevel->name }}
    </div>
    <div class="mb-4">
        <strong>Description:</strong> {{ $schoolClass->description ?? 'N/A' }}
    </div>
    <h2 class="text-xl font-bold mb-2">Teachers</h2>
    @if ($schoolClass->teachers->isEmpty())
        <p>No teachers assigned.</p>
    @else
        <ul class="list-disc pl-5">
            @foreach ($schoolClass->teachers as $teacher)
                <li>{{ $teacher->first_name }} {{ $teacher->last_name }}</li>
            @endforeach
        </ul>
    @endif
    <h2 class="text-xl font-bold mb-2">Students</h2>
    @if ($schoolClass->students->isEmpty())
        <p>No students assigned.</p>
    @else
        <ul class="list-disc pl-5">
            @foreach ($schoolClass->students as $student)
                <li>{{ $student->first_name }} {{ $student->last_name }}</li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('school_classes.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to List</a>
@endsection