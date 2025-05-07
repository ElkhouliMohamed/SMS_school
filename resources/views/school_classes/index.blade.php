@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Classes</h1>
    @hasrole('admin')
        <a href="{{ route('school_classes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Class</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Educational Level</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr>
                    <td class="border p-2">{{ $class->name }}</td>
                    <td class="border p-2">{{ $class->educationalLevel->name }}</td>
                    <td class="border p-2">
                        <a href="{{ route('school_classes.show', $class) }}" class="text-blue-500">View</a>
                        @hasrole('admin')
                            <a href="{{ route('school_classes.edit', $class) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('school_classes.destroy', $class) }}" method="POST" class="inline">
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
    {{ $classes->links() }}
@endsection