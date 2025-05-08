@extends('layouts.app')

@section('title', 'Détails de l\'inscription')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('event_registrations.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Retour aux inscriptions
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <h1 class="text-2xl font-bold text-gray-900">Détails de l'inscription</h1>
                <span class="px-3 py-1 text-sm rounded-full 
                    @if($registration->status == 'registered') bg-yellow-100 text-yellow-800
                    @elseif($registration->status == 'confirmed') bg-green-100 text-green-800
                    @elseif($registration->status == 'attended') bg-blue-100 text-blue-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations sur l'événement</h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start">
                        @if($registration->event->image)
                            <div class="mr-4">
                                <img src="{{ asset('storage/' . $registration->event->image) }}" alt="{{ $registration->event->title }}" class="h-20 w-20 rounded object-cover">
                            </div>
                        @else
                            <div class="mr-4 h-20 w-20 rounded bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div>
                            <h3 class="text-xl font-medium text-gray-900">{{ $registration->event->title }}</h3>
                            <p class="text-gray-600 mt-1">
                                <span class="inline-block mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $registration->event->start_date->format('d/m/Y H:i') }}
                                </span>
                                
                                @if($registration->event->location)
                                    <span class="inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $registration->event->location }}
                                    </span>
                                @endif
                            </p>
                            
                            <div class="mt-2">
                                @if($registration->event->is_free)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Gratuit</span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">{{ number_format($registration->event->price, 2) }} MAD</span>
                                @endif
                                
                                <span class="ml-2 text-sm text-gray-500">
                                    Statut: <span class="font-medium">{{ ucfirst($registration->event->status) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('events.show', $registration->event) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir les détails de l'événement
                        </a>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations sur l'étudiant</h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="mr-4 h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium text-lg">
                            {{ substr($registration->student->first_name, 0, 1) }}{{ substr($registration->student->last_name, 0, 1) }}
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $registration->student->first_name }} {{ $registration->student->last_name }}</h3>
                            <p class="text-gray-600">{{ $registration->student->email }}</p>
                        </div>
                    </div>
                    
                    @hasrole('admin|teacher')
                    <div class="mt-4">
                        <a href="{{ route('students.show', $registration->student) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir le profil de l'étudiant
                        </a>
                    </div>
                    @endhasrole
                </div>
            </div>
            
            <div class="md:col-span-2">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Détails du paiement</h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    @if($registration->payment_required)
                        @if($registration->payment_completed && $registration->payment)
                            <div class="flex items-center text-green-600 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Paiement effectué</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Montant</p>
                                    <p class="font-medium">{{ $registration->payment->formatted_amount }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Méthode de paiement</p>
                                    <p class="font-medium">{{ ucfirst($registration->payment->payment_method) }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Date de paiement</p>
                                    <p class="font-medium">{{ $registration->payment->payment_date->format('d/m/Y H:i') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Numéro de facture</p>
                                    <p class="font-medium">{{ $registration->payment->invoice_number }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('event_payments.show', $registration->payment) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Voir les détails du paiement
                                </a>
                                
                                <a href="{{ route('event_payments.invoice', $registration->payment) }}" class="ml-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Voir la facture
                                </a>
                            </div>
                        @else
                            <div class="flex items-center text-red-600 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Paiement en attente</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">
                                Un paiement de <span class="font-medium">{{ number_format($registration->event->price, 2) }} MAD</span> est requis pour confirmer cette inscription.
                            </p>
                            
                            @hasrole('admin|accountant')
                            <a href="{{ route('event_payments.create', ['registration' => $registration->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                Enregistrer un paiement
                            </a>
                            @endhasrole
                        @endif
                    @else
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span>Aucun paiement requis pour cet événement (gratuit)</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        @if($registration->notes)
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Notes</h2>
                <p class="text-gray-700">{{ $registration->notes }}</p>
            </div>
        @endif
        
        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between">
            <div>
                @if($registration->status != 'cancelled' && $registration->event->status == 'upcoming')
                    @hasrole('admin|teacher')
                    @if($registration->status != 'attended')
                        <form action="{{ route('event_registrations.mark_attended', $registration) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors mr-2">
                                Marquer comme présent
                            </button>
                        </form>
                    @endif
                    @endhasrole
                    
                    <form action="{{ route('event_registrations.cancel', $registration) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette inscription ?')">
                            Annuler l'inscription
                        </button>
                    </form>
                @endif
            </div>
            
            <a href="{{ route('event_registrations.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
