@extends('layouts.app')

@section('title', 'Inscriptions aux Événements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Inscriptions aux Événements</h1>
        <a href="{{ route('events.index') }}" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
            </svg>
            Voir les événements
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(count($registrations) > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Événement</th>
                            @hasrole('admin|teacher|accountant')
                            <th class="py-3 px-6 text-left">Étudiant</th>
                            @endhasrole
                            <th class="py-3 px-6 text-left">Date</th>
                            <th class="py-3 px-6 text-left">Statut</th>
                            <th class="py-3 px-6 text-left">Paiement</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($registrations as $registration)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        @if($registration->event->image)
                                            <div class="mr-2">
                                                <img src="{{ asset('storage/' . $registration->event->image) }}" alt="{{ $registration->event->title }}" class="h-10 w-10 rounded object-cover">
                                            </div>
                                        @else
                                            <div class="mr-2 h-10 w-10 rounded bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <a href="{{ route('events.show', $registration->event) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $registration->event->title }}
                                        </a>
                                    </div>
                                </td>
                                
                                @hasrole('admin|teacher|accountant')
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                                {{ substr($registration->student->first_name, 0, 1) }}{{ substr($registration->student->last_name, 0, 1) }}
                                            </div>
                                        </div>
                                        <a href="{{ route('students.show', $registration->student) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $registration->student->first_name }} {{ $registration->student->last_name }}
                                        </a>
                                    </div>
                                </td>
                                @endhasrole
                                
                                <td class="py-3 px-6 text-left">
                                    <div class="flex flex-col">
                                        <span>{{ $registration->event->start_date->format('d/m/Y') }}</span>
                                        <span class="text-xs text-gray-500">{{ $registration->event->start_date->format('H:i') }} - {{ $registration->event->end_date->format('H:i') }}</span>
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
                                            <span class="flex items-center text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Payé
                                            </span>
                                            @if($registration->payment)
                                                <a href="{{ route('event_payments.show', $registration->payment) }}" class="text-xs text-blue-600 hover:text-blue-900 block mt-1">
                                                    Voir le paiement
                                                </a>
                                            @endif
                                        @else
                                            <span class="flex items-center text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                Non payé
                                            </span>
                                            @hasrole('admin|accountant')
                                            <a href="{{ route('event_payments.create', ['registration' => $registration->id]) }}" class="text-xs text-blue-600 hover:text-blue-900 block mt-1">
                                                Enregistrer paiement
                                            </a>
                                            @endhasrole
                                        @endif
                                    @else
                                        <span class="text-gray-500">Non requis</span>
                                    @endif
                                </td>
                                
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('event_registrations.show', $registration) }}" class="text-blue-600 hover:text-blue-900">
                                            Détails
                                        </a>
                                        
                                        @if($registration->status != 'cancelled' && $registration->event->status == 'upcoming')
                                            @hasrole('admin|teacher')
                                            @if($registration->status != 'attended')
                                                <form action="{{ route('event_registrations.mark_attended', $registration) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                                        Marquer présent
                                                    </button>
                                                </form>
                                            @endif
                                            @endhasrole
                                            
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
            
            <div class="px-6 py-4">
                {{ $registrations->links() }}
            </div>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune inscription trouvée</h3>
            <p class="text-gray-500 mb-4">Vous n'êtes inscrit à aucun événement pour le moment.</p>
            
            <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                </svg>
                Voir les événements disponibles
            </a>
        </div>
    @endif
</div>
@endsection
