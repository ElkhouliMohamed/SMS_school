@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $teacher->first_name }} {{ $teacher->last_name }}</h1>
    <div class="mb-4">
        <strong>Email:</strong> {{ $teacher->email }}
    </div>
    <div class="mb-4">
        <strong>Phone:</strong> {{ $teacher->phone ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <strong>Address:</strong> {{ $teacher->address ?? 'N/A' }}
    </div>
    <h2 class="text-xl font-bold mb-2">Classes</h2>
    @if ($teacher->classes->isEmpty())
        <p>No classes assigned.</p>
    @else
        <ul class="list-disc pl-5">
            @foreach ($teacher->classes as $class)
                <li>{{ $class->name }}</li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('teachers.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to List</a>
@endsection