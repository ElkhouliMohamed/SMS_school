@extends('layouts.app')

@section('title', 'Vérification de l\'email')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-lg">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-md">
                <i class="fas fa-envelope-open-text text-white text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                Vérifiez votre adresse email
            </h2>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-gray-700">
            <p class="text-sm">
                Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'email, nous vous en enverrons volontiers un autre.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-700">
                        Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie lors de l'inscription.
                    </p>
                </div>
            </div>
        @endif

        <div class="flex flex-col space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    {{ __('Renvoyer l\'email de vérification') }}
                </button>
            </form>

            <div class="text-center pt-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-medium text-blue-600 hover:text-blue-800 transition-colors flex items-center justify-center mx-auto">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Déconnexion') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
