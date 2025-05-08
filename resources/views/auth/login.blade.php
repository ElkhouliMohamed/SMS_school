@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-lg">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-md">
                <i class="fas fa-school text-white text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                EduManage Pro
            </h2>
            <p class="mt-2 text-sm text-gray-600">Connectez-vous à votre compte</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg" :status="session('status')" />

        <!-- Test User Credentials (Development Only) -->
        @if (app()->environment('local') || app()->environment('testing'))
            <div class="mb-4 p-4 bg-blue-50 rounded-lg text-sm text-gray-700 border border-blue-100">
                <p class="font-semibold text-blue-700">Identifiants de test (Développement uniquement):</p>
                <ul class="list-disc ml-5 mt-2 space-y-1">
                    <li>Admin: <span class="font-mono text-purple-600">admin@example.com</span> / password123</li>
                    <li>Teacher: <span class="font-mono text-purple-600">teacher@example.com</span> / password123</li>
                    <li>Accountant: <span class="font-mono text-purple-600">accountant@example.com</span> / password123</li>
                    <li>Test Guardian: <span class="font-mono text-purple-600">guardian@example.com</span> / password123</li>
                    <li>Student: <span class="font-mono text-purple-600">mohamedelkhouli@gmail.com</span> / password123</li>
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <x-text-input id="email"
                                 class="block w-full pl-10 border-gray-300 text-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                 type="email"
                                 name="email"
                                 :value="old('email')"
                                 required
                                 autofocus
                                 autocomplete="username"
                                 placeholder="votre@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-medium" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input id="password"
                                 class="block w-full pl-10 border-gray-300 text-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                 type="password"
                                 name="password"
                                 required
                                 autocomplete="current-password"
                                 placeholder="••••••••" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePasswordVisibility('password')">
                            <i class="fas fa-eye-slash" id="password-eye"></i>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                       name="remember">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</label>
            </div>

            <!-- Submit and Forgot Password -->
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-800 transition-colors"
                       href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif

                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    {{ __('Se connecter') }}
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center pt-4 mt-6 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    {{ __('Vous n\'avez pas de compte ?') }}
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800 transition-colors">
                        {{ __('Créer un compte') }}
                    </a>
                </p>
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