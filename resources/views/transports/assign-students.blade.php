@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-4">Assigner des Étudiants au Transport</h1>
    <h4 class="text-lg text-gray-700 mb-4">Véhicule: {{ $transport->vehicle_number }}</h4>
    <form action="{{ route('transports.store-assigned-students', $transport) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="student_ids" class="block text-sm font-medium text-gray-700">Sélectionner les Étudiants</label>
            <select name="student_ids[]" id="student_ids" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" multiple required>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
            <p class="mt-1 text-sm text-gray-500">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs étudiants.</p>
        </div>
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Date de Début</label>
            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('start_date') }}">
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
            </select>
        </div>
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Assigner</button>
            <a href="{{ route('transports.show', $transport) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Annuler</a>
        </div>
    </form>
@endsection