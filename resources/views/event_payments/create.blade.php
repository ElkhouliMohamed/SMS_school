@extends('layouts.app')

@section('title', 'Enregistrer un Paiement')

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

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Enregistrer un Paiement</h1>

            <form action="{{ route('event_payments.store') }}" method="POST">
                @csrf

                @if(isset($registration))
                    <!-- Registration is pre-selected -->
                    <input type="hidden" name="event_registration_id" value="{{ $registration->id }}">

                    <div class="mb-6 bg-blue-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Informations sur l'inscription</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Événement</p>
                                <p class="font-medium">{{ $registration->event->title }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium">{{ $registration->event->start_date->format('d/m/Y H:i') }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Étudiant</p>
                                <p class="font-medium">{{ $registration->student->first_name }} {{ $registration->student->last_name }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Montant à payer</p>
                                <p class="font-medium">{{ number_format($registration->event->price, 2) }} MAD</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Registration selection -->
                    <div class="mb-6">
                        <label for="event_registration_id" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner une inscription *</label>
                        <select name="event_registration_id" id="event_registration_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="">-- Sélectionner une inscription --</option>
                            @foreach($registrations as $reg)
                                <option value="{{ $reg->id }}" data-price="{{ $reg->event->price }}">
                                    {{ $reg->student->first_name }} {{ $reg->student->last_name }} - {{ $reg->event->title }} ({{ $reg->event->start_date->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('event_registration_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Montant (MAD) *</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', isset($registration) ? $registration->event->price : '') }}" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Méthode de paiement *</label>
                        <select name="payment_method" id="payment_method" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Carte de crédit</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transaction ID -->
                    <div>
                        <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-1">ID de transaction</label>
                        <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500">Facultatif. Numéro de référence pour les virements bancaires ou les paiements par carte.</p>
                        @error('transaction_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Date -->
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">Date de paiement *</label>
                        <input type="datetime-local" name="payment_date" id="payment_date" value="{{ old('payment_date', now()->format('Y-m-d\TH:i')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        @error('payment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('event_payments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors mr-2">
                        Annuler
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        Enregistrer le paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registrationSelect = document.getElementById('event_registration_id');
        const amountInput = document.getElementById('amount');

        if (registrationSelect) {
            registrationSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.dataset.price) {
                    amountInput.value = selectedOption.dataset.price;
                } else {
                    amountInput.value = '';
                }
            });
        }
    });
</script>
@endsection
@endsection
