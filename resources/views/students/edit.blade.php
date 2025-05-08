@extends('layouts.app')

@section('title', 'Modifier l\'Élève')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier l'Élève</h1>
            <p class="text-gray-600 mt-2">Mettre à jour les informations de l'élève</p>
        </div>
        <a href="{{ route('students.show', $student) }}" class="flex items-center bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Voir le profil
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <!-- Informations Personnelles -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informations Personnelles
                    </h2>
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                    <input type="text" name="first_name" id="first_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('first_name', $student->first_name) }}">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="last_name" id="last_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('last_name', $student->last_name) }}">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('email', $student->user->email) }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="text" name="phone" id="phone"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('phone', $student->phone) }}">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                    <input type="date" name="birth_date" id="birth_date"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('birth_date', $student->birth_date) }}">
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                    <select name="gender" id="gender"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionner</option>
                        <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Masculin</option>
                        <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Féminin</option>
                        <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nationality" class="block text-sm font-medium text-gray-700 mb-1">Nationalité</label>
                    <input type="text" name="nationality" id="nationality"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('nationality', $student->nationality) }}">
                    @error('nationality')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input type="text" name="address" id="address"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('address', $student->address) }}">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                    <input type="text" name="city" id="city"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('city', $student->city) }}">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                    <input type="text" name="postal_code" id="postal_code"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('postal_code', $student->postal_code) }}">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                    <input type="text" name="country" id="country"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('country', $student->country) }}">
                    @error('country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="identity_number" class="block text-sm font-medium text-gray-700 mb-1">Numéro d'identité</label>
                    <input type="text" name="identity_number" id="identity_number"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('identity_number', $student->identity_number) }}">
                    @error('identity_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informations Académiques -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                        Informations Académiques
                    </h2>
                </div>

                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                    <select name="class_id" id="class_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionner une classe</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informations du Tuteur -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Informations du Tuteur
                    </h2>
                </div>

                <div>
                    <label for="guardian_name" class="block text-sm font-medium text-gray-700 mb-1">Nom du tuteur</label>
                    <input type="text" name="guardian_name" id="guardian_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('guardian_name', $student->guardian_name) }}">
                    @error('guardian_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guardian_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone du tuteur</label>
                    <input type="text" name="guardian_phone" id="guardian_phone"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('guardian_phone', $student->guardian_phone) }}">
                    @error('guardian_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="guardian_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse du tuteur</label>
                    <input type="text" name="guardian_address" id="guardian_address"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('guardian_address', $student->guardian_address) }}">
                    @error('guardian_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="guardian_ids" class="block text-sm font-medium text-gray-700 mb-1">Tuteurs associés</label>
                    <p class="text-sm text-gray-500 mb-2">Sélectionnez les tuteurs associés à cet élève</p>
                    <div class="border border-gray-300 rounded-md p-4 max-h-60 overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach ($guardians as $guardian)
                                <div class="flex items-center">
                                    <input type="checkbox" name="guardian_ids[]" id="guardian_{{ $guardian->id }}" value="{{ $guardian->id }}"
                                        {{ $student->guardians->contains($guardian->id) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="guardian_{{ $guardian->id }}" class="ml-2 block text-sm text-gray-900">
                                        {{ $guardian->first_name }} {{ $guardian->last_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('guardian_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informations de Connexion -->
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Informations de Connexion
                    </h2>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe (laisser vide pour conserver l'actuel)</label>
                    <input type="password" name="password" id="password"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('students.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">Annuler</a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Mettre à jour
                </button>
            </div>
    </form>
@endsection