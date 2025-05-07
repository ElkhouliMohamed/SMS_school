@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-4">Liste des Transports</h1>
    <a href="{{ route('transports.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mb-4">Ajouter un Transport</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro du Véhicule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom du Conducteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Itinéraire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transports as $transport)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transport->vehicle_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transport->driver_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transport->route }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transport->capacity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                            <a href="{{ route('transports.show', $transport) }}" class="text-blue-600 hover:text-blue-800">Voir</a>
                            <a href="{{ route('transports.edit', $transport) }}" class="text-yellow-600 hover:text-yellow-800">Modifier</a>
                            <form action="{{ route('transports.destroy', $transport) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce transport ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun transport trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $transports->links('pagination::tailwind') }}
    </div>
@endsection