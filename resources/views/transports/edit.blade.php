@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Modifier le Transport</h1>
        <div class="flex space-x-2">
            <a href="{{ route('transports.show', $transport) }}" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir les détails
            </a>
            <a href="{{ route('transports.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
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
        <form action="{{ route('transports.update', $transport) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="vehicle_number" class="block text-sm font-medium text-gray-700 mb-1">Numéro du Véhicule</label>
                    <input type="text" name="vehicle_number" id="vehicle_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('vehicle_number', $transport->vehicle_number) }}" required>
                    <p class="mt-1 text-xs text-gray-500">Exemple: BUS-001, VAN-002, etc.</p>
                </div>
                <div>
                    <label for="driver_name" class="block text-sm font-medium text-gray-700 mb-1">Nom du Conducteur</label>
                    <input type="text" name="driver_name" id="driver_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('driver_name', $transport->driver_name) }}" required>
                </div>
            </div>
            <div>
                <label for="route_description" class="block text-sm font-medium text-gray-700 mb-1">Description de l'Itinéraire</label>
                <textarea name="route_description" id="route_description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ old('route_description', $transport->route_description) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Décrivez l'itinéraire complet avec les arrêts principaux.</p>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('transports.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">Annuler</a>
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