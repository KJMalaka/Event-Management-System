@extends('layouts.app-msllkm')

@section('title', 'Sign in - EventMS')

@section('content')
    <div class="min-h-screen bg-[var(--color-primary)] flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[var(--panel-bg-75)] backdrop-blur p-6 sm:p-8 shadow-xl-custom">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] flex items-center justify-center">
                    <span class="font-syne text-gold-foil text-2xl">◆</span>
                </div>
                <div>
                    <div class="font-syne font-bold text-2xl">EventMS</div>
                    <div class="text-xs text-[var(--color-muted)] uppercase tracking-widest font-bold">Premium Event Platform</div>
                </div>
            </div>

            <h1 class="mt-6 font-syne font-bold text-3xl">Welcome back</h1>
            <p class="mt-2 text-sm text-white/70">Sign in to manage your SA event journey.</p>

            @if (session('status'))
                <div class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-3 text-sm text-white/80">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs uppercase tracking-widest font-bold text-white/70">Email</label>
                              <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                  class="mt-2 w-full form-input" />
                    @error('email')
                        <div class="mt-2 text-xs text-[var(--color-accent-2)]">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-xs uppercase tracking-widest font-bold text-white/70">Password</label>
                              <input id="password" type="password" name="password" required
                                  class="mt-2 w-full form-input" />
                    @error('password')
                        <div class="mt-2 text-xs text-[var(--color-accent-2)]">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6">
                        <button type="submit"
                            class="w-full form-cta bg-[var(--color-accent)] text-[var(--color-primary)] hover:scale-[1.02] transition">
                        Sign In
                    </button>
                </div>

                <div class="mt-5 text-center text-sm">
                    <span class="text-white/70">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-gold-foil font-extrabold">Register →</a>
                </div>

                <div class="mt-7 border-t border-white/10 pt-5 text-center">
                    <div class="text-white/60 text-sm italic">"Ubuntu: I am because we are."</div>
                </div>
            </form>
        </div>
    </div>
@endsection

