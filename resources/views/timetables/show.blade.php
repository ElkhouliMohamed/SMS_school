@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Détails du Cours</h1>
        <div class="flex space-x-2">
            @hasrole('admin|teacher')
                <a href="{{ route('timetables.edit', $timetable) }}" class="flex items-center bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            @endhasrole
            <a href="{{ route('timetables.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
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
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations du Cours</h3>
                <div class="border-t pt-3">
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Classe:</span>
                        <span class="text-gray-800">{{ $timetable->schoolClass->name }}</span>
                    </div>
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Matière:</span>
                        <span class="text-gray-800">{{ $timetable->subject->name }}</span>
                    </div>
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Enseignant:</span>
                        <span class="text-gray-800">{{ $timetable->teacher->first_name }} {{ $timetable->teacher->last_name }}</span>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Horaires</h3>
                <div class="border-t pt-3">
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Jour:</span>
                        <span class="text-gray-800">
                            @php
                                $days = [
                                    'Monday' => 'Lundi',
                                    'Tuesday' => 'Mardi',
                                    'Wednesday' => 'Mercredi',
                                    'Thursday' => 'Jeudi',
                                    'Friday' => 'Vendredi',
                                    'Saturday' => 'Samedi',
                                    'Sunday' => 'Dimanche'
                                ];
                            @endphp
                            {{ $days[$timetable->day] ?? $timetable->day }}
                        </span>
                    </div>
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Horaire:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $timetable->start_time->format('H:i') }} - {{ $timetable->end_time->format('H:i') }}
                        </span>
                    </div>
                    <div class="flex py-2 border-b">
                        <span class="font-medium text-gray-600 w-1/3">Salle:</span>
                        <span class="text-gray-800">{{ $timetable->room ?? 'Non définie' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @hasrole('admin|teacher')
        <div class="flex justify-end">
            <form action="{{ route('timetables.destroy', $timetable) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emploi du temps ?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer ce cours
                </button>
            </form>
        </div>
    @endhasrole
</div>
@endsection