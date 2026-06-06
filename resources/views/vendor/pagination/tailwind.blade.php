{{--
  Tailwind Pagination Override for EventMS (Dark Theme)
--}}

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/40 text-sm">&laquo; Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 hover:bg-white/10 hover:text-white transition text-sm">&laquo; Previous</a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex items-center flex-wrap gap-2 justify-center">
            {{-- First Page Link --}}
            @if ($paginator->currentPage() > 2)
                <a href="{{ $paginator->url(1) }}" class="px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 hover:bg-white/10 hover:text-white transition text-sm">1</a>
                @if ($paginator->currentPage() > 3)
                    <span class="px-3 py-2 text-white/50">…</span>
                @endif
            @endif

            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 rounded-full bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] text-gold-foil font-extrabold text-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 hover:bg-white/10 hover:text-white transition text-sm">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Last Page Link --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 1)
                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                    <span class="px-3 py-2 text-white/50">…</span>
                @endif
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 hover:bg-white/10 hover:text-white transition text-sm">{{ $paginator->lastPage() }}</a>
            @endif
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 hover:bg-white/10 hover:text-white transition text-sm">Next &raquo;</a>
        @else
            <span class="px-3 py-2 rounded-full bg-white/5 border border-white/10 text-white/40 text-sm">Next &raquo;</span>
        @endif
    </nav>
@endif

