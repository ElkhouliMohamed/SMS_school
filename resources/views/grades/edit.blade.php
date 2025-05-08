@extends('layouts.app')

@section('title', 'Modifier une Note')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier la Note</h1>
            <p class="text-gray-600 mt-2">Mettre à jour les informations de la note</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('grades.show', $grade) }}" class="flex items-center bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir les détails
            </a>
            <a href="{{ route('grades.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
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
        <form action="{{ route('grades.update', $grade) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de Base -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Informations de la Note
                    </h2>
                </div>

                <!-- Élève -->
                <div class="md:col-span-2">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Élève</label>
                    <select name="student_id" id="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                        <option value="">Sélectionner un élève</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $grade->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} - {{ $student->schoolClass->name ?? 'Aucune classe' }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Matière -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                    <select name="subject_id" id="subject_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $grade->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $grade->date ? $grade->date->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Note -->
                <div class="md:col-span-2">
                    <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Note (0-20)</label>
                    <div class="mt-1 relative">
                        <input type="number" name="grade" id="grade" value="{{ old('grade', $grade->grade) }}" step="0.01" min="0" max="20" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 pr-12" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500">/20</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-yellow-600 h-2.5 rounded-full" style="width: {{ min(max($grade->grade * 5, 0), 100) }}%" id="gradeBar"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>0</span>
                            <span>5</span>
                            <span>10</span>
                            <span>15</span>
                            <span>20</span>
                        </div>
                    </div>
                    @error('grade')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('grades.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">Annuler</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gradeInput = document.getElementById('grade');
        const gradeBar = document.getElementById('gradeBar');

        function updateGradeBar() {
            const value = parseFloat(gradeInput.value) || 0;
            const percentage = Math.min(Math.max(value * 5, 0), 100);
            gradeBar.style.width = percentage + '%';

            // Change color based on grade
            if (value >= 14) {
                gradeBar.classList.remove('bg-red-600', 'bg-yellow-600', 'bg-blue-600');
                gradeBar.classList.add('bg-green-600');
            } else if (value >= 10) {
                gradeBar.classList.remove('bg-red-600', 'bg-yellow-600', 'bg-green-600');
                gradeBar.classList.add('bg-blue-600');
            } else if (value >= 8) {
                gradeBar.classList.remove('bg-red-600', 'bg-blue-600', 'bg-green-600');
                gradeBar.classList.add('bg-yellow-600');
            } else {
                gradeBar.classList.remove('bg-yellow-600', 'bg-blue-600', 'bg-green-600');
                gradeBar.classList.add('bg-red-600');
            }
        }

        gradeInput.addEventListener('input', updateGradeBar);
        updateGradeBar(); // Initialize on page load
    });
</script>
@endsection