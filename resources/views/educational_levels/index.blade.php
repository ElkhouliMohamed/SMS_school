@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Educational Levels</h1>
    @hasrole('admin')
        <a href="{{ route('educational_levels.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Educational Level</a>
    @endhasrole
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Order</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($levels as $level)
                <tr>
                    <td class="border p-2">{{ $level->name }}</td>
                    <td class="border p-2">{{ $level->order }}</td>
                    <td class="border p-2">
                        <a href="{{ route('educational_levels.show', $level) }}" class="text-blue-500">View</a>
                        @hasrole('admin')
                            <a href="{{ route('educational_levels.edit', $level) }}" class="text-blue-500 ml-2">Edit</a>
                            <form action="{{ route('educational_levels.destroy', $level) }}" method="POST" class="inline">
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
    {{ $levels->links() }}
@endsection