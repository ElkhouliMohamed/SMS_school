@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Timetable Entry</h1>
    <form action="{{ route('timetables.update', $timetable) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="school_class_id" class="block text-gray-700">Class</label>
            <select name="school_class_id" id="school_class_id" class="w-full border rounded p-2">
                <option value="">Select Class</option>
                @foreach ($schoolClasses as $class)
                    <option value="{{ $class->id }}" {{ old('school_class_id', $timetable->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('school_class_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="subject_id" class="block text-gray-700">Subject</label>
            <select name="subject_id" id="subject_id" class="w-full border rounded p-2">
                <option value="">Select Subject</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id', $timetable->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="teacher_id" class="block text-gray-700">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="w-full border rounded p-2">
                <option value="">Select Teacher</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $timetable->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                @endforeach
            </select>
            @error('teacher_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="day" class="block text-gray-700">Day</label>
            <select name="day" id="day" class="w-full border rounded p-2">
                <option value="">Select Day</option>
                @foreach ($days as $day)
                    <option value="{{ $day }}" {{ old('day', $timetable->day) == $day ? 'selected' : '' }}>{{ $day }}</option>
                @endforeach
            </select>
            @error('day')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="start_time" class="block text-gray-700">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="w-full border rounded p-2" value="{{ old('start_time', $timetable->start_time->format('H:i')) }}">
            @error('start_time')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_time" class="block text-gray-700">End Time</label>
            <input type="time" name="end_time" id="end_time" class="w-full border rounded p-2" value="{{ old('end_time', $timetable->end_time->format('H:i')) }}">
            @error('end_time')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="room" class="block text-gray-700">Room (optional)</label>
            <input type="text" name="room" id="room" class="w-full border rounded p-2" value="{{ old('room', $timetable->room) }}">
            @error('room')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Timetable Entry</button>
    </form>
@endsection