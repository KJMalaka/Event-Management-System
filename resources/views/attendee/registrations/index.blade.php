@extends('layouts.app-msllkm')

@section('title', 'My Tickets - EventMS')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="pt-6 flex items-start justify-between gap-4 flex-wrap">
            <div>
                <h1 class="font-syne font-bold text-3xl sm:text-4xl">🎟 My Tickets</h1>
                <div class="mt-2 text-sm text-white/70">Track your approved event registrations.</div>
            </div>
        </div>

        <div class="mt-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($registrations ?? collect() as $reg)
                    @php
                        $event = $reg->event ?? ($reg->event ?? null);
                        $eventTitle = $event->title ?? 'Event';
                        $eventVenue = $event->location ?? 'South Africa';
                        $dateLabel = !empty($event->start_time) ? date('D, d M Y · H:i', strtotime($event->start_time)) : 'TBA';
                    @endphp

                    <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6 hover:-translate-y-1 transition-transform duration-200">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="text-xs uppercase tracking-widest font-bold text-[var(--color-muted)]">Ticket Status</div>
                                <div class="mt-2"><x-registration-status-badge-msllkm :status="$reg->status" /></div>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                                <span class="text-gold-foil font-extrabold">◆</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="font-syne font-bold text-xl leading-tight text-white/95">{{ $eventTitle }}</div>
                            <div class="mt-2 text-white/70 text-sm flex items-center gap-2">
                                <span aria-hidden="true">📍</span>
                                <span class="line-clamp-1">{{ $eventVenue }}</span>
                            </div>
                            <div class="mt-2 text-white/70 text-sm flex items-center gap-2">
                                <span aria-hidden="true">📅</span>
                                <span>{{ $dateLabel }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            @if($reg->status === 'pending')
                                <form method="POST" action="{{ route('registrations.destroy', $reg->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full rounded-full border border-[var(--color-accent2-35)] text-[var(--color-accent-2)] font-extrabold tracking-widest uppercase text-xs px-5 py-3 hover:bg-white/5 transition" onclick="return confirm('Cancel this registration?')">
                                        Cancel Registration
                                    </button>
                                </form>
                            @elseif($reg->status === 'approved')
                                <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="w-full inline-flex items-center justify-center rounded-full bg-white/5 border border-[var(--color-accent-35)] text-gold-foil font-extrabold tracking-widest uppercase text-xs px-5 py-3 hover:bg-white/10 hover:scale-[1.02] transition">
                                    View Event →
                                </a>
                            @else
                                <div class="text-center text-sm text-white/60">Ticket declined.</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 text-center py-20 rounded-3xl border border-white/10 bg-[var(--color-surface)]">
                        <div class="text-white/80 font-extrabold text-lg">You haven't registered for any events yet. Browse Events →</div>
                        <div class="mt-3">
                            <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center rounded-full bg-[var(--color-accent)] text-[var(--color-primary)] font-extrabold tracking-widest uppercase text-xs px-6 py-4 hover:scale-[1.02] transition">
                                Browse Events
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

