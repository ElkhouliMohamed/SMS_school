@extends('layouts.app')

@section('title', 'Détails du Paiement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('event_payments.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Retour aux paiements
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <h1 class="text-2xl font-bold text-gray-900">Détails du Paiement</h1>
                <span class="px-3 py-1 text-sm rounded-full 
                    @if($eventPayment->status == 'completed') bg-green-100 text-green-800
                    @elseif($eventPayment->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($eventPayment->status == 'refunded') bg-blue-100 text-blue-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($eventPayment->status) }}
                </span>
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations sur le paiement</h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Numéro de facture</p>
                            <p class="font-medium">{{ $eventPayment->invoice_number }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Montant</p>
                            <p class="font-medium">{{ $eventPayment->formatted_amount }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Méthode de paiement</p>
                            <p class="font-medium capitalize">{{ $eventPayment->payment_method }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Date de paiement</p>
                            <p class="font-medium">{{ $eventPayment->payment_date->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        @if($eventPayment->transaction_id)
                            <div>
                                <p class="text-sm text-gray-500">ID de transaction</p>
                                <p class="font-medium">{{ $eventPayment->transaction_id }}</p>
                            </div>
                        @endif
                        
                        <div>
                            <p class="text-sm text-gray-500">Reçu par</p>
                            <p class="font-medium">{{ $eventPayment->receiver ? $eventPayment->receiver->name : 'N/A' }}</p>
                        </div>
                    </div>
                    
                    @if($eventPayment->notes)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-1">Notes</p>
                            <p class="text-gray-700">{{ $eventPayment->notes }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('event_payments.invoice', $eventPayment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd" />
                        </svg>
                        Voir la facture
                    </a>
                </div>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations sur l'événement</h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start">
                        @if($eventPayment->registration->event->image)
                            <div class="mr-4">
                                <img src="{{ asset('storage/' . $eventPayment->registration->event->image) }}" alt="{{ $eventPayment->registration->event->title }}" class="h-20 w-20 rounded object-cover">
                            </div>
                        @else
                            <div class="mr-4 h-20 w-20 rounded bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div>
                            <h3 class="text-xl font-medium text-gray-900">{{ $eventPayment->registration->event->title }}</h3>
                            <p class="text-gray-600 mt-1">
                                <span class="inline-block mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $eventPayment->registration->event->start_date->format('d/m/Y H:i') }}
                                </span>
                                
                                @if($eventPayment->registration->event->location)
                                    <span class="inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $eventPayment->registration->event->location }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="mr-4 h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                {{ substr($eventPayment->registration->student->first_name, 0, 1) }}{{ substr($eventPayment->registration->student->last_name, 0, 1) }}
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Participant</p>
                                <p class="font-medium">{{ $eventPayment->registration->student->first_name }} {{ $eventPayment->registration->student->last_name }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('events.show', $eventPayment->registration->event) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir les détails de l'événement
                        </a>
                        
                        <a href="{{ route('event_registrations.show', $eventPayment->registration) }}" class="ml-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir l'inscription
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end">
            <a href="{{ route('event_payments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
