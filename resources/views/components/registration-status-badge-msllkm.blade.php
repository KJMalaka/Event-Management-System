@props(['status'])

@php
    $s = strtolower((string) $status);
    $classes = [
        'pending' => 'bg-[var(--color-accent-16)] text-[var(--color-accent)] border border-[var(--color-accent-35)] shadow-[0_0_18px_var(--color-accent-shadow)]',
        'approved' => 'bg-[var(--color-success-16)] text-[var(--color-success)] border border-[var(--color-success-35)] shadow-[0_0_18px_var(--color-success-shadow)]',
        'declined' => 'bg-[var(--color-accent2-16)] text-[var(--color-accent-2)] border border-[var(--color-accent2-35)] shadow-[0_0_18px_var(--color-accent2-shadow)]',
    ];

    $dotClasses = [
        'pending' => 'bg-[var(--color-accent)]',
        'approved' => 'bg-[var(--color-success)]',
        'declined' => 'bg-[var(--color-accent-2)]',
    ];
@endphp

<span
    class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold tracking-widest uppercase {{ $classes[$s] ?? 'bg-white/10 text-white border border-white/10' }}"
>
    <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full {{ $dotClasses[$s] ?? 'bg-white/60' }}"></span>

    {{ ucfirst($s) }}
</span>

