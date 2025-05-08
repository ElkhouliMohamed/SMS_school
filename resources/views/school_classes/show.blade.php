@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $schoolClass->name }}</h1>
        <div class="flex space-x-2">
            @hasrole('admin')
                <a href="{{ route('school_classes.edit', $schoolClass) }}" class="flex items-center bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            @endhasrole
            <a href="{{ route('school_classes.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations de la Classe</h3>
                <div class="border-t pt-3">
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Niveau d'Éducation:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            {{ $schoolClass->educationalLevel->name }}
                        </span>
                    </div>
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Description:</span>
                        <span class="text-gray-800">{{ $schoolClass->description ?? 'Non disponible' }}</span>
                    </div>
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Nombre d'Élèves:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $schoolClass->students->count() }} élèves
                        </span>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Enseignants</h3>
                <div class="border-t pt-3">
                    @if ($schoolClass->teachers->isEmpty())
                        <p class="text-gray-500 italic py-2">Aucun enseignant assigné.</p>
                    @else
                        <div class="space-y-2">
                            @foreach ($schoolClass->teachers as $teacher)
                                <div class="flex items-center py-2 border-b">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        {{ strtoupper(substr($teacher->first_name, 0, 1)) }}
                                    </div>
                                    <div class="ml-3">
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Élèves</h3>
        @if ($schoolClass->students->isEmpty())
            <p class="text-gray-500 italic py-2">Aucun élève assigné à cette classe.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($schoolClass->students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $student->first_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $student->email ?? 'Non disponible' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:text-blue-900">
                                        Voir détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @hasrole('admin')
        <div class="flex justify-end">
            <form action="{{ route('school_classes.destroy', $schoolClass) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer cette classe
                </button>
            </form>
        </div>
    @endhasrole
</div>
@endsection