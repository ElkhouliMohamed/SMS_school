@extends('layouts.app')

@section('title', 'Détails de l\'Absence')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Détails de l'Absence</h1>
        <div class="flex space-x-2">
            @hasrole('admin|teacher')
            <a href="{{ route('absences.edit', $absence) }}" class="flex items-center bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier
            </a>
            @endhasrole
            <a href="{{ route('absences.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:w-1/3 bg-red-50 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                <div class="h-24 w-24 rounded-full bg-red-100 flex items-center justify-center text-red-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $absence->date->format('d/m/Y') }}</h2>
                    <p class="text-red-600 font-medium mt-1">Date d'absence</p>

                    @if($absence->start_time && $absence->end_time)
                        <div class="mt-3 bg-red-100 text-red-800 px-3 py-1 rounded-full inline-block">
                            {{ \Carbon\Carbon::parse($absence->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($absence->end_time)->format('H:i') }}
                        </div>
                    @elseif($absence->start_time)
                        <div class="mt-3 bg-red-100 text-red-800 px-3 py-1 rounded-full inline-block">
                            À partir de {{ \Carbon\Carbon::parse($absence->start_time)->format('H:i') }}
                        </div>
                    @else
                        <div class="mt-3 bg-gray-100 text-gray-800 px-3 py-1 rounded-full inline-block">
                            Journée complète
                        </div>
                    @endif
                </div>
            </div>
            <div class="md:w-2/3 p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations de l'Absence</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Élève</p>
                            <p class="text-gray-800">{{ $absence->student->first_name }} {{ $absence->student->last_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Matière</p>
                            <p class="text-gray-800">{{ $absence->subject->name ?? 'Non spécifiée' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Classe</p>
                            <p class="text-gray-800">{{ $absence->student->schoolClass->name ?? 'Non assignée' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Date d'enregistrement</p>
                            <p class="text-gray-800">{{ $absence->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($absence->reason)
                    <h3 class="text-lg font-semibold text-gray-700 mt-6 mb-2">Raison de l'absence</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <p class="text-gray-700">{{ $absence->reason }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @hasrole('admin|teacher')
    <div class="flex justify-end">
        <form action="{{ route('absences.destroy', $absence) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Supprimer cette absence
            </button>
        </form>
    </div>
    @endhasrole
</div>
@endsection
