@extends('layouts.app')

@section('title', 'Modifier un Parent')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Parent</h1>
            <p class="text-gray-600 mt-2">Mettre à jour les informations du parent</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('guardians.show', $guardian) }}" class="flex items-center bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir les détails
            </a>
            <a href="{{ route('guardians.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
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
        <form action="{{ route('guardians.update', $guardian) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations Personnelles -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">Informations Personnelles</h2>
                </div>
                
                <!-- Prénom -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $guardian->first_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nom de famille</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $guardian->last_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informations de Contact -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b mt-4">Informations de Contact</h2>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $guardian->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $guardian->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Adresse -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $guardian->address) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ville -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $guardian->city) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informations de Connexion -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b mt-4">Informations de Connexion</h2>
                    <p class="text-sm text-gray-500 mb-4">Laissez les champs vides pour conserver le mot de passe actuel</p>
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Élèves -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b mt-4">Élèves à charge</h2>
                    <p class="text-sm text-gray-500 mb-4">Sélectionnez les élèves dont ce parent est responsable</p>
                    
                    <div class="border border-gray-300 rounded-md p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($students as $student)
                                <div class="flex items-center">
                                    <input type="checkbox" name="student_ids[]" id="student_{{ $student->id }}" value="{{ $student->id }}" 
                                        {{ in_array($student->id, old('student_ids', $guardian->students->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="student_{{ $student->id }}" class="ml-2 block text-sm text-gray-900">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('student_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('guardians.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">Annuler</a>
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
