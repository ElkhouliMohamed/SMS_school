@extends('layouts.app')

@section('title', 'Login')

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
            <p class="mt-2 text-sm text-gray-400">Connectez-vous à votre compte</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-sm text-green-400" :status="session('status')" />

        <!-- Test User Credentials (Development Only) -->
        @if (app()->environment('local') || app()->environment('testing'))
            <div class="mb-4 p-4 bg-gray-700 rounded-lg text-sm text-gray-300">
                <p class="font-semibold">Test Credentials (Development Only):</p>
                <ul class="list-disc ml-5">
                    <li>Admin: <span class="font-mono">admin@example.com</span> / password123</li>
                    <li>Teacher: <span class="font-mono">teacher@example.com</span> / password123</li>
                    <li>Accountant: <span class="font-mono">accountant@example.com</span> / password123</li>
                    <li>Test Guardian: <span class="font-mono">guardian@example.com</span> / password123</li>
                    <li>Student: <span class="font-mono">mohamedelkhouli@gmail.com</span> / password123</li>
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-200 font-medium" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <x-text-input id="email" 
                                 class="block mt-1 w-full pl-10 bg-gray-700 border-gray-600 text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                 type="email" 
                                 name="email" 
                                 :value="old('email')" 
                                 required 
                                 autofocus 
                                 autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-200 font-medium" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input id="password" 
                                 class="block mt-1 w-full pl-10 bg-gray-700 border-gray-600 text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                 type="password" 
                                 name="password" 
                                 required 
                                 autocomplete="current-password" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" onclick="togglePasswordVisibility('password')">
                            <i class="fas fa-eye-slash" id="password-eye"></i>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       class="w-4 h-4 rounded border-gray-600 text-blue-600 bg-gray-700 focus:ring-blue-500" 
                       name="remember">
                <label for="remember_me" class="ml-2 text-sm text-gray-300">{{ __('Remember me') }}</label>
            </div>

            <!-- Submit and Forgot Password -->
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-400 hover:text-blue-300 transition-colors" 
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-gray-900 font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    {{ __('Log in') }}
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
</script>
@endsection