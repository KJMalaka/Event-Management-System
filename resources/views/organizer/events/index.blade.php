@extends('layouts.app-msllkm')

@section('title', 'Organizer Dashboard - EventMS')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="pt-6">
            <h1 class="font-syne font-bold text-3xl sm:text-4xl tracking-tight">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <div class="mt-2 text-sm text-white/70">Your EventMS organizer workspace.</div>
        </div>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                <div class="flex items-center justify-between">
                    <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Total Events</div>
                    <div class="w-12 h-12 rounded-2xl bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--color-accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-3xl font-extrabold text-gold-foil">
                    {{ $totalEvents ?? ($events->count() ?? 0) }}
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                <div class="flex items-center justify-between">
                    <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Published</div>
                    <div class="w-12 h-12 rounded-2xl bg-[var(--color-success-16)] border border-[var(--color-success-35)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--color-success)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-3xl font-extrabold text-gold-foil">
                    {{ $publishedEvents ?? 0 }}
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                <div class="flex items-center justify-between">
                    <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Pending Registrations</div>
                    <div class="w-12 h-12 rounded-2xl bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--color-accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4" />
                            <path d="M12 8h.01" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-3xl font-extrabold text-gold-foil">
                    {{ $pendingRegistrations ?? 0 }}
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-3xl border border-white/10 bg-[var(--color-surface)] overflow-hidden">
            <div class="px-6 py-5 border-b border-white/10">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Your Events</div>
                        <div class="font-syne font-bold text-lg text-white/90">Manage status and capacity</div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-white/5 text-white/70">
                        <tr>
                            <th class="text-left px-6 py-4 font-bold">Title</th>
                            <th class="text-left px-6 py-4 font-bold">Status</th>
                            <th class="text-left px-6 py-4 font-bold">Date</th>
                            <th class="text-left px-6 py-4 font-bold">Capacity</th>
                            <th class="text-left px-6 py-4 font-bold">Pending</th>
                            <th class="text-right px-6 py-4 font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($events ?? collect() as $event)
                            @php
                                $cap = (int) ($event->capacity ?? 0);
                                $approved = (int) ($event->approved_count ?? 0);
                                $pct = $cap > 0 ? ($approved / $cap) * 100 : 0;
                                $miniClass = $pct >= 80 ? 'bg-[var(--color-accent-2)]' : ($pct >= 60 ? 'bg-[var(--color-accent)]' : 'bg-[var(--color-success)]');
                            @endphp
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 font-semibold text-white/90">{{ $event->title }}</td>
                                <td class="px-6 py-4"><x-status-badge-msllkm :status="$event->status" /></td>
                                <td class="px-6 py-4 text-white/70">
                                    @if(!empty($event->start_time))
                                        {{ date('D, d M Y', strtotime($event->start_time)) }}
                                    @else
                                        TBA
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-36">
                                        <div class="h-2 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-2 rounded-full {{ $miniClass }}" style="width: {{ min(100, max(0, $pct)) }}%"></div>
                                        </div>
                                        <div class="mt-2 text-xs text-white/60">{{ round($pct) }}%</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] text-[var(--color-accent)] font-bold text-xs">
                                        {{ $event->pending_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('events.edit', $event->slug ?? $event->id) }}" class="text-xs font-extrabold uppercase tracking-widest text-gold-foil hover:text-white transition">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-white/80 font-extrabold text-lg">No events yet. Create your first →</div>
                                    <div class="mt-2 text-white/60 text-sm">Publish your first SA-grade experience.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

