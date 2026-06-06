<?php

namespace App\Policies;

use App\Models\RegistrationK;
use App\Models\User;

class RegistrationPolicyK
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    public function view(User $user, RegistrationK $registration): bool
    {
        return $user->id === $registration->user_id
            || $user->id === $registration->event->organizer_id;
    }

    public function create(User $user): bool
    {
        return $user->isAttendee();
    }

    public function approve(User $user, RegistrationK $registration): bool
    {
        return $user->id === $registration->event->organizer_id;
    }

    public function decline(User $user, RegistrationK $registration): bool
    {
        return $user->id === $registration->event->organizer_id;
    }

    public function cancel(User $user, RegistrationK $registration): bool
    {
        return $user->id === $registration->user_id
            && in_array($registration->status, ['pending', 'approved']);
    }
}
