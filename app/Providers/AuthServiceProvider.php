<?php

namespace App\Providers;

use App\Models\EventK;
use App\Models\RegistrationK;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        
        Gate::define('approve-registration', function ($user, RegistrationK $registration) {
            return $user->id === $registration->event->organizer_id || $user->isAdmin();
        });

       
        Gate::define('manage-events', function ($user) {
            return $user->canManageEvents();
        });

       
        Gate::define('view-admin', function ($user) {
            return $user->isAdmin();
        });
    }
}