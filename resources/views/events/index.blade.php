@extends('layouts.app-msllkm')

@section('title', 'Explore Events - EventMS')

@section('content')
    <!-- Hero -->
    <section class="relative min-h-[85vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-[var(--color-primary)]"></div>
        <div class="absolute inset-0 hero-diagonal opacity-80"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/0"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="pt-14 pb-10">
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-white/10 bg-white/5">
                    <span class="text-xs font-extrabold tracking-widest uppercase text-[var(--color-accent)]">EventMS ◆ South Africa</span>
                    <span class="h-1 w-1 rounded-full bg-[var(--color-accent)]"></span>
                    <span class="text-xs text-white/70">Music · Theatre · Heritage</span>
                </div>

                <h1 class="mt-6 font-syne font-bold text-4xl sm:text-6xl leading-[1.03]">
                    South Africa's Premier Event Platform
                </h1>
                <p class="mt-5 max-w-2xl text-white/75 text-base sm:text-lg leading-relaxed">
                    Discover iconic venues: <span class="text-gold-foil font-bold">CTICC</span>, <span class="text-gold-foil font-bold">FNB Stadium</span>,
                    <span class="text-gold-foil font-bold">Braamfontein</span>, <span class="text-gold-foil font-bold">Northam</span>,
                    and Heritage Day celebrations—curated like a real SA weekend.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                    <a href="#events" class="inline-flex items-center justify-center rounded-full bg-[var(--color-accent)] text-[var(--color-primary)] font-extrabold tracking-widest uppercase text-xs sm:text-sm px-7 py-4 hover:scale-[1.02] transition">
                        Explore Events ↓
                    </a>
                    <a href="{{ route('events.create') }}" class="inline-flex items-center justify-center rounded-full border border-[var(--color-accent-strong)] text-gold-foil font-extrabold tracking-widest uppercase text-xs sm:text-sm px-7 py-4 hover:bg-white/5 transition">
                        List Your Event
                    </a>
                </div>
            </div>

            <!-- Featured strip -->
            <div class="pb-10">
                <div class="flex items-center gap-3">
                    <div class="h-px flex-1 bg-[var(--color-accent-35)]"></div>
                    <div class="text-xs font-bold tracking-widest uppercase text-[var(--color-muted)]">Featured</div>
                    <div class="h-px flex-1 bg-[var(--color-accent-35)]"></div>
                </div>

                <div class="mt-6">
                    <div class="flex items-center gap-2 text-[var(--color-accent)] font-bold tracking-widest uppercase text-xs">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2l3.1 6.3 7 .9-5.1 4.9 1.2 7-6.2-3.2-6.2 3.2 1.2-7-5.1-4.9 7-.9L12 2z" />
                        </svg>
                        Gold spotlight
                    </div>

                    <div class="mt-4 overflow-x-auto pb-3">
                        <div class="flex gap-4 w-max">
                            @forelse($events->take(3) as $featured)
                                <div class="w-[18rem] sm:w-[22rem]">
                                    <x-event-card-msllkm :event="$featured" />
                                </div>
                            @empty
                                <div class="text-white/60 text-sm">No featured events available</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-center">
                        <div class="h-px w-full bg-[var(--color-accent-35)] relative">
                            <div class="diamond-divider absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- About anchor -->
    <section id="about" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="rounded-3xl border border-white/10 bg-[var(--panel-bg-65)] p-7 md:p-10">
            <h2 class="font-syne font-bold text-2xl sm:text-3xl">Built like a poster. Delivered like a promise.</h2>
            <p class="mt-3 text-white/75 leading-relaxed text-sm sm:text-base">
                EventMS celebrates real South African event culture—Amapiano shows, Cape Town Jazz Festival energy,
                National Arts Festival storytelling, braai culture expos, and Heritage Day pride.
            </p>
        </div>
    </section>

    <!-- All Events -->
    <section id="events" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="flex items-end justify-between gap-4">
            <div>
                <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">All Events</div>
                <h2 class="font-syne font-bold text-2xl sm:text-3xl mt-2">Discover what’s next</h2>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($events->take(6) as $event)
                <x-event-card-msllkm :event="$event" />
            @empty
                <div class="sm:col-span-2 lg:col-span-3 text-center py-20">
                    <div class="text-white/80 font-bold text-lg">No events found</div>
                    <div class="text-white/60 text-sm mt-2">Check back soon—SA weekends don't sleep.</div>
                </div>
            @endforelse
        </div>
    </section>

@endsection