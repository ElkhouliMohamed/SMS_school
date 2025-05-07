@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Teachers</h1>
    @hasrole('admin')
        <a href="{{ route('teachers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Teacher</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $teacher)
                <tr>
                    <td class="border p-2">{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                    <td class="border p-2">{{ $teacher->email }}</td>
                    <td class="border p-2">
                        <a href="{{ route('teachers.show', $teacher) }}" class="text-blue-500">View</a>
                        @hasrole('admin')
                            <a href="{{ route('teachers.edit', $teacher) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="inline">
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
    {{ $teachers->links() }}
@endsection