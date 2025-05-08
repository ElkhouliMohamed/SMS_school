@extends('layouts.app')

@section('title', 'Ajouter une Absence')

@section('content')
<div class="min-h-screen bg-gray-100 pt-16 md:pt-20 md:ml-64 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Ajouter une Absence</h1>
                <p class="text-gray-600 mt-2">Enregistrer une nouvelle absence d'élève</p>
            </div>
            <a href="{{ route('absences.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6" role="alert">
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
            <form action="{{ route('absences.store') }}" method="POST">
                @csrf
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

                    <!-- Class Filter -->
                    <div class="md:col-span-2">
                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                        <select name="class_id" id="class_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" aria-describedby="class-hint">
                            <option value="">Toutes les classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <p id="class-hint" class="mt-1 text-xs text-gray-500">Sélectionnez une classe pour filtrer les élèves.</p>
                    </div>

                    <!-- Élève -->
                    <div class="md:col-span-2">
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Élève <span class="text-red-500">*</span></label>
                        <select name="student_id" id="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" required aria-describedby="student-hint">
                            <option value="">Sélectionner un élève</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }} data-class-id="{{ $student->class_id }}">
                                    {{ $student->first_name }} {{ $student->last_name }} - {{ $student->schoolClass->name ?? 'Aucune classe' }}
                                </option>
                            @endforeach
                        </select>
                        <p id="student-hint" class="mt-1 text-xs text-gray-500">Sélectionnez l'élève concerné par l'absence.</p>
                        @if($students->isEmpty())
                            <p class="mt-1 text-sm text-yellow-600" role="alert">Aucun élève ne correspond à votre recherche. Veuillez modifier vos critères.</ shredded
                        @endif
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Matière -->
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Matière <span class="text-red-500">*</span></label>
                        <select name="subject_id" id="subject_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" required aria-describedby="subject-hint">
                            <option value="">Sélectionner une matière</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        <p id="subject-hint" class="mt-1 text-xs text-gray-500">Sélectionnez la matière concernée.</p>
                        @error('subject_id')
                            <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date d'absence -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date d'absence <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" required aria-describedby="date-hint">
                        <p id="date-hint" class="mt-1 text-xs text-gray-500">Choisissez la date de l'absence.</p>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Raison -->
                    <div class="md:col-span-2">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Raison de l'absence (Optionnel)</label>
                        <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" aria-describedby="reason-hint">{{ old('reason') }}</textarea>
                        <p id="reason-hint" class="mt-1 text-xs text-gray-500">Décrivez brièvement la raison de l'absence, si applicable.</p>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <a href="{{ route('absences.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">Annuler</a>
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        // Dynamic student filtering based on class selection
        document.getElementById('class_id').addEventListener('change', function () {
            const classId = this.value;
            const studentSelect_viewer = document.getElementById('student_id');
            const studentOptions = studentSelect.querySelectorAll('option[data-class-id]');
            const hint = document.getElementById('student-hint');

            // Reset student selection
            studentSelect.value = '';
            hint.textContent = 'Sélectionnez l’élève concerné par l’absence.';
            hint.classList.remove('text-green-600');

            // Show/hide student options based on class
            studentOptions.forEach(option => {
                if (!classId || option.getAttribute('data-class-id') === classId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Dynamic feedback for student select
        document.getElementById('student_id').addEventListener('change', function () {
            const hint = document.getElementById('student-hint');
            if (this.value) {
                hint.textContent = 'Élève sélectionné.';
                hint.classList.add('text-green-600');
            } else {
                hint.textContent = 'Sélectionnez l’élève concerné par l’absence.';
                hint.classList.remove('text-green-600');
            }
        });
    </script>


@endsection