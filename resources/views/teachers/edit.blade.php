@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Teacher</h1>
    <form action="{{ route('teachers.update', $teacher) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="first_name" class="block text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" class="w-full border rounded p-2" value="{{ old('first_name', $teacher->first_name) }}">
            @error('first_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="last_name" class="block text-gray-700">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="w-full border rounded p-2" value="{{ old('last_name', $teacher->last_name) }}">
            @error('last_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full border rounded p-2" value="{{ old('email', $teacher->email) }}">
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700">Phone</label>
            <input type="text" name="phone" id="phone" class="w-full border rounded p-2" value="{{ old('phone', $teacher->phone) }}">
            @error('phone')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="address" class="block text-gray-700">Address</label>
            <input type="text" name="address" id="address" class="w-full border rounded p-2" value="{{ old('address', $teacher->address) }}">
            @error('address')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password" class="w-full border rounded p-2">
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Teacher</button>
    </form>
@endsection