@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Timetable Details</h1>
    <div class="mb-4">
        <strong>Class:</strong> {{ $timetable->schoolClass->name }}
    </div>
    <div class="mb-4">
        <strong>Subject:</strong> {{ $timetable->subject->name }}
    </div>
    <div class="mb-4">
        <strong>Teacher:</strong> {{ $timetable->teacher->first_name }} {{ $timetable->teacher->last_name }}
    </div>
    <div class="mb-4">
        <strong>Day:</strong> {{ $timetable->day }}
    </div>
    <div class="mb-4">
        <strong>Time:</strong> {{ $timetable->start_time->format('H:i') }} - {{ $timetable->end_time->format('H:i') }}
    </div>
    <div class="mb-4">
        <strong>Room:</strong> {{ $timetable->room ?? 'N/A' }}
    </div>
    <a href="{{ route('timetables.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to List</a>
@endsection