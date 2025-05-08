@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Assigner des Étudiants au Transport</h1>
            <p class="text-lg text-gray-600 mt-2">Véhicule: <span class="font-semibold">{{ $transport->vehicle_number }}</span> ({{ $transport->driver_name }})</p>
        </div>
        <a href="{{ route('transports.show', $transport) }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour aux détails
        </a>
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
        <form action="{{ route('transports.store-assigned-students', $transport) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="student_ids" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner les Étudiants</label>
                <select name="student_ids[]" id="student_ids" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" multiple required size="10">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs étudiants.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Date de Début</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('start_date', date('Y-m-d')) }}">
                    <p class="mt-1 text-xs text-gray-500">Date à partir de laquelle les étudiants utiliseront ce transport.</p>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Définit si les étudiants utilisent activement ce transport.</p>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('transports.show', $transport) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">Annuler</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Assigner les Étudiants
                </button>
            </div>
        </form>
    </div>
</div>
@endsection