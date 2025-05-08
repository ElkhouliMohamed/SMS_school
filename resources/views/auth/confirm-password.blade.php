@extends('layouts.app')

@section('title', 'Confirmation du mot de passe')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-lg">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-md">
                <i class="fas fa-shield-alt text-white text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                Zone sécurisée
            </h2>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-gray-700">
            <p class="text-sm">
                Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-medium" />
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
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility('password')">
                            <i class="fas fa-eye-slash" id="password-eye"></i>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ __('Confirmer') }}
                </button>

                <div class="text-center pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="font-medium text-blue-600 hover:text-blue-800 transition-colors flex items-center justify-center mx-auto">
                        <i class="fas fa-arrow-left mr-2"></i>
                        {{ __('Retour au tableau de bord') }}
                    </a>
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
