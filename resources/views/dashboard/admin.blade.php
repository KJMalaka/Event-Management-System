<x-app-layout>
    @section('title', 'Admin Dashboard')

    <x-slot name="header">Admin Dashboard</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <x-stat-card label="Total Events" :value="$stats['total_events']" color="blue" />
            <x-stat-card label="Published" :value="$stats['published_events']" color="green" />
            <x-stat-card label="Total Users" :value="$stats['total_users']" color="purple" />
            <x-stat-card label="Registrations" :value="$stats['total_registrations']" color="yellow" />
            <x-stat-card label="Pending" :value="$stats['pending_registrations']" color="red" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Recent Events</h2>
                    <a href="{{ route('admin.events') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                </div>
                <div class="space-y-3">
                    @foreach($recentEvents as $event)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <a href="{{ route('events.show', $event->slug) }}"
                                   class="font-medium text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $event->title }}
                                </a>
                                <div class="text-xs text-gray-500">by {{ $event->organizer->name }}</div>
                            </div>
                            <x-status-badge :status="$event->status" :color="$event->status_badge_color" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.users') }}"
                       class="flex items-center gap-2 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/50 text-sm font-medium transition">
                        Users
                    </a>
                    <a href="{{ route('admin.events') }}"
                       class="flex items-center gap-2 p-3 rounded-lg bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-100 text-sm font-medium transition">
                        All Events
                    </a>
                    <a href="{{ route('admin.categories') }}"
                       class="flex items-center gap-2 p-3 rounded-lg bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 hover:bg-purple-100 text-sm font-medium transition">
                        Categories
                    </a>
                    <a href="{{ route('events.create') }}"
                       class="flex items-center gap-2 p-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 hover:bg-yellow-100 text-sm font-medium transition">
                        Create Event
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h2>
            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                @forelse($recentLogs as $log)
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $log->user?->name ?? 'System' }}</span>
                            &mdash; {{ str_replace('.', ' ', $log->action) }}
                            @if(!empty($log->properties['title']))
                                <span class="text-gray-400">&ldquo;{{ $log->properties['title'] }}&rdquo;</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 shrink-0 ml-2">{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-gray-400">No activity yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
