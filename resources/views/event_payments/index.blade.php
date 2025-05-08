@extends('layouts.app')

@section('title', 'Paiements des Événements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Paiements des Événements</h1>
        <div>
            <a href="{{ route('event_registrations.index') }}" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                </svg>
                Inscriptions
            </a>
            
            @hasrole('admin|accountant')
            <a href="{{ route('event_payments.create') }}" class="flex items-center bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nouveau Paiement
            </a>
            @endhasrole
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(count($payments) > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Facture</th>
                            <th class="py-3 px-6 text-left">Événement</th>
                            <th class="py-3 px-6 text-left">Étudiant</th>
                            <th class="py-3 px-6 text-left">Montant</th>
                            <th class="py-3 px-6 text-left">Méthode</th>
                            <th class="py-3 px-6 text-left">Date</th>
                            <th class="py-3 px-6 text-left">Statut</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($payments as $payment)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">
                                    <span class="font-medium">{{ $payment->invoice_number }}</span>
                                </td>
                                
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        @if($payment->registration->event->image)
                                            <div class="mr-2">
                                                <img src="{{ asset('storage/' . $payment->registration->event->image) }}" alt="{{ $payment->registration->event->title }}" class="h-8 w-8 rounded object-cover">
                                            </div>
                                        @endif
                                        <a href="{{ route('events.show', $payment->registration->event) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ Str::limit($payment->registration->event->title, 30) }}
                                        </a>
                                    </div>
                                </td>
                                
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                                {{ substr($payment->registration->student->first_name, 0, 1) }}{{ substr($payment->registration->student->last_name, 0, 1) }}
                                            </div>
                                        </div>
                                        <span>{{ $payment->registration->student->first_name }} {{ $payment->registration->student->last_name }}</span>
                                    </div>
                                </td>
                                
                                <td class="py-3 px-6 text-left font-medium">
                                    {{ $payment->formatted_amount }}
                                </td>
                                
                                <td class="py-3 px-6 text-left">
                                    <span class="capitalize">{{ $payment->payment_method }}</span>
                                </td>
                                
                                <td class="py-3 px-6 text-left">
                                    {{ $payment->payment_date->format('d/m/Y') }}
                                </td>
                                
                                <td class="py-3 px-6 text-left">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($payment->status == 'completed') bg-green-100 text-green-800
                                        @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($payment->status == 'refunded') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('event_payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">
                                            Détails
                                        </a>
                                        
                                        <a href="{{ route('event_payments.invoice', $payment) }}" class="text-green-600 hover:text-green-900">
                                            Facture
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4">
                {{ $payments->links() }}
            </div>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun paiement trouvé</h3>
            <p class="text-gray-500 mb-4">Il n'y a actuellement aucun paiement enregistré.</p>
            
            @hasrole('admin|accountant')
            <a href="{{ route('event_payments.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Enregistrer un paiement
            </a>
            @endhasrole
        </div>
    @endif
</div>
@endsection
