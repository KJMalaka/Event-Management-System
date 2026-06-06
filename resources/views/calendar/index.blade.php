<x-app-layout>
    @section('title', 'Event Calendar - ' . config('app.name'))

    <x-slot name="header">Event Calendar</x-slot>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div id="calendar"></div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
        <style>
            .fc-event { cursor: pointer; border-radius: 4px; }
            .dark .fc-theme-standard td, .dark .fc-theme-standard th, .dark .fc-theme-standard .fc-scrollgrid { border-color: #374151; }
            .dark .fc-col-header-cell { background-color: #1f2937; color: #d1d5db; }
            .dark .fc-daygrid-day { background-color: #111827; }
            .dark .fc-day-today { background-color: #1e3a5f !important; }
            .dark .fc-toolbar-title, .dark .fc-col-header-cell-cushion, .dark .fc-daygrid-day-number { color: #f3f4f6; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left:   'prev,next today',
                        center: 'title',
                        right:  'dayGridMonth,listWeek'
                    },
                    events: '{{ route('calendar.data') }}',
                    eventClick: function (info) {
                        window.location.href = info.event.url;
                        info.jsEvent.preventDefault();
                    },
                    height: 'auto',
                    eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                });
                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
