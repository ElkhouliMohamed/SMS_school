@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-4">Ajouter un Transport</h1>
    <form action="{{ route('transports.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="vehicle_number" class="block text-sm font-medium text-gray-700">Numéro du Véhicule</label>
            <input type="text" name="vehicle_number" id="vehicle_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('vehicle_number') }}" required>
        </div>
        <div>
            <label for="driver_name" class="block text-sm font-medium text-gray-700">Nom du Conducteur</label>
            <input type="text" name="driver_name" id="driver_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('driver_name') }}" required>
        </div>
        <div>
            <label for="route" class="block text-sm font-medium text-gray-700">Itinéraire</label>
            <input type="text" name="route" id="route" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('route') }}" required>
        </div>
        <div>
            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité</label>
            <input type="number" name="capacity" id="capacity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('capacity') }}" required>
        </div>
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Créer</button>
            <a href="{{ route('transports.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Annuler</a>
        </div>
    </form>
@endsection