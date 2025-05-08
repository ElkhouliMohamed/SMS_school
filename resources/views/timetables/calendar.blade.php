@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Emploi du Temps - Vue Calendrier</h1>
        <div class="flex space-x-2">
            <a href="{{ route('timetables.index') }}" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Vue Liste
            </a>
            @hasrole('admin|teacher')
            <a href="{{ route('timetables.create') }}" class="flex items-center bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un Cours
            </a>
            @endhasrole
        </div>
    </div>

    <!-- Class Filter -->
    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form action="{{ route('timetables.calendar') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-grow">
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par Classe</label>
                <select name="class_id" id="class_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                    <option value="">Toutes les Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0 self-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Calendar View -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Horaire</th>
                        @foreach($days as $day)
                            @php
                                $frenchDays = [
                                    'Monday' => 'Lundi',
                                    'Tuesday' => 'Mardi',
                                    'Wednesday' => 'Mercredi',
                                    'Thursday' => 'Jeudi',
                                    'Friday' => 'Vendredi',
                                    'Saturday' => 'Samedi',
                                    'Sunday' => 'Dimanche'
                                ];
                            @endphp
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $frenchDays[$day] ?? $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($timeSlots as $timeSlot)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r">
                                {{ $timeSlot }}
                            </td>
                            @foreach($days as $day)
                                <td class="px-2 py-2 text-sm text-gray-500 border-r">
                                    @if(isset($calendarData[$day][$timeSlot]) && $calendarData[$day][$timeSlot])
                                        @php $timetable = $calendarData[$day][$timeSlot]; @endphp
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-2 hover:bg-blue-100 transition-colors">
                                            <div class="font-medium text-blue-800">{{ $timetable->subject->name }}</div>
                                            <div class="text-xs text-gray-600">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                    {{ $timetable->teacher->first_name }} {{ $timetable->teacher->last_name }}
                                                </div>
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $timetable->start_time->format('H:i') }} - {{ $timetable->end_time->format('H:i') }}
                                                </div>
                                                @if($timetable->room)
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    {{ $timetable->room }}
                                                </div>
                                                @endif
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    {{ $timetable->schoolClass->name }}
                                                </div>
                                            </div>
                                            <div class="mt-1 flex justify-end space-x-1">
                                                <a href="{{ route('timetables.show', $timetable) }}" class="text-xs text-blue-600 hover:text-blue-800">
                                                    Détails
                                                </a>
                                                @hasrole('admin|teacher')
                                                <a href="{{ route('timetables.edit', $timetable) }}" class="text-xs text-yellow-600 hover:text-yellow-800">
                                                    Modifier
                                                </a>
                                                @endhasrole
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Custom styles for the calendar view */
    @media (max-width: 640px) {
        .overflow-x-auto {
            overflow-x: auto;
        }
    }
</style>
@endsection
