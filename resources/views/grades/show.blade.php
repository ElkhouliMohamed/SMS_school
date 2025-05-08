@extends('layouts.app')

@section('title', 'Détails de la Note')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Détails de la Note</h1>
        <div class="flex space-x-2">
            @hasrole('admin|teacher')
                <a href="{{ route('grades.edit', $grade) }}" class="flex items-center bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            @endhasrole
            <a href="{{ route('grades.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:w-1/3 bg-green-50 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                @php
                    $gradeValue = number_format($grade->grade, 2);
                    $gradeColor = $gradeValue >= 14 ? 'text-green-600' :
                                ($gradeValue >= 10 ? 'text-blue-600' :
                                ($gradeValue >= 8 ? 'text-yellow-600' : 'text-red-600'));
                    $gradeBgColor = $gradeValue >= 14 ? 'bg-green-100' :
                                ($gradeValue >= 10 ? 'bg-blue-100' :
                                ($gradeValue >= 8 ? 'bg-yellow-100' : 'bg-red-100'));
                @endphp
                <div class="h-24 w-24 rounded-full {{ $gradeBgColor }} flex items-center justify-center {{ $gradeColor }} mb-4">
                    <span class="text-3xl font-bold">{{ $gradeValue }}</span>
                </div>
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $gradeValue }}/20</h2>
                    <p class="{{ $gradeColor }} font-medium mt-1">
                        @if($gradeValue >= 16)
                            Très bien
                        @elseif($gradeValue >= 14)
                            Bien
                        @elseif($gradeValue >= 12)
                            Assez bien
                        @elseif($gradeValue >= 10)
                            Passable
                        @elseif($gradeValue >= 8)
                            Insuffisant
                        @else
                            Très insuffisant
                        @endif
                    </p>
                </div>
            </div>
            <div class="md:w-2/3 p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations de la Note</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Élève</p>
                            <p class="text-gray-800">{{ $grade->student->first_name }} {{ $grade->student->last_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Matière</p>
                            <p class="text-gray-800">{{ $grade->subject->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Classe</p>
                            <p class="text-gray-800">{{ $grade->student->schoolClass->name ?? 'Non assignée' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="text-gray-800">{{ $grade->date ? $grade->date->format('d/m/Y') : 'Non spécifiée' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @hasrole('admin|teacher')
    <div class="flex justify-end">
        <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Supprimer cette note
            </button>
        </form>
    </div>
    @endhasrole
</div>
@endsection