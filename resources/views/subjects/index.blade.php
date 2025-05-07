@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Subjects</h1>
    @hasrole('admin|teacher')
        <a href="{{ route('subjects.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Subject</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Class</th>
                <th class="border p-2">Teacher</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td class="border p-2">{{ $subject->name }}</td>
                    <td class="border p-2">{{ $subject->schoolClass->name }}</td>
                    <td class="border p-2">{{ $subject->teacher->first_name }} {{ $subject->teacher->last_name }}</td>
                    <td class="border p-2">
                        <a href="{{ route('subjects.show', $subject) }}" class="text-blue-500">View</a>
                        @hasrole('admin|teacher')
                            <a href="{{ route('subjects.edit', $subject) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endhasrole
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $subjects->links() }}
@endsection