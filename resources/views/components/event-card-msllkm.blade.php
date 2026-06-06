@props(['event'])

@php
    $letter = strtoupper(mb_substr((string) ($event->title ?? 'E'), 0, 1));
@endphp

<article
    class="group bg-[var(--color-surface)] border border-white/10 rounded-2xl overflow-hidden shadow-lg-custom hover:-translate-y-1 transition-transform duration-200"
>
    <div class="h-full w-1 bg-[var(--color-accent)]"></div>

    <div class="-mt-[1.5px]">
        @if(!empty($event->banner_image))
            <div class="h-44 sm:h-48 relative">
                <img
                    src="{{ asset('storage/' . $event->banner_image) }}"
                    alt="Banner for {{ $event->title }} event in South Africa"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.03]"
                    loading="lazy"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-black/0"></div>
            </div>
            @else
            <div class="h-44 sm:h-48 flex items-center justify-center relative card-hero-diagonal">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-black/0"></div>
                <div class="relative">
                    <div class="text-7xl font-extrabold text-gold-foil/90 leading-none">{{ $letter }}</div>
                    <div class="text-xs text-white/70 text-center mt-2 font-bold tracking-widest uppercase">EventMS</div>
                </div>
            </div>
        @endif

        <div class="p-5">
            <div class="flex items-center justify-between gap-3">
                <x-status-badge-msllkm :status="$event->status" />

                <div class="text-right">
                    <div class="text-xs text-[var(--color-muted)]">Price</div>
                    <div class="font-extrabold tracking-wide text-sm text-gold-foil">{{ $event->formatted_price }}</div>
                </div>
            </div>

            <h3 class="mt-3 font-syne font-bold text-xl leading-tight">
                <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="hover:text-[var(--color-accent)] transition">
                    {{ $event->title }}
                </a>
            </h3>

            <div class="mt-3 space-y-2 text-sm text-white/80">
                <div class="flex items-center gap-2">
                    <span aria-hidden="true">📍</span>
                    <span class="line-clamp-1">{{ $event->location }}</span>
                </div>

                @php
                    $start = $event->start_time ?? null;
                    $end = $event->end_time ?? null;
                @endphp

                <div class="flex items-center gap-2">
                    <span aria-hidden="true">🗓️</span>
                    <span class="whitespace-nowrap">
                        {{
                            $start
                                ? 
                                    date('D, d M Y · H:i', is_object($start) ? $start->getTimestamp() : strtotime($start))
                                : 'TBA'
                        }}
                    </span>
                </div>
            </div>

            <div class="mt-5">
                <a
                    href="{{ route('events.show', $event->slug ?? $event->id) }}"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-[var(--color-accent-strong)] text-gold-foil bg-transparent px-4 py-3 text-xs font-extrabold tracking-widest uppercase hover:scale-[1.02] transition"
                >
                    View Details →
                </a>
            </div>
        </div>
    </div>
</article>

