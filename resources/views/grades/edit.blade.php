@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Grade</h1>
    <form action="{{ route('grades.update', $grade) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="student_id" class="block text-gray-700">Student</label>
            <select name="student_id" id="student_id" class="w-full border rounded p-2">
                <option value="">Select Student</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id', $grade->student_id) == $student->id ? 'selected' : '' }}>{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
            @error('student_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="subject_id" class="block text-gray-700">Subject</label>
            <select name="subject_id" id="subject_id" class="w-full border rounded p-2">
                <option value="">Select Subject</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id', $grade->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="grade" class="block text-gray-700">Grade (0-20)</label>
            <input type="number" name="grade" id="grade" class="w-full border rounded p-2" value="{{ old('grade', $grade->grade) }}" step="0.01" min="0" max="20">
            @error('grade')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700">Date</label>
            <input type="date" name="date" id="date" class="w-full border rounded p-2" value="{{ old('date', $grade->date) }}">
            @error('date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Grade</button>
    </form>
@endsection