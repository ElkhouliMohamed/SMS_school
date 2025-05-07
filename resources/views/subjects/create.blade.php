@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create Subject</h1>
    <form action="{{ route('subjects.store') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded p-2" value="{{ old('name') }}">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea name="description" id="description" class="w-full border rounded p-2">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="class_id" class="block text-gray-700">Class</label>
            <select name="class_id" id="class_id" class="w-full border rounded p-2">
                <option value="">Select Class</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="teacher_id" class="block text-gray-700">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="w-full border rounded p-2">
                <option value="">Select Teacher</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                @endforeach
            </select>
            @error('teacher_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Subject</button>
    </form>
@endsection