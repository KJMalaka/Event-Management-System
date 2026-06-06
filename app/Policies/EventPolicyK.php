<?php

namespace App\Policies;

use App\Models\EventK;
use App\Models\User;

class EventPolicyK
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->canManageEvents();
    }

    public function update(User $user, EventK $event): bool
    {
        return $user->isOrganizer() && $user->id === $event->organizer_id;
    }

    public function delete(User $user, EventK $event): bool
    {
        return $user->isOrganizer() && $user->id === $event->organizer_id;
    }

    public function manageRegistrations(User $user, EventK $event): bool
    {
        return $user->isOrganizer() && $user->id === $event->organizer_id;
    }

    public function publish(User $user, EventK $event): bool
    {
        return $user->id === $event->organizer_id && $event->status === 'draft';
    }
}
