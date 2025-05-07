@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Grades</h1>
    @hasrole('admin|teacher')
        <a href="{{ route('grades.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Grade</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Student</th>
                <th class="border p-2">Subject</th>
                <th class="border p-2">Grade (/20)</th>
                <th class="border p-2">Date</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr>
                    <td class="border p-2">{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                    <td class="border p-2">{{ $grade->subject->name }}</td>
                    <td class="border p-2">{{ number_format($grade->grade, 2) }}/20</td>
                    <td class="border p-2">{{ $grade->date ? $grade->date->format('Y-m-d') : 'N/A' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('grades.show', $grade) }}" class="text-blue-500">View</a>
                        @hasrole('admin|teacher')
                            <a href="{{ route('grades.edit', $grade) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="inline">
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
    {{ $grades->links() }}
@endsection