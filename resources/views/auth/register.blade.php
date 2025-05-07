@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-gray-800 rounded-xl shadow-2xl p-8 border border-gray-700 transition-all duration-300 hover:shadow-blue-500/30">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto w-12 h-12 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-md">
                <i class="fas fa-school text-gray-900 text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold uppercase tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-300">
                EduManage Pro
            </h2>
            <p class="mt-2 text-sm text-gray-400">Créez votre compte</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nom complet')" class="text-gray-200 font-medium" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <x-text-input 
                        id="name" 
                        class="block mt-1 w-full pl-10 bg-gray-700 border-gray-600 text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        autocomplete="name"
                        placeholder="John Doe" 
                    />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-200 font-medium" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full pl-10 bg-gray-700 border-gray-600 text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autocomplete="username"
                        placeholder="votre@email.com" 
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Role Selection -->
            <div>
                <x-input-label for="role" :value="__('Rôle')" class="text-gray-200 font-medium" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-tag text-gray-400"></i>
                    </div>
                    <select 
                        id="role" 
                        name="role" 
                        class="block mt-1 w-full pl-10 pr-3 py-2 bg-gray-700 border-gray-600 text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required
                        onchange="updatePasswordHint()"
                    >
                        <option value="" disabled selected>Sélectionnez votre rôle</option>
                        <option value="admin">Admin</option>
                        <option value="teacher">Enseignant</option>
                        <option value="accountant">Comptable</option>
                        <option value="student">Étudiant</option>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-200 font-medium" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input 
                        id="password" 
                        class="block mt-1 w-full pl-10 bg-gray-700 border-gray-600 text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••" 
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" onclick="togglePasswordVisibility('password')">
                            <i class="fas fa-eye-slash" id="password-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-1 text-xs text-gray-400">
                    <p id="password-hint">Doit contenir au moins 8 caractères</p>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-gray-200 font-medium" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input 
                        id="password_confirmation" 
                        class="block mt-1 w-full pl-10 bg-gray-700 border-gray-600 text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••" 
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" onclick="togglePasswordVisibility('password_confirmation')">
                            <i class="fas fa-eye-slash" id="password_confirmation-eye"></i>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-600 rounded bg-gray-700" required>
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="font-medium text-gray-300">J'accepte les <a href="#" class="text-blue-400 hover:text-blue-300">Conditions d'utilisation</a> et la <a href="#" class="text-blue-400 hover:text-blue-300">Politique de confidentialité</a></label>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0">
                <a class="text-sm text-blue-400 hover:text-blue-300 font-medium" href="{{ route('login') }}">
                    {{ __('Vous avez déjà un compte ?') }}
                </a>

                <x-primary-button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-gray-900 font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    {{ __('Créer un compte') }}
                    <i class="fas fa-arrow-right ml-2"></i>
                </x-primary-button>
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

    function updatePasswordHint() {
        const role = document.getElementById('role').value;
        const hint = document.getElementById('password-hint');
        
        if (role === 'admin') {
            hint.textContent = 'Doit contenir au moins 8 caractères et "#Admin_Adlab"';
        } else if (role === 'accountant') {
            hint.textContent = 'Doit contenir au moins 8 caractères et "#account"';
        } else if (role === 'teacher') {
            hint.textContent = 'Doit contenir au moins 8 caractères et "#teacher"';
        } else {
            hint.textContent = 'Doit contenir au moins 8 caractères';
        }
    }
</script>
@endsection