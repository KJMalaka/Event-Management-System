<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('events.index') }}" class="text-blue-600 dark:text-blue-400 font-bold text-lg tracking-tight flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    EventMS
                </a>

                <div class="hidden sm:flex sm:items-center sm:ml-8 space-x-1">
                    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">Events</x-nav-link>
                    <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')">Calendar</x-nav-link>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>

                        @if(auth()->user()->canManageEvents())
                            <x-nav-link :href="route('events.create')" :active="request()->routeIs('events.create')">Create Event</x-nav-link>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.*')">Admin</x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-3">
                @auth
                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' :
                           (auth()->user()->isOrganizer() ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-200' :
                           'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200') }}">
                        {{ auth()->user()->role_label }}
                    </span>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none transition">
                                <img src="{{ auth()->user()->avatar_url }}" class="w-7 h-7 rounded-full mr-2" alt="">
                                {{ auth()->user()->name }}
                                <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">Register</a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-200 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">Events</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')">Calendar</x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                @if(auth()->user()->canManageEvents())
                    <x-responsive-nav-link :href="route('events.create')">Create Event</x-responsive-nav-link>
                @endif
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.users')">Admin Panel</x-responsive-nav-link>
                @endif
            @endauth
        </div>
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">Log Out</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
