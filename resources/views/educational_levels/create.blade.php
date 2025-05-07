@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create Educational Level</h1>
    <form action="{{ route('educational_levels.store') }}" method="POST" class="max-w-lg">
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
            <label for="order" class="block text-gray-700">Order</label>
            <input type="number" name="order" id="order" class="w-full border rounded p-2" value="{{ old('order', 0) }}" min="0">
            @error('order')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Educational Level</button>
    </form>
@endsection