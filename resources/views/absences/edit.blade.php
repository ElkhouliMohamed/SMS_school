@extends('layouts.app')

@section('title', 'Modifier une Absence')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier l'Absence</h1>
            <p class="text-gray-600 mt-2">Mettre à jour les informations de l'absence</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('absences.show', $absence) }}" class="flex items-center bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir les détails
            </a>
            <a href="{{ route('absences.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes:</h3>
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('absences.update', $absence) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de Base -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informations de l'Absence
                    </h2>
                </div>

                <!-- Filtres de recherche d'élèves -->
                <div class="md:col-span-2 mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Recherche par nom -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Rechercher par nom
                        </h3>

                        <form action="{{ route('absences.edit', $absence) }}" method="GET" class="space-y-3">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Nom ou prénom</label>
                                <input type="text" name="search" id="search" value="{{ $search ?? '' }}" placeholder="Rechercher..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                                @if(isset($classId) && $classId)
                                    <input type="hidden" name="class_id" value="{{ $classId }}">
                                @endif
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200 mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                    Rechercher
                                </button>
                                @if($search)
                                    <a href="{{ $classId ? route('absences.edit', ['absence' => $absence, 'class_id' => $classId]) : route('absences.edit', $absence) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                        </svg>
                                        Effacer
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Filtre par classe -->
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Filtrer par classe
                        </h3>

                        <form action="{{ route('absences.edit', $absence) }}" method="GET" class="space-y-3">
                            <div>
                                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                                <select name="class_id" id="class_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Toutes les classes</option>
                                    @if(isset($classes) && is_object($classes))
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{ (isset($classId) && $classId == $class->id) ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if(isset($search) && $search)
                                    <input type="hidden" name="search" value="{{ $search }}">
                                @endif
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                    </svg>
                                    Filtrer
                                </button>
                                @if($classId)
                                    <a href="{{ $search ? route('absences.edit', ['absence' => $absence, 'search' => $search]) : route('absences.edit', $absence) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                        </svg>
                                        Effacer
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Bouton pour réinitialiser tous les filtres -->
                    @if($search || $classId)
                    <div class="md:col-span-2 flex justify-center mt-2">
                        <a href="{{ route('absences.edit', $absence) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Réinitialiser tous les filtres
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Élève -->
                <div class="md:col-span-2">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Élève</label>
                    <select name="student_id" id="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" required>
                        <option value="">Sélectionner un élève</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $absence->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} - {{ $student->schoolClass->name ?? 'Aucune classe' }}
                            </option>
                        @endforeach
                    </select>
                    @if($students->isEmpty())
                        <p class="mt-1 text-sm text-yellow-600">Aucun élève ne correspond à votre recherche. Veuillez modifier vos critères.</p>
                    @endif
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Matière -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                    <select name="subject_id" id="subject_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $absence->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date d'absence -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date d'absence</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $absence->date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Heure de début -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Heure de début</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $absence->start_time ? \Carbon\Carbon::parse($absence->start_time)->format('H:i') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    <p class="mt-1 text-xs text-gray-500">Laissez vide pour une absence journée complète</p>
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Heure de fin -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Heure de fin</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $absence->end_time ? \Carbon\Carbon::parse($absence->end_time)->format('H:i') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Raison -->
                <div class="md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Raison de l'absence (Optionnel)</label>
                    <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('reason', $absence->reason) }}</textarea>
                    @error('reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('absences.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">Annuler</a>
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-md hover:bg-yellow-600 transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
