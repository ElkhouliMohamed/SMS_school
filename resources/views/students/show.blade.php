@extends('layouts.app')

@section('title', 'Détails de l\'Élève')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Profil de l'Élève</h1>
        <div class="flex space-x-2">
            @hasrole('admin')
                <a href="{{ route('students.edit', $student) }}" class="flex items-center bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            @endhasrole
            <a href="{{ route('students.index') }}" class="flex items-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:w-1/3 bg-green-50 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                <div class="h-32 w-32 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-4xl font-bold mb-4">
                    {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
                </div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</h2>
                <p class="text-green-600 font-medium mt-1">Élève</p>
                <div class="mt-3 bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                    {{ $student->schoolClass->name ?? 'Aucune classe' }}
                </div>
            </div>
            <div class="md:w-2/3 p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations Personnelles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-gray-800">{{ $student->user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Téléphone</p>
                            <p class="text-gray-800">{{ $student->phone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Date de naissance</p>
                            <p class="text-gray-800">{{ $student->birth_date ? date('d/m/Y', strtotime($student->birth_date)) : 'Non renseignée' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Genre</p>
                            <p class="text-gray-800">
                                @if($student->gender == 'male')
                                    Masculin
                                @elseif($student->gender == 'female')
                                    Féminin
                                @elseif($student->gender == 'other')
                                    Autre
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Nationalité</p>
                            <p class="text-gray-800">{{ $student->nationality ?? 'Non renseignée' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Numéro d'identité</p>
                            <p class="text-gray-800">{{ $student->identity_number ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mt-6 mb-4">Adresse</h3>
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <p class="text-gray-800">{{ $student->address ?? 'Adresse non renseignée' }}</p>
                        @if($student->city || $student->postal_code || $student->country)
                            <p class="text-gray-800">
                                {{ $student->city ?? '' }}
                                {{ $student->postal_code ? ($student->city ? ', ' : '') . $student->postal_code : '' }}
                                {{ $student->country ? ($student->city || $student->postal_code ? ', ' : '') . $student->country : '' }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Parents/Tuteurs</h3>
        @if ($student->guardians->isEmpty())
            <p class="text-gray-500 italic">Aucun parent/tuteur assigné à cet élève.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($student->guardians as $guardian)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                {{ strtoupper(substr($guardian->first_name, 0, 1)) }}{{ strtoupper(substr($guardian->last_name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <h4 class="text-lg font-medium text-gray-900">{{ $guardian->first_name }} {{ $guardian->last_name }}</h4>
                                <p class="text-sm text-gray-500">{{ $guardian->phone ?? 'Aucun téléphone' }}</p>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('guardians.show', $guardian) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @hasrole('admin')
        <div class="flex justify-end">
            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer cet élève
                </button>
            </form>
        </div>
    @endhasrole
</div>
@endsection
