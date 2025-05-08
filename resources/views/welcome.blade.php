@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="min-h-screen bg-white text-gray-800">
    <!-- Hero Section -->
    <section class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-school text-white text-2xl"></i>
                </div>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-4">
                Bienvenue sur EduManage Pro
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                La solution complète pour la gestion scolaire : étudiants, enseignants, paiements et emplois du temps, tout en un seul endroit.
            </p>

            @auth
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                        Aller au Tableau de bord
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="px-6 py-3 bg-white text-gray-700 border border-gray-300 font-semibold rounded-full shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        Gérer mon Profil
                    </a>
                </div>
                <p class="mt-4 text-sm text-gray-500">
                    Connecté en tant que
                    <span class="font-medium text-blue-600">
                    @switch(auth()->user()->role)
                        @case('admin') Administrateur @break
                        @case('teacher') Enseignant @break
                        @case('accountant') Comptable @break
                        @case('student') Étudiant @break
                        @default Utilisateur
                    @endswitch
                    </span>
                </p>
            @else
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se Connecter
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 bg-white text-gray-700 border border-gray-300 font-semibold rounded-full shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        S'Inscrire
                    </a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-4">
                Fonctionnalités Clés
            </h2>
            <p class="text-gray-600 text-center max-w-3xl mx-auto mb-12">
                Découvrez comment EduManage Pro peut simplifier la gestion de votre établissement scolaire
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Gestion des Étudiants</h3>
                    <p class="text-gray-600">
                        Suivez les informations des étudiants, leurs notes et leur présence en toute simplicité.
                    </p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                        <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Support des Enseignants</h3>
                    <p class="text-gray-600">
                        Planifiez les cours, gérez les emplois du temps et attribuez les notes efficacement.
                    </p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-green-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mb-4">
                        <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Gestion des Paiements</h3>
                    <p class="text-gray-600">
                        Suivez les frais scolaires, envoyez des rappels et gérez les transactions en toute sécurité.
                    </p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-alt text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Emplois du Temps</h3>
                    <p class="text-gray-600">
                        Créez et partagez des emplois du temps personnalisés pour étudiants et enseignants.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">
                Ce que disent nos utilisateurs
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold text-xl">M</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Marie Dupont</h4>
                            <p class="text-sm text-gray-500">Directrice d'école</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "EduManage Pro a transformé notre façon de gérer l'école. Tout est centralisé et accessible, ce qui nous fait gagner un temps précieux."
                    </p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                            <span class="text-purple-600 font-bold text-xl">T</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Thomas Martin</h4>
                            <p class="text-sm text-gray-500">Enseignant</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "L'interface est intuitive et me permet de suivre facilement les progrès de mes élèves. La gestion des notes est particulièrement bien pensée."
                    </p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                            <span class="text-green-600 font-bold text-xl">S</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Sophie Bernard</h4>
                            <p class="text-sm text-gray-500">Comptable</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Le module de gestion des paiements est extrêmement efficace. Je peux suivre tous les paiements et générer des rapports en quelques clics."
                    </p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">
                Prêt à Transformer Votre Gestion Scolaire ?
            </h2>
            <p class="text-lg text-blue-100 max-w-2xl mx-auto mb-8">
                Rejoignez des milliers d'écoles qui utilisent EduManage Pro pour simplifier leurs opérations quotidiennes.
            </p>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center">
                    Commencer Maintenant
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center">
                    S'Inscrire Gratuitement
                    <i class="fas fa-user-plus ml-2"></i>
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-4 sm:px-6 lg:px-8 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex justify-center space-x-6 mb-4">
                <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} EduManage Pro. Tous droits réservés.
            </p>
        </div>
    </footer>
</div>
@endsection