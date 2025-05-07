@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-4">Détails du Transport</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <p><strong>Numéro du Véhicule:</strong> {{ $transport->vehicle_number }}</p>
        <p><strong>Nom du Conducteur:</strong> {{ $transport->driver_name }}</p>
        <p><strong>Itinéraire:</strong> {{ $transport->route }}</p>
        <p><strong>Capacité:</strong> {{ $transport->capacity }}</p>
    </div>

    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-4">Étudiants Assignés</h2>
    <a href="{{ route('transports.assign-students', $transport) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mb-4">Assigner des Étudiants</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom de l'Étudiant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de Début</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transport->students as $student)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->pivot->start_date ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->pivot->status == 'active' ? 'Actif' : 'Inactif' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun étudiant assigné.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('transports.index') }}" class="inline-block bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 mt-4">Retour</a>
@endsection