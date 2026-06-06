<x-app-layout>
    @section('title', 'All Events - Admin')

    <x-slot name="header">All Events</x-slot>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Event</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Organizer</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Date</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Registrations</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 dark:text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($events as $event)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                        <td class="px-4 py-3">
                            <a href="{{ route('events.show', $event->slug) }}"
                               class="font-medium text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                                {{ $event->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $event->organizer->name }}</td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $event->start_date->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $event->registrations_count }}</td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$event->status" :color="$event->status_badge_color" />
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('events.edit', $event->slug) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-xs"
                                        onclick="return confirm('Delete this event?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($events->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
