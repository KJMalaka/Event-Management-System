@extends('layouts.app-msllkm')

@section('title', 'Create account - EventMS')

@section('content')
    <div class="min-h-screen bg-[var(--color-primary)] flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[var(--panel-bg-75)] backdrop-blur p-6 sm:p-8 shadow-xl-custom">
                <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[var(--color-accent-16)] border border-[var(--color-accent-35)] flex items-center justify-center">
                    <span class="font-syne text-gold-foil text-2xl">◆</span>
                </div>
                <div>
                    <div class="font-syne font-bold text-2xl">EventMS</div>
                    <div class="text-xs text-[var(--color-muted)] uppercase tracking-widest font-bold">Join the Culture</div>
                </div>
            </div>

            <h1 class="mt-6 font-syne font-bold text-3xl">Create your account</h1>
            <p class="mt-2 text-sm text-white/70">Pick your role—attend or organize.</p>

            <form method="POST" action="{{ route('register') }}" class="mt-6">
                @csrf

                <div>
                    <label for="name" class="block text-xs uppercase tracking-widest font-bold text-white/70">Name</label>
                              <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                  class="mt-2 w-full form-input">
                    @error('name')
                        <div class="mt-2 text-xs text-[var(--color-accent-2)]">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="email" class="block text-xs uppercase tracking-widest font-bold text-white/70">Email</label>
                              <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                  class="mt-2 w-full form-input">
                    @error('email')
                        <div class="mt-2 text-xs text-[var(--color-accent-2)]">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-xs uppercase tracking-widest font-bold text-white/70">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="mt-2 w-full form-input">
                    @error('password')
                        <div class="mt-2 text-xs text-[var(--color-accent-2)]">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block text-xs uppercase tracking-widest font-bold text-white/70">Confirm Password</label>
                          <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="mt-2 w-full form-input">
                    @error('password_confirmation')
                        <div class="mt-2 text-xs text-[var(--color-accent-2)]">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="role" class="block text-xs uppercase tracking-widest font-bold text-white/70">Role</label>
                    <select id="role" name="role" class="mt-2 w-full rounded-full border border-[var(--color-accent-35)] bg-white/5 px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[var(--color-accent-35)]">
                        <option value="organizer" @selected(old('role') === 'organizer')>Organizer</option>
                        <option value="attendee" @selected(old('role', 'attendee') === 'attendee')>Attendee</option>
                    </select>
                    @error('role')
                        <div class="mt-2 text-xs text-[var(--color-accent-2)]">{{ $message }}</div>
                    @enderror
                    <div class="mt-2 text-xs text-white/50">Admin role is excluded from self-registration.</div>
                </div>

                <div class="mt-6">
                        <button type="submit"
                            class="w-full form-cta bg-[var(--color-accent)] text-[var(--color-primary)] hover:scale-[1.02] transition">
                        Register
                    </button>
                </div>

                <div class="mt-5 text-center text-sm text-white/70">
                    <a href="{{ route('login') }}" class="text-gold-foil font-extrabold">Already registered?</a>
                </div>

                <div class="mt-8 border-t border-white/10 pt-5 text-xs text-white/50 text-center">
                    By registering, you agree to EventMS terms and privacy policy.
                </div>
            </form>
        </div>
    </div>
@endsection

