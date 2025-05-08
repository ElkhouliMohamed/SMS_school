@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-lg">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-md">
                <i class="fas fa-key text-white text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                Mot de passe oublié
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <x-text-input
                        id="email"
                        class="block w-full pl-10 border-gray-300 text-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="votre@email.com"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    {{ __('Envoyer le lien de réinitialisation') }}
                </button>

                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800 transition-colors flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('Retour à la connexion') }}
                        </a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
