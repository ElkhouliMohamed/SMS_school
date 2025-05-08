@extends('layouts.app')

@section('title', 'Modifier l\'événement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('events.show', $event) }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Retour à l'événement
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier l'Événement</h1>

            <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre de l'événement *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" id="description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Date et heure de début *</label>
                        <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Date et heure de fin *</label>
                        <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-span-2">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lieu</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix (MAD) *</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        <p class="mt-1 text-xs text-gray-500">Mettez 0 pour un événement gratuit</p>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacité</label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500">Laissez vide pour une capacité illimitée</p>
                        @error('capacity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>À venir</option>
                            <option value="ongoing" {{ old('status', $event->status) == 'ongoing' ? 'selected' : '' }}>En cours</option>
                            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Terminé</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($event->image)
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image actuelle</label>
                            <div class="mt-1 flex items-center">
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="h-32 w-auto object-cover rounded-md">
                                <p class="ml-3 text-sm text-gray-500">Pour remplacer cette image, téléchargez-en une nouvelle ci-dessous.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Image -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="image" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPG, PNG, GIF. Taille max : 2 Mo</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('events.show', $event) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors mr-2">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        Mettre à jour l'événement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
