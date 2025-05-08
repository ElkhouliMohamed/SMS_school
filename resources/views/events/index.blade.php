@extends('layouts.app')

@section('title', 'Événements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Événements</h1>
        @hasrole('admin|teacher')
        <a href="{{ route('events.create') }}" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Ajouter un Événement
        </a>
        @endhasrole
    </div>

    <div class="flex justify-end mb-4 space-x-2">
        <a href="{{ route('events.calendar') }}" class="flex items-center bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
            </svg>
            Vue Calendrier
        </a>
        <a href="{{ route('events.simple_calendar') }}" class="flex items-center bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
            </svg>
            Calendrier Simplifié
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(count($events) > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        @if($event->image)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        @endif

                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h2>
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($event->status == 'upcoming') bg-blue-100 text-blue-800
                                    @elseif($event->status == 'ongoing') bg-green-100 text-green-800
                                    @elseif($event->status == 'completed') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>

                            <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($event->description, 100) }}</p>

                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $event->start_date->format('d/m/Y H:i') }}
                            </div>

                            @if($event->location)
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            @endif

                            <div class="flex items-center text-sm mb-4">
                                @if($event->is_free)
                                    <span class="text-green-600 font-semibold">Gratuit</span>
                                @else
                                    <span class="text-blue-600 font-semibold">{{ number_format($event->price, 2) }} MAD</span>
                                @endif

                                @if($event->capacity)
                                    <span class="ml-auto text-gray-500">
                                        <span class="font-medium">{{ $event->registered_count }}/{{ $event->capacity }}</span> inscrits
                                    </span>
                                @endif
                            </div>

                            <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Voir les détails
                                </a>
                                <span class="text-xs text-gray-500">
                                    Par {{ $event->creator->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-6 py-4">
                {{ $events->links() }}
            </div>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun événement disponible</h3>
            <p class="text-gray-500 mb-4">Il n'y a actuellement aucun événement programmé.</p>

            @hasrole('admin|teacher')
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Créer un événement
            </a>
            @endhasrole
        </div>
    @endif
</div>
@endsection
