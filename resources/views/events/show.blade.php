@extends('layouts.app-msllkm')

@section('title', $event->title . ' - EventMS')

@section('content')
    <!-- Hero banner -->
    <section class="relative">
        <div class="h-[320px] sm:h-[420px] bg-[var(--color-surface)] border-b border-white/10 overflow-hidden relative">
            @if(!empty($event->banner_image))
                <img
                    src="{{ asset('storage/' . $event->banner_image) }}"
                    alt="Event banner for {{ $event->title }} in South Africa"
                    class="absolute inset-0 w-full h-full object-cover"
                    loading="lazy"
                >
            @else
                <div class="absolute inset-0 hero-diagonal opacity-90"></div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/35 to-black/0"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end pb-10">
                <div class="w-full">
                    <div class="flex items-center gap-3 flex-wrap">
                        <x-status-badge-msllkm :status="$event->status" />
                        <div class="text-gold-foil font-extrabold tracking-wide text-sm">{{ $event->formatted_price }}</div>
                    </div>

                    <h1 class="mt-4 font-syne font-bold text-3xl sm:text-5xl leading-[1.02] text-white">
                        {{ $event->title }}
                    </h1>

                    <div class="mt-4 text-white/75 text-sm sm:text-base flex items-center gap-4 flex-wrap">
                        <span class="inline-flex items-center gap-2">
                            <span aria-hidden="true">📍</span>
                            <span>{{ $event->location }}</span>
                        </span>
                        <span class="opacity-50">|</span>
                        <span class="inline-flex items-center gap-2">
                            <span aria-hidden="true">📅</span>
                            <span>
                                @if(!empty($event->start_time))
                                    {{ date('D, d M Y · H:i', strtotime($event->start_time)) }}
                                @else
                                    TBA
                                @endif
                            </span>
                        </span>
                        <span class="opacity-50">|</span>
                        <span class="inline-flex items-center gap-2">
                            <span aria-hidden="true">🎟</span>
                            <span>{{ $event->formatted_price }}</span>
                        </span>
                        <span class="opacity-50">|</span>
                        <span class="inline-flex items-center gap-2">
                            <span aria-hidden="true">👥</span>
                            <span>
                                {{ $event->approved_count }} / {{ $event->capacity }} spots
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative">
            <div class="rounded-3xl border border-white/10 bg-[var(--panel-bg-70)] backdrop-blur p-5 sm:p-6">
                @php
                    $capacity = (int) ($event->capacity ?? 0);
                    $approved = (int) ($event->approved_count ?? 0);
                    $pct = $capacity > 0 ? ($approved / $capacity) * 100 : 0;
                    $barClass = $pct >= 80 ? 'bg-[var(--color-accent-2)]' : ($pct >= 60 ? 'bg-[var(--color-accent)]' : 'bg-[var(--color-success)]');
                @endphp

                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-white/60 font-bold">Capacity</div>
                        <div class="text-sm text-white/85 mt-1">
                            {{ $approved }} approved • {{ $capacity - $approved }} remaining
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs uppercase tracking-widest text-white/60 font-bold">Booked</div>
                        <div class="text-sm text-gold-foil font-extrabold">{{ round($pct) }}%</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="h-3 sm:h-4 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full {{ $barClass }} rounded-full" style="width: {{ min(100, max(0, $pct)) }}%"></div>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-[10px] uppercase tracking-widest font-bold text-white/50">
                        <span>Green</span>
                        <span>Amber</span>
                        <span>Red</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
                <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6 sm:p-8">
                    <div class="font-bold tracking-widest uppercase text-xs text-[var(--color-muted)]">About this event</div>
                    <div class="mt-4 text-white/85 leading-relaxed text-sm sm:text-base">
                        {!! nl2br(e($event->description ?? '')) !!}
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                        <div class="text-xs uppercase tracking-widest font-bold text-[var(--color-muted)]">Status</div>
                        <div class="mt-3">
                            <x-status-badge-msllkm :status="$event->status" />
                        </div>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                        <div class="text-xs uppercase tracking-widest font-bold text-[var(--color-muted)]">Organizer</div>
                        <div class="mt-3 text-white/85 font-semibold">{{ $event->organizer->name ?? '—' }}</div>
                    </div>
                </div>

                <!-- Related events placeholder -->
                <div class="mt-10">
                    <div class="flex items-center justify-between">
                        <h2 class="font-syne font-bold text-2xl">Related Events</h2>
                        <div class="diamond-divider inline-flex"></div>
                    </div>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @for($i=0;$i<3;$i++)
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                                <div class="h-28 bg-white/5 rounded-xl"></div>
                                <div class="mt-3 text-white/70 font-bold">Coming soon</div>
                                <div class="mt-2 text-white/50 text-sm">More SA culture</div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Action panel -->
            <aside class="lg:col-span-4">
                <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6 sm:p-8">
                    <div class="font-bold tracking-widest uppercase text-xs text-[var(--color-muted)]">Your next step</div>

                    <div class="mt-5 space-y-3">
                        @can('is-attendee')
                            <form method="POST" action="{{ route('events.registrations.store', $event->slug ?? $event->id) }}">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="attendee_id" value="{{ auth()->id() }}">

                                <button type="submit" class="w-full rounded-full bg-[var(--color-accent)] text-[var(--color-primary)] font-extrabold tracking-widest uppercase text-xs px-6 py-4 hover:scale-[1.02] transition">
                                    Register Now
                                </button>
                            </form>
                        @endcan

                        @can('is-organizer')
                            @if(auth()->id() !== ($event->organizer_id ?? null) && !auth()->user()->can('is-admin'))
                                {{-- Organizer can still see their dashboard/actions based on gates --}}
                            @endif

                            <div class="space-y-3">
                                <a href="{{ route('events.edit', $event->slug ?? $event->id) }}" class="w-full text-center rounded-full border border-[var(--color-accent-strong)] text-gold-foil font-extrabold tracking-widest uppercase text-xs px-6 py-3 hover:bg-white/5 hover:scale-[1.02] transition">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('events.publish', $event->slug ?? $event->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Publish this event?')" class="w-full rounded-full bg-white/5 border border-[var(--color-accent-35)] text-white font-extrabold tracking-widest uppercase text-xs px-6 py-3 hover:scale-[1.02] transition">
                                        Publish
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('events.cancel', $event->slug ?? $event->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Cancel this event?')" class="w-full rounded-full bg-[var(--color-accent2-16)] border border-[var(--color-accent2-35)] text-[var(--color-accent-2)] font-extrabold tracking-widest uppercase text-xs px-6 py-3 hover:scale-[1.02] transition">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        @endcan

                        @can('is-admin')
                            <div class="space-y-3">
                                <a href="{{ route('events.edit', $event->slug ?? $event->id) }}" class="w-full text-center rounded-full border border-[var(--color-accent-strong)] text-gold-foil font-extrabold tracking-widest uppercase text-xs px-6 py-3 hover:bg-white/5 hover:scale-[1.02] transition">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('events.publish', $event->slug ?? $event->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Publish this event?')" class="w-full rounded-full bg-white/5 border border-[var(--color-accent-25)] text-white font-extrabold tracking-widest uppercase text-xs px-6 py-3 hover:scale-[1.02] transition">
                                        Publish
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('events.cancel', $event->slug ?? $event->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Cancel this event?')" class="w-full rounded-full bg-[var(--color-accent2-16)] border border-[var(--color-accent2-35)] text-[var(--color-accent-2)] font-extrabold tracking-widest uppercase text-xs px-6 py-3 hover:scale-[1.02] transition">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        @endcan

                        @cannot('is-attendee')
                            @can('is-organizer')
                                <div class="text-xs text-white/60 mt-2">Organizer actions above.</div>
                            @endcan
                            @can('is-admin')
                                <div class="text-xs text-white/60 mt-2">Admin actions above.</div>
                            @endcan
                        @endcannot
                    </div>

                    <div class="mt-6 pt-6 border-t border-white/10 text-sm text-white/70">
                        <div class="flex items-center gap-2">
                            <span aria-hidden="true">🕒</span>
                            <span>
                                Starts: {{ !empty($event->start_time) ? date('d M Y H:i', strtotime($event->start_time)) : 'TBA' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <span aria-hidden="true">📅</span>
                            <span>
                                Ends: {{ !empty($event->end_time) ? date('d M Y H:i', strtotime($event->end_time)) : '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection

