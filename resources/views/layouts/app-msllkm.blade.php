{{--
  EventMS Frontend Template
  Template source credit: Built for EventMS (Premium Event Management System) – South African cultural UI concept.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EventMS')</title>

    <!-- Google Fonts (single link for Syne + Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Syne:wght@600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --color-primary:   #1A1A2E;
            --color-surface:   #16213E;
            --color-accent:    #F59E0B;
            --color-accent-2:  #E63946;
            --color-success:   #2DC653;
            --color-text:      #F1F1F1;
            --color-muted:     #8892A4;

            /* alpha variants for utility usage */
            --color-accent-16: rgba(245,158,11,0.16);
            --color-accent-35: rgba(245,158,11,0.35);
            --color-accent-40: rgba(245,158,11,0.40);
            --color-accent-shadow: rgba(245,158,11,0.20);
            --color-accent-25: rgba(245,158,11,0.25);
            --color-accent-strong: rgba(245,158,11,0.55);
            --color-accent-10: rgba(245,158,11,0.10);
            --color-accent-08: rgba(245,158,11,0.08);

            --color-accent2-16: rgba(230,57,70,0.16);
            --color-accent2-35: rgba(230,57,70,0.35);
            --color-accent2-40: rgba(230,57,70,0.40);
            --color-accent2-shadow: rgba(230,57,70,0.18);
            --color-accent2-18: rgba(230,57,70,0.18);

            --color-success-16: rgba(45,198,83,0.16);
            --color-success-35: rgba(45,198,83,0.35);
            --color-success-shadow: rgba(45,198,83,0.25);

            --color-muted-18: rgba(136,146,164,0.18);
            --color-muted-35: rgba(136,146,164,0.35);
            --color-muted-100: rgba(136,146,164,1);

            /* small alpha helpers and overlays */
            --bg-overlay: rgba(26,26,46,0.86);
            --surface-overlay-98: rgba(22,33,62,0.98);
            --panel-bg-65: rgba(22,33,62,0.65);
            --panel-bg-70: rgba(22,33,62,0.70);
            --panel-bg-75: rgba(22,33,62,0.75);
            --shadow-inset: rgba(26,26,0,0.16);
            --color-text-92: rgba(241,241,241,0.92);
        }

        .text-gold-foil{
            background: linear-gradient(90deg, #FCD34D 0%, #F59E0B 40%, #FDE68A 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .diamond-divider::before{
            content: '◆';
            display: inline-block;
            transform: translateY(-1px);
            color: var(--color-accent);
            font-size: 14px;
            margin: 0 12px;
        }

        .hero-diagonal{
            background-image:
                linear-gradient(135deg, var(--color-accent-08) 0%, rgba(245,158,11,0.00) 35%),
                repeating-linear-gradient(135deg, var(--color-accent-10) 0px, var(--color-accent-10) 1px, rgba(0,0,0,0) 1px, rgba(0,0,0,0) 8px);
        }

        /* lighter diagonal used for small card fallbacks so the pattern doesn't overwhelm grids */
        .card-hero-diagonal{
            background-image:
                linear-gradient(135deg, rgba(245,158,11,0.04) 0%, rgba(245,158,11,0.00) 40%),
                repeating-linear-gradient(135deg, rgba(245,158,11,0.06) 0px, rgba(245,158,11,0.06) 1px, rgba(0,0,0,0) 1px, rgba(0,0,0,0) 12px);
            background-size: auto;
        }

        /* Utility classes for consistent form and shadow styling */
        .form-input{
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--color-accent-35);
            padding: 0.75rem 1rem;
            border-radius: 9999px;
            color: var(--color-text);
        }
        .form-input:focus{ outline: none; box-shadow: 0 0 0 6px rgba(245,158,11,0.10); border-color: var(--color-accent); }

        .form-cta{ border-radius: 9999px; padding: 0.75rem 1rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; display: inline-flex; align-items: center; justify-content: center; }

        .shadow-lg-custom{ box-shadow: 0 10px 45px rgba(0,0,0,0.35); }
        .shadow-xl-custom{ box-shadow: 0 20px 80px rgba(0,0,0,0.45); }

        .glow-accent{ box-shadow: 0 0 18px var(--color-accent-shadow); }
        .glow-success{ box-shadow: 0 0 18px var(--color-success-shadow); }
        .glow-accent2{ box-shadow: 0 0 18px var(--color-accent2-shadow); }
        .glow-muted{ box-shadow: 0 0 18px var(--color-muted-18); }
    </style>
</head>
<body class="min-h-screen bg-[var(--color-primary)] text-[var(--color-text)] font-sans antialiased">

<div class="min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 border-b border-white/10 bg-[rgba(26,26,46,0.78)] backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center justify-between gap-4 rounded-full border border-white/10 bg-[rgba(22,33,62,0.55)] px-4 sm:px-5 py-3 shadow-lg-custom">

                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('events.index') }}" class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] flex items-center justify-center shadow-[0_0_18px_var(--color-accent-shadow)]">
                            <span class="font-syne text-gold-foil text-base">◆</span>
                        </div>
                        <div class="leading-tight">
                            <div class="font-syne font-bold tracking-wide text-base sm:text-lg">
                                <span class="text-gold-foil">EventMS</span>
                            </div>
                            <div class="text-[var(--color-muted)] text-[11px] sm:text-xs">Premium SA Event Culture</div>
                        </div>
                    </a>
                </div>

                <!-- Mobile menu (Alpine allowed) -->
                <div x-data="{ open: false }" class="lg:hidden">
                    <button type="button" @click="open = !open" class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-white/10 hover:bg-white/5 transition" aria-label="Open menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <div x-show="open" class="absolute left-0 right-0 top-full mt-3 bg-[var(--surface-overlay-98)] border border-white/10 rounded-3xl shadow-xl-custom overflow-hidden lg:hidden">
                        <nav class="px-3 py-3 flex flex-col gap-2">
                            <a href="{{ route('events.index') }}" class="px-4 py-3 rounded-2xl hover:bg-white/5 transition">Browse Events</a>
                            <a href="#about" class="px-4 py-3 rounded-2xl hover:bg-white/5 transition">About</a>
                        </nav>
                    </div>
                </div>

                <nav class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-full text-xs font-extrabold tracking-widest uppercase text-[var(--color-muted)] hover:text-[var(--color-text)] hover:bg-white/5 transition">Browse Events</a>
                    <a href="#about" class="px-4 py-2 rounded-full text-xs font-extrabold tracking-widest uppercase text-[var(--color-muted)] hover:text-[var(--color-text)] hover:bg-white/5 transition">About</a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    @auth
                        @php
                            $role = auth()->user()->role ?? '';
                        @endphp

                        <div class="hidden md:flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase
                                {{ $role === 'organizer' ? 'bg-[var(--color-accent-16)] text-[var(--color-accent)] border border-[var(--color-accent-35)]'
                                    : ($role === 'admin' ? 'bg-[var(--color-accent2-16)] text-[var(--color-accent-2)] border border-[var(--color-accent2-35)]'
                                    : 'bg-white/10 text-white border border-white/10') }}">
                                {{ ucfirst($role) }}
                            </span>
                            <div class="hidden xl:block text-sm font-semibold max-w-[12rem] truncate">{{ auth()->user()->name }}</div>

                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open" class="px-3 py-2 rounded-full border border-white/10 hover:bg-white/5 transition flex items-center gap-2">
                                    <span class="text-xs text-[var(--color-muted)]">Menu</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>

                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-[var(--color-surface)] border border-white/10 rounded-2xl shadow-xl-custom overflow-hidden">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm hover:bg-white/5 transition">Dashboard</a>

                                    @can('is-admin')
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm hover:bg-white/5 transition">Admin Control Room</a>
                                    @endcan

                                    <form method="POST" action="{{ route('logout') }}" class="border-t border-white/10">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-sm hover:bg-white/5 transition">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="md:hidden">
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-full border border-white/10 hover:bg-white/5 transition text-sm font-semibold">Dashboard</a>
                        </div>
                    @else
                        <div class="hidden sm:flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-full border border-white/10 hover:bg-white/5 transition text-sm font-semibold">Log in</a>
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-[var(--color-accent)] text-[var(--color-primary)] font-extrabold tracking-widest uppercase text-xs hover:scale-[1.02] transition">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash banner -->
    @if (session('success') || session('error'))
        <div class="px-4 sm:px-6 lg:px-8 pt-4">
                @if(session('success'))
                <div id="eventms-flash" class="w-full bg-[var(--color-success-16)] border border-[var(--color-success-35)] rounded-2xl px-4 py-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm font-bold text-[var(--color-success)]">Success</div>
                            <div class="text-sm text-white/90">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

                @if(session('error'))
                <div id="eventms-flash" class="w-full bg-[var(--color-accent2-16)] border border-[var(--color-accent2-35)] rounded-2xl px-4 py-3 mt-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm font-bold text-[var(--color-accent-2)]">Error</div>
                            <div class="text-sm text-white/90">{{ session('error') }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <script>
            (function(){
                const el = document.getElementById('eventms-flash');
                if(!el) return;
                setTimeout(()=>{ el.style.transition='opacity 300ms ease'; el.style.opacity='0'; }, 3800);
                setTimeout(()=>{ if(el && el.parentNode) el.parentNode.removeChild(el); }, 4200);
            })();
        </script>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] flex items-center justify-center">
                            <span class="font-syne text-gold-foil">◆</span>
                        </div>
                        <div>
                            <div class="font-syne font-bold text-xl">EventMS</div>
                            <div class="text-sm text-[var(--color-muted)]">Where SA comes alive</div>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-white/70 leading-relaxed">
                        Premium event discovery built for South Africa’s vibrant stages—music, theatre, heritage, and everything in between.
                    </p>
                </div>

                <div>
                    <div class="font-bold tracking-widest uppercase text-xs text-[var(--color-muted)]">Quick Links</div>
                    <ul class="mt-4 space-y-3 text-sm">
                        <li><a href="{{ route('events.index') }}" class="text-white/80 hover:text-[var(--color-accent)] transition">Browse Events</a></li>
                        <li><a href="#about" class="text-white/80 hover:text-[var(--color-accent)] transition">About EventMS</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-white/80 hover:text-[var(--color-accent)] transition">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <div class="font-bold tracking-widest uppercase text-xs text-[var(--color-muted)]">Contact</div>
                    <div class="mt-4 text-sm text-white/80 space-y-2">
                        <div>support@eventms.co.za</div>
                        <div>+27 00 000 0000</div>
                        <div>South Africa</div>
                    </div>
                </div>
            </div>

            <div class="mt-10 border-t border-white/10 pt-6 text-center text-sm text-white/60">
                © {{ date('Y') }} EventMS · Proudly South African 🇿🇦
            </div>
        </div>
    </footer>

</div>

@stack('scripts')
</body>
</html>

