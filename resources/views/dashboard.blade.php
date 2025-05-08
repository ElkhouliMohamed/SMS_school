@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Bienvenue sur Votre Tableau de Bord</h1>
        <p class="text-gray-600 mt-2">Voici un aperçu de votre système de gestion scolaire.</p>
    </div>

    <!-- Role-Specific Content -->
    @if(auth()->user()->hasRole('admin'))
        <!-- Stats Grid for Admins -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Students Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Étudiants</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $student_count }}</p>
                    <a href="{{ route('students.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center mt-1">
                        <span>Voir tous</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Teachers Card with Link -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Enseignants</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $teacher_count }}</p>
                    <a href="{{ route('teachers.index') }}" class="text-sm text-green-600 hover:text-green-800 flex items-center mt-1">
                        <span>Gérer les enseignants</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Classes Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Classes</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $class_count }}</p>
                    <a href="{{ route('school_classes.index') }}" class="text-sm text-purple-600 hover:text-purple-800 flex items-center mt-1">
                        <span>Voir les classes</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Subjects Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-3 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Matières</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $subject_count }}</p>
                    <a href="{{ route('subjects.index') }}" class="text-sm text-yellow-600 hover:text-yellow-800 flex items-center mt-1">
                        <span>Voir les matières</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Paiements en Attente</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $pending_payments }}</p>
                    <a href="{{ route('payments.index') }}" class="text-sm text-red-600 hover:text-red-800 flex items-center mt-1">
                        <span>Gérer les paiements</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Transports Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-3 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 8h18M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M6 21h12a1 1 0 001-1v-3H5v3a1 1 0 001 1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Transports Actifs</h3>
                    <p class="text-2xl font-bold text-indigo-600">{{ $transport_count }}</p>
                    <a href="{{ route('transports.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center mt-1">
                        <span>Gérer les transports</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Payments Table for Admins -->
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Paiements Récents</h2>
                <a href="{{ route('payments.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                    <span>Voir tous les paiements</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $payment->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            {{ strtoupper(substr($payment->student->first_name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->amount }} MAD</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->status === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @elseif($payment->status === 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Complété
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Échoué
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucun paiement récent trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif(auth()->user()->hasRole('teacher'))
        <!-- Teacher-Specific Content -->
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800">Vos Classes Assignées</h2>
                <p class="text-gray-600 mt-2">Vous êtes actuellement assigné à <span class="font-bold text-purple-600">{{ $assigned_classes }}</span> classe(s).</p>
            </div>

            @if($assigned_classes > 0)
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($teacher_classes as $class)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-purple-100 rounded-full mr-3">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $class->name }}</h3>
                                </div>
                                <div class="ml-10">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Étudiants:</span> {{ $class->students()->count() }}
                                    </p>
                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ route('school_classes.show', $class) }}" class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full hover:bg-purple-200 transition-colors">
                                            Voir les détails
                                        </a>
                                        <a href="{{ route('timetables.index') }}?class={{ $class->id }}" class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full hover:bg-blue-200 transition-colors">
                                            Emploi du temps
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-6 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500">Aucune classe ne vous a été assignée pour le moment.</p>
                </div>
            @endif
        </div>

        <!-- Upcoming Classes -->
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800">Cours à Venir</h2>
                <p class="text-gray-600 mt-2">Votre emploi du temps pour les prochains jours</p>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('timetables.index') }}" class="flex items-center justify-center py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Voir en liste
                </a>
                <a href="{{ route('timetables.calendar') }}" class="flex items-center justify-center py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Voir en calendrier
                </a>
            </div>
        </div>

    @elseif(auth()->user()->hasRole('guardian'))
        <!-- Guardian-Specific Content -->
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800">Vos Élèves</h2>
                <p class="text-gray-600 mt-2">Vous êtes responsable de <span class="font-bold text-blue-600">{{ $ward_count }}</span> élève(s).</p>
            </div>

            @if($ward_count > 0)
                <div class="p-6">
                    <div class="space-y-6">
                        @foreach($wards as $ward)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="bg-blue-50 p-4 border-b border-blue-100">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                            {{ strtoupper(substr($ward->first_name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $ward->first_name }} {{ $ward->last_name }}</h3>
                                            <p class="text-sm text-gray-600">
                                                Classe: {{ $ward->schoolClass->name ?? 'Non assignée' }}
                                            </p>
                                        </div>
                                        <div class="ml-auto flex space-x-2">
                                            <a href="{{ route('students.show', $ward) }}" class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full hover:bg-blue-200 transition-colors">
                                                Profil complet
                                            </a>
                                            <a href="{{ route('absences.index') }}?student={{ $ward->id }}" class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full hover:bg-green-200 transition-colors">
                                                Absences
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Payment Information -->
                                    <div>
                                        <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Paiements
                                        </h4>
                                        @if($ward->payments->isEmpty())
                                            <p class="text-gray-600 italic">Aucun paiement enregistré.</p>
                                        @else
                                            <div class="bg-white rounded-lg border overflow-hidden">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($ward->payments as $payment)
                                                            <tr class="hover:bg-gray-50">
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->amount }} MAD</td>
                                                                <td class="px-3 py-2 whitespace-nowrap">
                                                                    @if($payment->status === 'pending')
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                            En attente
                                                                        </span>
                                                                    @elseif($payment->status === 'completed')
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                            Complété
                                                                        </span>
                                                                    @else
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                            Échoué
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $payment->created_at->format('d M Y') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Transport Information -->
                                    <div>
                                        <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 8h18M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M6 21h12a1 1 0 001-1v-3H5v3a1 1 0 001 1z" />
                                            </svg>
                                            Transport
                                        </h4>
                                        @if($ward->transport)
                                            <div class="bg-white rounded-lg border p-4">
                                                <div class="flex items-center mb-2">
                                                    <span class="font-medium text-gray-700 mr-2">Statut:</span>
                                                    @if($ward->transport->status === 'active')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Actif
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Inactif
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="mb-2">
                                                    <span class="font-medium text-gray-700">Véhicule:</span>
                                                    <span class="text-gray-600 ml-2">{{ $ward->transport->vehicle_number ?? 'N/A' }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-700">Itinéraire:</span>
                                                    <p class="text-gray-600 mt-1">{{ $ward->transport->route_description ?? 'Non spécifié' }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-white rounded-lg border p-4 text-center">
                                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 8h18M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M6 21h12a1 1 0 001-1v-3H5v3a1 1 0 001 1z" />
                                                </svg>
                                                <p class="text-gray-600 italic">Aucun transport assigné.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-6 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-500">Aucun élève n'est assigné à votre compte.</p>
                </div>
            @endif
        </div>

    @else
        <!-- Fallback for Other Roles (e.g., accountant, student) -->
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800">Votre Tableau de Bord</h2>
                <p class="text-gray-600 mt-2">Bienvenue dans le système de gestion scolaire.</p>
            </div>
            <div class="p-6 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <p class="text-gray-500">Votre rôle n'a pas de détails spécifiques configurés pour le tableau de bord.</p>
                <p class="text-gray-500 mt-2">Utilisez le menu de navigation pour accéder aux fonctionnalités disponibles.</p>
            </div>
        </div>
    @endif
</div>
@endsection