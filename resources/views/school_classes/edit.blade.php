@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Class</h1>
    <form action="{{ route('school_classes.update', $schoolClass) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded p-2" value="{{ old('name', $schoolClass->name) }}">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="educational_level_id" class="block text-gray-700">Educational Level</label>
            <select name="educational_level_id" id="educational_level_id" class="w-full border rounded p-2">
                <option value="">Select Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}" {{ old('educational_level_id', $schoolClass->educational_level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                @endforeach
            </select>
            @error('educational_level_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea name="description" id="description" class="w-full border rounded p-2">{{ old('description', $schoolClass->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="teacher_ids" class="block text-gray-700">Teachers</label>
            <select name="teacher_ids[]" id="teacher_ids" class="w-full border rounded p-2" multiple>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $schoolClass->teachers->contains($teacher->id) ? 'selected' : '' }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                @endforeach
            </select>
            @error('teacher_ids')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Class</button>
    </form>
@endsection