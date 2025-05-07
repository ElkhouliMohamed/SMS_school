@extends('layouts.app')

@section('title', 'Create Teacher')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Create Teacher</h1>
        <p class="text-gray-600 mt-2">Add a new teacher to the system.</p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('teachers.store') }}" method="POST">
            @csrf

            <!-- First Name -->
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 font-semibold mb-2">First Name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('first_name') border-red-500 @enderror" required>
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 font-semibold mb-2">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('last_name') border-red-500 @enderror" required>
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone (Optional)</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-semibold mb-2">Address (Optional)</label>
                <textarea name="address" id="address" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('password_confirmation') border-red-500 @enderror" required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Create Teacher
                </button>
            </div>
        </form>
    </div>

    <!-- Back Link -->
    <div class="mt-6">
        <a href="{{ route('teachers.index') }}" class="text-green-600 hover:underline">Back to Teachers</a>
    </div>
</div>
@endsection