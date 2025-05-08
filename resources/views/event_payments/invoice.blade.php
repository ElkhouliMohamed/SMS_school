@extends('layouts.app')

@section('title', 'Facture #' . $eventPayment->invoice_number)

@section('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice-container, #invoice-container * {
            visibility: visible;
        }
        #invoice-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 no-print">
        <a href="{{ route('event_payments.show', $eventPayment) }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Retour aux détails du paiement
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden" id="invoice-container">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Facture</h1>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors no-print">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Imprimer
            </button>
        </div>
        
        <div class="p-6">
            <div class="flex justify-between mb-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">EduManage Pro</h2>
                    <p class="text-gray-600">123 Rue de l'Éducation</p>
                    <p class="text-gray-600">75000 Paris, France</p>
                    <p class="text-gray-600">contact@edumanagepro.fr</p>
                    <p class="text-gray-600">+33 1 23 45 67 89</p>
                </div>
                
                <div class="text-right">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Facture #{{ $eventPayment->invoice_number }}</h3>
                    <p class="text-gray-600">Date: {{ $eventPayment->payment_date->format('d/m/Y') }}</p>
                    <p class="text-gray-600">Statut: <span class="font-medium 
                        @if($eventPayment->status == 'completed') text-green-600
                        @elseif($eventPayment->status == 'pending') text-yellow-600
                        @elseif($eventPayment->status == 'refunded') text-blue-600
                        @else text-red-600 @endif">
                        {{ ucfirst($eventPayment->status) }}
                    </span></p>
                </div>
            </div>
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Facturé à:</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-900">{{ $eventPayment->registration->student->first_name }} {{ $eventPayment->registration->student->last_name }}</p>
                    <p class="text-gray-600">{{ $eventPayment->registration->student->email }}</p>
                    @if($eventPayment->registration->student->address)
                        <p class="text-gray-600">{{ $eventPayment->registration->student->address }}</p>
                    @endif
                </div>
            </div>
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Détails:</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="py-3 px-6 text-left">Description</th>
                                <th class="py-3 px-6 text-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-6">
                                    <p class="font-medium text-gray-900">{{ $eventPayment->registration->event->title }}</p>
                                    <p class="text-sm text-gray-500">Date: {{ $eventPayment->registration->event->start_date->format('d/m/Y H:i') }}</p>
                                    @if($eventPayment->registration->event->location)
                                        <p class="text-sm text-gray-500">Lieu: {{ $eventPayment->registration->event->location }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">{{ $eventPayment->formatted_amount }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td class="py-3 px-6 text-right font-semibold">Total</td>
                                <td class="py-3 px-6 text-right font-bold">{{ $eventPayment->formatted_amount }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Informations de paiement:</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    </div>
                </div>
            </div>
            
            @if($eventPayment->notes)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Notes:</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $eventPayment->notes }}</p>
                    </div>
                </div>
            @endif
            
            <div class="text-center text-gray-500 text-sm mt-12">
                <p>Merci pour votre paiement!</p>
                <p class="mt-1">Pour toute question concernant cette facture, veuillez contacter notre service comptabilité.</p>
            </div>
        </div>
    </div>
</div>
@endsection
