@extends('layouts.app-msllkm')

@section('title', 'Admin Control Room - EventMS')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="pt-6">
            <h1 class="font-syne font-bold text-3xl sm:text-4xl">
                Admin Control Room
            </h1>
            <div class="mt-2 text-sm text-white/70">Oversight for SA event culture—kept clean, fast, and fair.</div>
        </div>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Total Users</div>
                        <div class="mt-3 text-3xl font-extrabold text-gold-foil">{{ $totalUsers ?? 0 }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--color-accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 00-3-3.87" />
                            <path d="M16 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Total Events</div>
                        <div class="mt-3 text-3xl font-extrabold text-gold-foil">{{ $totalEvents ?? 0 }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--color-accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Pending Registrations</div>
                        <div class="mt-3 text-3xl font-extrabold text-gold-foil">{{ $pendingRegistrations ?? 0 }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--color-accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4" />
                            <path d="M12 8h.01" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Revenue Estimate</div>
                        <div class="mt-3 text-3xl font-extrabold text-gold-foil">{{ $revenueEstimate ?? 'R 0.00' }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--color-accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 1v22" />
                            <path d="M17 5H9.5a3.5 3.5 0 000 7H14a3 3 0 010 6H6" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] overflow-hidden">
                <div class="px-6 py-5 border-b border-white/10">
                    <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Recent Events</div>
                    <div class="mt-2 text-sm text-white/70">Last 10 events across all statuses.</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-white/5 text-white/70">
                            <tr>
                                <th class="text-left px-6 py-4 font-bold">Title</th>
                                <th class="text-left px-6 py-4 font-bold">Status</th>
                                <th class="text-left px-6 py-4 font-bold">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($recentEvents ?? collect() as $event)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-4 font-semibold text-white/90">{{ $event->title }}</td>
                                    <td class="px-6 py-4"><x-status-badge-msllkm :status="$event->status" /></td>
                                    <td class="px-6 py-4 text-white/70">
                                        {{ !empty($event->start_time) ? date('D, d M Y', strtotime($event->start_time)) : 'TBA' }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-12 text-center text-white/60">No recent events.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] overflow-hidden">
                <div class="px-6 py-5 border-b border-white/10">
                    <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Recent Registrations</div>
                    <div class="mt-2 text-sm text-white/70">Last 10 registrations across all events.</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-white/5 text-white/70">
                            <tr>
                                <th class="text-left px-6 py-4 font-bold">Attendee</th>
                                <th class="text-left px-6 py-4 font-bold">Event</th>
                                <th class="text-left px-6 py-4 font-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($recentRegistrations ?? collect() as $reg)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-4 font-semibold text-white/90">{{ $reg->user->name ?? '—' }}</td>
                                    <td class="px-6 py-4 text-white/70">{{ $reg->event->title ?? '—' }}</td>
                                    <td class="px-6 py-4"><x-registration-status-badge-msllkm :status="$reg->status" /></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-12 text-center text-white/60">No recent registrations.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

