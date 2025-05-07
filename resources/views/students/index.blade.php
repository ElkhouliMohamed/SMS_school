@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Students</h1>
    @hasrole('admin')
        <a href="{{ route('students.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Student</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Class</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td class="border p-2">{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td class="border p-2">{{ $student->schoolClass->name }}</td>
                    <td class="border p-2">
                        <a href="{{ route('students.show', $student) }}" class="text-blue-500">View</a>
                        @hasrole('admin')
                            <a href="{{ route('students.edit', $student) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
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
    {{ $students->links() }}
@endsection