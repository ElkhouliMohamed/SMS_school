@extends('layouts.app')

@section('title', 'Réinitialisation du mot de passe')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-lg">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-md">
                <i class="fas fa-lock-open text-white text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                Réinitialiser votre mot de passe
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Créez un nouveau mot de passe sécurisé pour votre compte
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                        :value="old('email', $request->email)"
                        required
                        autofocus
                        autocomplete="email"
                        readonly
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Nouveau mot de passe')" class="text-gray-700 font-medium" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input
                        id="password"
                        class="block w-full pl-10 border-gray-300 text-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility('password')">
                            <i class="fas fa-eye-slash" id="password-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-1 text-xs text-gray-500 flex items-center">
                    <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                    <p>Doit contenir au moins 8 caractères</p>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-gray-700 font-medium" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input
                        id="password_confirmation"
                        class="block w-full pl-10 border-gray-300 text-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility('password_confirmation')">
                            <i class="fas fa-eye-slash" id="password_confirmation-eye"></i>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ __('Réinitialiser le mot de passe') }}
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

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(`${fieldId}-eye`);

        if (field.type === 'password') {
            field.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            field.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }
</script>
@endsection
