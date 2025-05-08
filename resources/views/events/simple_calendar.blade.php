@extends('layouts.app')

@section('title', 'Calendrier des Événements (Version Simplifiée)')

@section('styles')
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

    /* Calendar container */
    .calendar-container {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        background-color: #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 1px;
    }

    /* Calendar header */
    .calendar-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1rem 0.75rem;
        text-align: center;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-size: 0.875rem;
    }

    /* Calendar days */
    .calendar-day {
        background-color: white;
        min-height: 120px;
        padding: 0.75rem;
        position: relative;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .calendar-day:hover {
        background-color: var(--primary-light);
    }

    .calendar-day.other-month {
        background-color: #f9fafb;
    }

    /* Day number */
    .day-number {
        position: absolute;
        top: 0.5rem;
        right: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-color);
        height: 2rem;
        width: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9999px;
    }

    /* Today's date highlight */
    .calendar-day.today .day-number {
        background-color: var(--primary-color);
        color: white;
    }

    /* Events */
    .event {
        margin-top: 2rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 3px solid transparent;
    }

    .event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .event-free {
        background-color: var(--success-color);
        color: white;
        border-left-color: #059669;
    }

    .event-paid {
        background-color: var(--secondary-color);
        color: white;
        border-left-color: #0284C7;
    }

    .event-cancelled {
        background-color: var(--danger-color);
        color: white;
        text-decoration: line-through;
        border-left-color: #B91C1C;
        opacity: 0.8;
    }

    .event-completed {
        background-color: var(--neutral-color);
        color: white;
        border-left-color: #4B5563;
    }

    /* Month navigation */
    .month-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 0.5rem;
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .month-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark-color);
    }

    .nav-button {
        background-color: var(--primary-light);
        color: var(--primary-color);
        border: none;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-button:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .nav-button svg {
        height: 1.25rem;
        width: 1.25rem;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Calendrier des Événements</h1>
        <a href="{{ route('events.index') }}" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
            </svg>
            Retour à la liste
        </a>
    </div>

    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-6 shadow-lg">
        <div class="month-navigation">
            <button class="nav-button" id="prevMonth">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Mois précédent
            </button>
            <h2 class="month-title" id="currentMonth">Chargement...</h2>
            <button class="nav-button" id="nextMonth">
                Mois suivant
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <div class="calendar-container">
            <div class="calendar-header">Lun</div>
            <div class="calendar-header">Mar</div>
            <div class="calendar-header">Mer</div>
            <div class="calendar-header">Jeu</div>
            <div class="calendar-header">Ven</div>
            <div class="calendar-header">Sam</div>
            <div class="calendar-header">Dim</div>

            <!-- Calendar days will be inserted here by JavaScript -->
        </div>
        <div id="calendarDays" style="display: none;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event data from PHP
        const events = [
            @foreach($events as $event)
            {
                id: {{ $event->id }},
                title: "{{ addslashes($event->title) }}",
                start: "{{ $event->start_date->format('Y-m-d\TH:i:s') }}",
                end: "{{ $event->end_date->format('Y-m-d\TH:i:s') }}",
                isFree: {{ $event->is_free ? 'true' : 'false' }},
                status: "{{ $event->status }}",
                url: "{{ route('events.show', $event) }}"
            },
            @endforeach
        ];

        // Current date
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        // DOM elements
        const calendarDays = document.getElementById('calendarDays');
        const currentMonthElement = document.getElementById('currentMonth');
        const prevMonthButton = document.getElementById('prevMonth');
        const nextMonthButton = document.getElementById('nextMonth');

        // Event listeners for navigation buttons
        prevMonthButton.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        nextMonthButton.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        // Format date as YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Get events for a specific day
        function getEventsForDay(date) {
            const dateString = formatDate(date);
            return events.filter(event => {
                const eventStart = event.start.split('T')[0];
                const eventEnd = event.end.split('T')[0];
                return dateString >= eventStart && dateString <= eventEnd;
            });
        }

        // Render the calendar
        function renderCalendar() {
            // Update month title
            const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            currentMonthElement.textContent = `${monthNames[currentMonth]} ${currentYear}`;

            // Get the calendar container
            const calendarContainer = document.querySelector('.calendar-container');

            // Remove all day cells (but keep headers)
            const headers = [];
            for (let i = 0; i < 7; i++) {
                headers.push(calendarContainer.children[i]);
            }

            while (calendarContainer.firstChild) {
                calendarContainer.removeChild(calendarContainer.firstChild);
            }

            // Add headers back
            headers.forEach(header => {
                calendarContainer.appendChild(header);
            });

            // Get first day of month
            const firstDay = new Date(currentYear, currentMonth, 1);
            // Get last day of month
            const lastDay = new Date(currentYear, currentMonth + 1, 0);

            // Get day of week for first day (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
            let firstDayOfWeek = firstDay.getDay();
            // Adjust for Monday as first day of week
            firstDayOfWeek = firstDayOfWeek === 0 ? 6 : firstDayOfWeek - 1;

            // Get days from previous month
            const daysFromPrevMonth = firstDayOfWeek;
            const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();

            // Create calendar grid - Previous month days
            for (let i = 0; i < daysFromPrevMonth; i++) {
                const day = document.createElement('div');
                day.className = 'calendar-day other-month';

                const dayNumber = document.createElement('div');
                dayNumber.className = 'day-number';
                dayNumber.textContent = prevMonthLastDay - daysFromPrevMonth + i + 1;
                day.appendChild(dayNumber);

                calendarContainer.appendChild(day);
            }

            // Current month days
            for (let i = 1; i <= lastDay.getDate(); i++) {
                const day = document.createElement('div');

                // Check if this is today's date
                const today = new Date();
                const isToday = i === today.getDate() &&
                                currentMonth === today.getMonth() &&
                                currentYear === today.getFullYear();

                day.className = isToday ? 'calendar-day today' : 'calendar-day';

                const dayNumber = document.createElement('div');
                dayNumber.className = 'day-number';
                dayNumber.textContent = i;
                day.appendChild(dayNumber);

                // Check for events on this day
                const currentDay = new Date(currentYear, currentMonth, i);
                const dayEvents = getEventsForDay(currentDay);

                dayEvents.forEach(event => {
                    const eventElement = document.createElement('div');
                    eventElement.className = `event ${event.isFree ? 'event-free' : 'event-paid'} ${event.status === 'cancelled' ? 'event-cancelled' : ''} ${event.status === 'completed' ? 'event-completed' : ''}`;
                    eventElement.textContent = event.title;
                    eventElement.addEventListener('click', () => {
                        window.location.href = event.url;
                    });
                    day.appendChild(eventElement);
                });

                calendarContainer.appendChild(day);
            }

            // Next month days to fill the grid
            const totalDaysDisplayed = daysFromPrevMonth + lastDay.getDate();
            const daysFromNextMonth = 7 - (totalDaysDisplayed % 7);

            if (daysFromNextMonth < 7) {
                for (let i = 1; i <= daysFromNextMonth; i++) {
                    const day = document.createElement('div');
                    day.className = 'calendar-day other-month';

                    const dayNumber = document.createElement('div');
                    dayNumber.className = 'day-number';
                    dayNumber.textContent = i;
                    day.appendChild(dayNumber);

                    calendarContainer.appendChild(day);
                }
            }
        }

        // Initial render
        renderCalendar();
    });
</script>
@endsection
