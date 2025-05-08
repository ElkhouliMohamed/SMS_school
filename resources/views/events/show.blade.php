@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('events.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Retour aux événements
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3">
                @if($event->image)
                    <div class="h-64 md:h-full">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="h-64 md:h-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                @endif
            </div>

            <div class="md:w-2/3 p-6">
                <div class="flex justify-between items-start">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                    <span class="px-3 py-1 text-sm rounded-full
                        @if($event->status == 'upcoming') bg-blue-100 text-blue-800
                        @elseif($event->status == 'ongoing') bg-green-100 text-green-800
                        @elseif($event->status == 'completed') bg-gray-100 text-gray-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>

                <div class="flex flex-wrap items-center text-gray-600 mb-6">
                    <div class="flex items-center mr-6 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $event->start_date->format('d/m/Y H:i') }} - {{ $event->end_date->format('d/m/Y H:i') }}</span>
                    </div>

                    @if($event->location)
                        <div class="flex items-center mr-6 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $event->location }}</span>
                        </div>
                    @endif

                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Organisé par {{ $event->creator->name }}</span>
                    </div>
                </div>

                <div class="flex items-center mb-6">
                    @if($event->is_free)
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Gratuit</span>
                    @else
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">{{ number_format($event->price, 2) }} MAD</span>
                    @endif

                    @if($event->capacity)
                        <div class="ml-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-gray-700">
                                <span class="font-medium">{{ $event->registered_count }}/{{ $event->capacity }}</span> inscrits
                            </span>
                        </div>
                    @endif
                </div>

                @if(Auth::user()->hasRole('student') && !$isRegistered && $event->status == 'upcoming' && !$event->is_full)
                    <form action="{{ route('events.register', $event) }}" method="POST" class="mb-6">
                        @csrf
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            S'inscrire à cet événement
                        </button>
                    </form>
                @elseif($isRegistered)
                    <div class="mb-6">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm leading-5 font-medium">
                                        Vous êtes inscrit à cet événement
                                        @if($registration->status == 'registered')
                                            (En attente de confirmation)
                                        @elseif($registration->status == 'confirmed')
                                            (Confirmé)
                                        @elseif($registration->status == 'attended')
                                            (Présence confirmée)
                                        @endif
                                    </p>

                                    @if($registration->payment_required && !$registration->payment_completed)
                                        <p class="text-sm leading-5 mt-1">
                                            <span class="text-orange-600 font-medium">Paiement requis</span>
                                        </p>
                                    @elseif($registration->payment_completed)
                                        <p class="text-sm leading-5 mt-1">
                                            <span class="text-green-600 font-medium">Paiement effectué</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($registration->status != 'cancelled' && $event->status == 'upcoming')
                            <form action="{{ route('event_registrations.cancel', $registration) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Êtes-vous sûr de vouloir annuler votre inscription ?')">
                                    Annuler mon inscription
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Description</h2>
                    <div class="text-gray-700">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        @hasrole('admin|teacher')
        <div class="p-6 bg-gray-50 border-t border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Liste des inscrits</h2>

            @if(count($event->registrations) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Étudiant</th>
                                <th class="py-3 px-6 text-left">Statut</th>
                                <th class="py-3 px-6 text-left">Paiement</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @foreach($event->registrations as $registration)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <div class="mr-2">
                                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                                    {{ substr($registration->student->first_name, 0, 1) }}{{ substr($registration->student->last_name, 0, 1) }}
                                                </div>
                                            </div>
                                            <span>{{ $registration->student->first_name }} {{ $registration->student->last_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($registration->status == 'registered') bg-yellow-100 text-yellow-800
                                            @elseif($registration->status == 'confirmed') bg-green-100 text-green-800
                                            @elseif($registration->status == 'attended') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        @if($registration->payment_required)
                                            @if($registration->payment_completed)
                                                <span class="text-green-600 font-medium">Payé</span>
                                            @else
                                                <span class="text-red-600 font-medium">Non payé</span>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Non requis</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center space-x-3">
                                            @if($registration->status != 'cancelled')
                                                @if($registration->status != 'attended')
                                                    <form action="{{ route('event_registrations.mark_attended', $registration) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                            Marquer présent
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($registration->payment_required && !$registration->payment_completed)
                                                    <a href="{{ route('event_payments.create', ['registration' => $registration->id]) }}" class="text-green-600 hover:text-green-900">
                                                        Enregistrer paiement
                                                    </a>
                                                @endif

                                                <form action="{{ route('event_registrations.cancel', $registration) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette inscription ?')">
                                                        Annuler
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Aucun étudiant inscrit à cet événement.</p>
            @endif
        </div>
        @endhasrole

        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between">
            @hasrole('admin|teacher')
            <div>
                <a href="{{ route('events.edit', $event) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition-colors mr-2">
                    Modifier l'événement
                </a>
                <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                        Supprimer l'événement
                    </button>
                </form>
            </div>
            @endhasrole

            <a href="{{ route('events.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
