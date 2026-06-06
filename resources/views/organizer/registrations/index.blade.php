@extends('layouts.app-msllkm')

@section('title', 'Organizer Registrations - EventMS')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="pt-6">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-extrabold uppercase tracking-widest text-white/70 hover:text-[var(--color-accent)] transition">
                    <span aria-hidden="true">←</span> Back
                </a>

                <div class="text-right">
                    <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Event</div>
                    <div class="font-syne font-bold text-2xl">{{ $event->title ?? 'Registrations' }}</div>
                </div>
            </div>
        </div>

        @php
            $pending = $registrations->where('status', 'pending') ?? collect();
            $approved = $registrations->where('status', 'approved') ?? collect();
            $declined = $registrations->where('status', 'declined') ?? collect();
        @endphp

        <div class="mt-8">
            <div class="flex gap-2 flex-wrap">
                <a href="#pending" class="px-5 py-3 rounded-full border border-white/10 bg-white/5 hover:bg-white/10 transition text-xs font-extrabold tracking-widest uppercase">
                    Pending <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] text-[var(--color-accent)]">{{ $pending->count() }}</span>
                </a>
                <a href="#approved" class="px-5 py-3 rounded-full border border-white/10 bg-white/5 hover:bg-white/10 transition text-xs font-extrabold tracking-widest uppercase">
                    Approved <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-[var(--color-success-16)] border border-[var(--color-success-35)] text-[var(--color-success)]">{{ $approved->count() }}</span>
                </a>
                <a href="#declined" class="px-5 py-3 rounded-full border border-white/10 bg-white/5 hover:bg-white/10 transition text-xs font-extrabold tracking-widest uppercase">
                    Declined <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-[var(--color-accent2-16)] border border-[var(--color-accent2-35)] text-[var(--color-accent-2)]">{{ $declined->count() }}</span>
                </a>
            </div>
        </div>

        <div class="mt-6">
            {{-- Panels via anchors --}}
            <div id="pending" class="scroll-mt-24">
                <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] overflow-hidden">
                    <div class="px-6 py-5 border-b border-white/10">
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Pending</div>
                        <div class="mt-2 text-sm text-white/70">Review notes and approve/decline registrations.</div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-white/5 text-white/70">
                                <tr>
                                    <th class="text-left px-6 py-4 font-bold">Attendee</th>
                                    <th class="text-left px-6 py-4 font-bold">Email</th>
                                    <th class="text-left px-6 py-4 font-bold">Registered On</th>
                                    <th class="text-left px-6 py-4 font-bold">Status</th>
                                    <th class="text-right px-6 py-4 font-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($pending as $reg)
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="px-6 py-4 font-semibold text-white/90">{{ $reg->user->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-white/70">{{ $reg->user->email ?? '—' }}</td>
                                        <td class="px-6 py-4 text-white/70">{{ method_exists($reg,'created_at') && $reg->created_at ? $reg->created_at->format('d M Y H:i') : '—' }}</td>
                                        <td class="px-6 py-4"><x-registration-status-badge-msllkm :status="$reg->status" /></td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="space-y-3">
                                                <details class="group">
                                                    <summary class="cursor-pointer list-none text-xs font-extrabold tracking-widest uppercase text-white/70 hover:text-white transition">
                                                        <span class="inline-flex items-center gap-2">
                                                            <span aria-hidden="true">Notes</span>
                                                        </span>
                                                    </summary>
                                                    <div class="mt-3">
                                                        <label class="sr-only" for="notes-{{ $reg->id }}">Notes</label>
                                                        <textarea id="notes-{{ $reg->id }}" name="notes" rows="3" class="w-full rounded-2xl bg-white/5 border border-white/10 text-white/80 p-3 text-sm" placeholder="Add review notes..."></textarea>
                                                    </div>
                                                </details>

                                                <div class="flex items-center justify-end gap-2">
                                                    <form method="POST" action="{{ route('registrations.approve', $reg->id) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="rounded-full border border-[var(--color-success-35)] text-[var(--color-success)] px-4 py-2 text-xs font-extrabold tracking-widest uppercase hover:bg-white/5 transition">
                                                            Approve
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('registrations.decline', $reg->id) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" onclick="return confirm('Decline this registration?')" class="rounded-full border border-[var(--color-accent2-35)] text-[var(--color-accent-2)] px-4 py-2 text-xs font-extrabold tracking-widest uppercase hover:bg-white/5 transition">
                                                            Decline
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($pending->isEmpty())
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-white/80 font-extrabold text-lg">No pending registrations.</div>
                                            <div class="mt-2 text-white/60 text-sm">Your lineup is looking good.</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="approved" class="scroll-mt-24 mt-10">
                <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] overflow-hidden">
                    <div class="px-6 py-5 border-b border-white/10">
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Approved</div>
                        <div class="mt-2 text-sm text-white/70">Approved attendees for this event.</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-white/5 text-white/70">
                                <tr>
                                    <th class="text-left px-6 py-4 font-bold">Attendee</th>
                                    <th class="text-left px-6 py-4 font-bold">Email</th>
                                    <th class="text-left px-6 py-4 font-bold">Registered On</th>
                                    <th class="text-left px-6 py-4 font-bold">Status</th>
                                    <th class="text-right px-6 py-4 font-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($approved as $reg)
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="px-6 py-4 font-semibold text-white/90">{{ $reg->user->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-white/70">{{ $reg->user->email ?? '—' }}</td>
                                        <td class="px-6 py-4 text-white/70">{{ method_exists($reg,'created_at') && $reg->created_at ? $reg->created_at->format('d M Y H:i') : '—' }}</td>
                                        <td class="px-6 py-4"><x-registration-status-badge-msllkm :status="$reg->status" /></td>
                                        <td class="px-6 py-4 text-right">
                                                <form method="POST" action="{{ route('registrations.decline', $reg->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" onclick="return confirm('Revoke approval?')" class="rounded-full border border-[var(--color-accent2-40)] text-[var(--color-accent-2)] px-4 py-2 text-xs font-extrabold tracking-widest uppercase hover:bg-white/5 transition">
                                                    Revoke
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($approved->isEmpty())
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-white/80 font-extrabold text-lg">No approved registrations.</div>
                                            <div class="mt-2 text-white/60 text-sm">Approve attendees to confirm spots.</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="declined" class="scroll-mt-24 mt-10">
                <div class="rounded-3xl border border-white/10 bg-[var(--color-surface)] overflow-hidden">
                    <div class="px-6 py-5 border-b border-white/10">
                        <div class="text-xs uppercase tracking-widest text-[var(--color-muted)] font-bold">Declined</div>
                        <div class="mt-2 text-sm text-white/70">Declined attendee registrations for this event.</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-white/5 text-white/70">
                                <tr>
                                    <th class="text-left px-6 py-4 font-bold">Attendee</th>
                                    <th class="text-left px-6 py-4 font-bold">Email</th>
                                    <th class="text-left px-6 py-4 font-bold">Registered On</th>
                                    <th class="text-left px-6 py-4 font-bold">Status</th>
                                    <th class="text-right px-6 py-4 font-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($declined as $reg)
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="px-6 py-4 font-semibold text-white/90">{{ $reg->user->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-white/70">{{ $reg->user->email ?? '—' }}</td>
                                        <td class="px-6 py-4 text-white/70">{{ method_exists($reg,'created_at') && $reg->created_at ? $reg->created_at->format('d M Y H:i') : '—' }}</td>
                                        <td class="px-6 py-4"><x-registration-status-badge-msllkm :status="$reg->status" /></td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="text-xs text-white/60">—</div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($declined->isEmpty())
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-white/80 font-extrabold text-lg">No declined registrations.</div>
                                            <div class="mt-2 text-white/60 text-sm">Everyone’s still in the mix.</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

