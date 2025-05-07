@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Timetables</h1>
    @hasrole('admin|teacher')
        <a href="{{ route('timetables.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Timetable Entry</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Class</th>
                <th class="border p-2">Subject</th>
                <th class="border p-2">Teacher</th>
                <th class="border p-2">Day</th>
                <th class="border p-2">Time</th>
                <th class="border p-2">Room</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timetables as $timetable)
                <tr>
                    <td class="border p-2">{{ $timetable->schoolClass->name }}</td>
                    <td class="border p-2">{{ $timetable->subject->name }}</td>
                    <td class="border p-2">{{ $timetable->teacher->first_name }} {{ $timetable->teacher->last_name }}</td>
                    <td class="border p-2">{{ $timetable->day }}</td>
                    <td class="border p-2">{{ $timetable->start_time->format('H:i') }} - {{ $timetable->end_time->format('H:i') }}</td>
                    <td class="border p-2">{{ $timetable->room ?? 'N/A' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('timetables.show', $timetable) }}" class="text-blue-500">View</a>
                        @hasrole('admin|teacher')
                            <a href="{{ route('timetables.edit', $timetable) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('timetables.destroy', $timetable) }}" method="POST" class="inline">
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
    {{ $timetables->links() }}
@endsection