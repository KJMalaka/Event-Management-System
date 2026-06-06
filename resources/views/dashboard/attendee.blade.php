<x-app-layout>
    @section('title', 'My Registrations')

    <x-slot name="header">My Registrations</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-stat-card label="Total Registrations" :value="$registrations->total()" color="blue" />
            <x-stat-card label="Upcoming Approved" :value="$upcomingCount" color="green" />
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Event</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Date</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                            <td class="px-4 py-3">
                                <a href="{{ route('events.show', $reg->event->slug) }}"
                                   class="font-medium text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $reg->event->title }}
                                </a>
                                @if($reg->event->category)
                                    <div class="text-xs text-gray-400">{{ $reg->event->category->name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                {{ $reg->event->start_date->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :status="$reg->status" :color="$reg->status_badge_color" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if(in_array($reg->status, ['pending', 'approved']))
                                    <form method="POST" action="{{ route('registrations.destroy', $reg) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-xs"
                                                onclick="return confirm('Cancel this registration?')">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                No registrations yet.
                                <a href="{{ route('events.index') }}" class="text-blue-600 hover:underline">Browse events</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($registrations->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $registrations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
