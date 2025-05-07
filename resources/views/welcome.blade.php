@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <!-- Hero Section -->
    <section class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-900 to-gray-800">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-md">
                    <i class="fas fa-school text-gray-900 text-2xl"></i>
                </div>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-300 mb-4">
                Bienvenue sur EduManage Pro
            </h1>
            <p class="text-lg sm:text-xl text-gray-400 max-w-3xl mx-auto mb-8">
                La solution complète pour la gestion scolaire : étudiants, enseignants, paiements et emplois du temps, tout en un seul endroit.
            </p>

            @auth
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-gray-900 font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                        Aller au Tableau de bord
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="px-6 py-3 bg-gray-700 text-gray-100 font-semibold rounded-lg shadow-md hover:bg-gray-600 transition-all duration-200">
                        Gérer mon Profil
                    </a>
                </div>
                <p class="mt-4 text-sm text-gray-500">
                    Connecté en tant que
                    @switch(auth()->user()->role)
                        @case('admin') Administrateur @break
                        @case('teacher') Enseignant @break
                        @case('accountant') Comptable @break
                        @case('student') Étudiant @break
                        @default Utilisateur
                    @endswitch
                </p>
            @else
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-gray-900 font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                        Se Connecter
                        <i class="fas fa-sign-in-alt ml-2"></i>
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 bg-gray-700 text-gray-100 font-semibold rounded-lg shadow-md hover:bg-gray-600 transition-all duration-200">
                        S'Inscrire
                    </a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-100 text-center mb-12">
                Fonctionnalités Clés
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 bg-gray-800 rounded-lg shadow-md hover:shadow-blue-500/30 transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center mb-4">
                        <i class="fas fa-user-graduate text-gray-900 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-100 mb-2">Gestion des Étudiants</h3>
                    <p class="text-gray-400 text-sm">
                        Suivez les informations des étudiants, leurs notes et leur présence en toute simplicité.
                    </p>
                </div>
                <div class="p-6 bg-gray-800 rounded-lg shadow-md hover:shadow-blue-500/30 transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center mb-4">
                        <i class="fas fa-chalkboard-teacher text-gray-900 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-100 mb-2">Support des Enseignants</h3>
                    <p class="text-gray-400 text-sm">
                        Planifiez les cours, gérez les emplois du temps et attribuez les notes efficacement.
                    </p>
                </div>
                <div class="p-6 bg-gray-800 rounded-lg shadow-md hover:shadow-blue-500/30 transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center mb-4">
                        <i class="fas fa-money-bill-wave text-gray-900 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-100 mb-2">Gestion des Paiements</h3>
                    <p class="text-gray-400 text-sm">
                        Suivez les frais scolaires, envoyez des rappels et gérez les transactions en toute sécurité.
                    </p>
                </div>
                <div class="p-6 bg-gray-800 rounded-lg shadow-md hover:shadow-blue-500/30 transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-alt text-gray-900 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-100 mb-2">Emplois du Temps</h3>
                    <p class="text-gray-400 text-sm">
                        Créez et partagez des emplois du temps personnalisés pour étudiants et enseignants.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 bg-gray-800">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-100 mb-4">
                Prêt à Transformer Votre Gestion Scolaire ?
            </h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-8">
                Rejoignez des milliers d'écoles qui utilisent EduManage Pro pour simplifier leurs opérations quotidiennes.
            </p>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-gray-900 font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    Commencer Maintenant
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-gray-900 font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    S'Inscrire Gratuitement
                    <i class="fas fa-user-plus ml-2"></i>
                </a>
            @endauth
        </div>
    </section>
</div>
@endsection