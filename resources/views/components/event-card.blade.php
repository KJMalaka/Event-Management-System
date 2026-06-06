@props(['event'])

<article class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow group">
    @if($event->banner_image)
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $event->banner_image) }}"
                 alt="{{ $event->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </div>
    @else
        <div class="h-48 flex items-center justify-center"
             style="background-color: {{ $event->category?->color ?? '#3B82F6' }}20">
            <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 style="color: {{ $event->category?->color ?? '#3B82F6' }}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    @endif

    <div class="p-5">
        <div class="flex items-center gap-2 mb-2 flex-wrap">
            @if($event->category)
                <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                      style="background-color: {{ $event->category->color }}20; color: {{ $event->category->color }}">
                    {{ $event->category->name }}
                </span>
            @endif
            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                {{ $event->is_free ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200' : 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200' }}">
                {{ $event->formatted_price }}
            </span>
            @if($event->is_full)
                <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200 font-medium">Full</span>
            @endif
        </div>

        <h3 class="font-semibold text-gray-900 dark:text-white text-base mb-1 line-clamp-2">
            <a href="{{ route('events.show', $event->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">
                {{ $event->title }}
            </a>
        </h3>

        <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1 mt-3">
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $event->start_date->format('D, d M Y') }} &middot; {{ $event->start_date->format('H:i') }}
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $event->location }}
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $event->available_spots }} / {{ $event->capacity }} spots left
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <span class="text-xs text-gray-400 dark:text-gray-500">by {{ $event->organizer->name }}</span>
            <a href="{{ route('events.show', $event->slug) }}"
               class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                View &rarr;
            </a>
        </div>
    </div>
</article>
