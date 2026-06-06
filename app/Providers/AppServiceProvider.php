<?php

namespace App\Providers;

use App\Models\EventK;
use App\Models\RegistrationK;
use App\Observers\EventObserverK;
use App\Policies\EventPolicyK;
use App\Policies\RegistrationPolicyK;
use App\Repositories\EventRepositoryK;
use App\Repositories\RegistrationRepositoryK;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EventRepositoryInterface::class, EventRepositoryK::class);
        $this->app->bind(RegistrationRepositoryInterface::class, RegistrationRepositoryK::class);
    }

    public function boot(): void
    {
        EventK::observe(EventObserverK::class);

        Gate::policy(EventK::class, EventPolicyK::class);
        Gate::policy(RegistrationK::class, RegistrationPolicyK::class);

        Gate::define('manage-events', function ($user) {
            return $user->canManageEvents();
        });

        Gate::define('admin-only', function ($user) {
            return $user->isAdmin();
        });
    }
}
