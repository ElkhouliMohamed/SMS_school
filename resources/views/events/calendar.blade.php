@extends('layouts.app')

@section('title', 'Calendrier des Événements')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
    :root {
        --primary-color: #4F46E5;
        --primary-light: #EEF2FF;
        --secondary-color: #0EA5E9;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --neutral-color: #6B7280;
        --dark-color: #1F2937;
        --light-color: #F9FAFB;
    }

    /* Calendar container styles */
    .calendar-wrapper {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .calendar-wrapper:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Ensure the calendar has a minimum height */
    #calendar {
        min-height: 650px;
        height: 100%;
    }

    /* FullCalendar custom styles */
    .fc .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark-color);
    }

    .fc .fc-button-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .fc .fc-button-primary:hover {
        background-color: #4338CA;
        border-color: #4338CA;
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active,
    .fc .fc-button-primary:not(:disabled):active {
        background-color: #3730A3;
        border-color: #3730A3;
    }

    .fc .fc-daygrid-day-number,
    .fc .fc-col-header-cell-cushion {
        color: var(--dark-color);
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: var(--primary-light);
    }

    .fc .fc-col-header-cell {
        background-color: #F3F4F6;
        padding: 0.75rem 0;
    }

    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #E5E7EB;
    }

    /* Event styles */
    .fc-event {
        cursor: pointer;
        border-radius: 0.375rem;
        border-width: 0;
        padding: 0.125rem 0.375rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .fc-event-title {
        font-weight: 600;
        font-size: 0.75rem;
    }

    .fc-event-time {
        font-weight: 400;
        font-size: 0.7rem;
        opacity: 0.8;
    }

    .event-free {
        background-color: var(--success-color);
        border-left: 3px solid #059669;
    }

    .event-paid {
        background-color: var(--secondary-color);
        border-left: 3px solid #0284C7;
    }

    .event-cancelled {
        background-color: var(--danger-color);
        border-left: 3px solid #B91C1C;
        text-decoration: line-through;
        opacity: 0.8;
    }

    .event-completed {
        background-color: var(--neutral-color);
        border-left: 3px solid #4B5563;
    }

    /* Tooltip styles */
    .event-tooltip {
        position: fixed;
        z-index: 1000;
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        padding: 1.25rem;
        max-width: 400px;
        width: 400px;
        display: none;
        border-top: 5px solid var(--primary-color);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        backdrop-filter: blur(12px);
        animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translate(-50%, -45%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
    }

    .event-tooltip .close-button {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background-color: #F3F4F6;
        border-radius: 9999px;
        width: 1.75rem;
        height: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease;
    }

    .event-tooltip .close-button:hover {
        background-color: #E5E7EB;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Calendrier des Événements</h1>
        <div class="flex space-x-2">
            <a href="{{ route('events.simple_calendar') }}" class="flex items-center bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
                Version simplifiée
            </a>
            <a href="{{ route('events.index') }}" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="calendar-wrapper p-6">
        <div id="calendar"></div>
    </div>

    <div id="eventTooltip" class="event-tooltip">
        <button onclick="document.getElementById('eventTooltip').style.display='none'" class="close-button">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <div class="flex justify-between items-start mb-4">
            <h3 id="tooltipTitle" class="text-xl font-bold text-gray-900">Titre de l'événement</h3>
            <span id="tooltipStatus" class="ml-2 px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Statut</span>
        </div>

        <div class="bg-gray-50 rounded-lg p-3 mb-4">
            <div class="flex items-center text-sm text-gray-700 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span id="tooltipDate" class="font-medium"></span>
            </div>
            <div id="tooltipLocation" class="flex items-center text-sm text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span id="tooltipLocationText" class="font-medium"></span>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <span id="tooltipPrice" class="text-lg font-bold text-blue-600"></span>
            <a id="tooltipLink" href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Voir les détails
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/fr.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');

        try {
            const calendarEl = document.getElementById('calendar');
            const tooltip = document.getElementById('eventTooltip');

            // Créer un tableau d'événements à partir des données PHP
            const events = [
                @foreach($events as $event)
                {
                    id: '{{ $event->id }}',
                    title: '{{ addslashes($event->title) }}',
                    start: '{{ $event->start_date->format('Y-m-d\TH:i:s') }}',
                    end: '{{ $event->end_date->format('Y-m-d\TH:i:s') }}',
                    classNames: [
                        '{{ $event->is_free ? "event-free" : "event-paid" }}',
                        '{{ $event->status == "cancelled" ? "event-cancelled" : "" }}',
                        '{{ $event->status == "completed" ? "event-completed" : "" }}'
                    ],
                    extendedProps: {
                        status: '{{ $event->status }}',
                        location: '{{ addslashes($event->location) }}',
                        price: '{{ $event->is_free ? "Gratuit" : number_format($event->price, 2) . " MAD" }}',
                        url: '{{ route("events.show", $event) }}'
                    }
                },
                @endforeach
            ];

            // Initialiser le calendrier
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                locale: 'fr',
                events: events,
                eventClick: function(info) {
                    window.location.href = info.event.extendedProps.url;
                },
                eventMouseEnter: function(info) {
                    const event = info.event;
                    const rect = info.el.getBoundingClientRect();

                    document.getElementById('tooltipTitle').textContent = event.title;

                    const statusEl = document.getElementById('tooltipStatus');
                    statusEl.textContent = event.extendedProps.status.charAt(0).toUpperCase() + event.extendedProps.status.slice(1);

                    if (event.extendedProps.status === 'upcoming') {
                        statusEl.className = 'px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800';
                    } else if (event.extendedProps.status === 'ongoing') {
                        statusEl.className = 'px-2 py-1 text-xs rounded-full bg-green-100 text-green-800';
                    } else if (event.extendedProps.status === 'completed') {
                        statusEl.className = 'px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800';
                    } else {
                        statusEl.className = 'px-2 py-1 text-xs rounded-full bg-red-100 text-red-800';
                    }

                    const startDate = new Date(event.start);
                    const endDate = new Date(event.end);

                    const formatDate = (date) => {
                        return date.toLocaleDateString('fr-FR', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    };

                    document.getElementById('tooltipDate').textContent = `${formatDate(startDate)} - ${formatDate(endDate)}`;

                    const locationEl = document.getElementById('tooltipLocation');
                    const locationTextEl = document.getElementById('tooltipLocationText');

                    if (event.extendedProps.location) {
                        locationTextEl.textContent = event.extendedProps.location;
                        locationEl.style.display = 'flex';
                    } else {
                        locationEl.style.display = 'none';
                    }

                    document.getElementById('tooltipPrice').textContent = event.extendedProps.price;
                    document.getElementById('tooltipLink').href = event.extendedProps.url;

                    tooltip.style.display = 'block';
                },
                eventMouseLeave: function() {
                    tooltip.style.display = 'none';
                }
            });

            // Afficher le calendrier
            calendar.render();
            console.log('Calendar rendered successfully');
        } catch (error) {
            console.error('Error initializing calendar:', error);
            document.getElementById('calendar').innerHTML = '<div class="p-4 bg-red-100 text-red-700 rounded">Erreur lors de l\'initialisation du calendrier: ' + error.message + '</div>';
        }
    });
</script>
@endsection
