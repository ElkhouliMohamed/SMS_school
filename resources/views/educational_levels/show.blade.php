@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $educationalLevel->name }}</h1>
    <div class="mb-4">
        <strong>Description:</strong> {{ $educationalLevel->description ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <strong>Order:</strong> {{ $educationalLevel->order }}
    </div>
    <h2 class="text-xl font-bold mb-2">Classes</h2>
    @if ($educationalLevel->schoolClasses->isEmpty())
        <p>No classes assigned.</p>
    @else
        <ul class="list-disc pl-5">
            @foreach ($educationalLevel->schoolClasses as $class)
                <li>{{ $class->name }}</li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('educational_levels.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to List</a>
@endsection