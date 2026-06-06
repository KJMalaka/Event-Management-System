<x-app-layout>
    @section('title', 'Organizer Dashboard')

    <x-slot name="header">My Events</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <x-stat-card label="Total Events" :value="$stats['total_events']" color="blue" />
            <x-stat-card label="Published" :value="$stats['published']" color="green" />
            <x-stat-card label="Approved Attendees" :value="$stats['total_attendees']" color="purple" />
            <x-stat-card label="Pending Approvals" :value="$stats['pending']" color="yellow" />
        </div>

        <div class="flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">My Events</h2>
            <a href="{{ route('events.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + New Event
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Event</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Date</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Registrations</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                            <td class="px-4 py-3">
                                <a href="{{ route('events.show', $event->slug) }}"
                                   class="font-medium text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $event->title }}
                                </a>
                                @if($event->category)
                                    <div class="text-xs text-gray-400">{{ $event->category->name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                {{ $event->start_date->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :status="$event->status" :color="$event->status_badge_color" />
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                {{ $event->registrations_count }}
                                @if($event->registrations->where('status', 'pending')->count() > 0)
                                    <span class="ml-1 text-yellow-600 dark:text-yellow-400 text-xs">
                                        ({{ $event->registrations->where('status', 'pending')->count() }} pending)
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('events.registrations.index', $event->slug) }}"
                                   class="text-blue-600 hover:underline text-xs">Registrations</a>
                                <a href="{{ route('events.edit', $event->slug) }}"
                                   class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xs">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                No events yet. <a href="{{ route('events.create') }}" class="text-blue-600 hover:underline">Create your first event</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($events->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
