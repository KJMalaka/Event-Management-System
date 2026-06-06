<x-app-layout>
    @section('title', 'Manage Registrations')

    <x-slot name="header">Registrations: {{ $event->title }}</x-slot>

    <div class="space-y-4">
        <a href="{{ route('events.show', $event->slug) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600">
            &larr; Back to Event
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Attendee</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Registered</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Notes</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800 dark:text-gray-200">{{ $reg->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $reg->user->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                {{ $reg->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400 max-w-xs">
                                {{ $reg->notes ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :status="$reg->status" :color="$reg->status_badge_color" />
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if($reg->status === 'pending')
                                    <form method="POST" action="{{ route('registrations.approve', $reg) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:underline text-xs font-medium">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('registrations.decline', $reg) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-500 hover:underline text-xs font-medium">Decline</button>
                                    </form>
                                @elseif($reg->status === 'approved')
                                    <form method="POST" action="{{ route('registrations.decline', $reg) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-500 hover:underline text-xs font-medium">Revoke</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">No registrations yet.</td>
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
