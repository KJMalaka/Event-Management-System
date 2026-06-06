<?php

namespace App\Services;

use App\Models\EventK;
use App\Models\RegistrationK;
use App\Models\User;
use App\Notifications\RegistrationApprovedK;
use App\Notifications\RegistrationDeclinedK;
use App\Notifications\RegistrationReceivedK;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use Illuminate\Validation\ValidationException;

class RegistrationServiceK
{
    public function __construct(private readonly RegistrationRepositoryInterface $registrationRepo) {}

    public function register(EventK $event, User $user, array $data = []): RegistrationK
    {
        if ($event->status !== 'published') {
            throw ValidationException::withMessages(['event' => 'This event is not open for registration.']);
        }

        $existing = $this->registrationRepo->findByEventAndUser($event->id, $user->id);

        if ($existing && in_array($existing->status, ['pending', 'approved'])) {
            throw ValidationException::withMessages(['event' => 'You are already registered for this event.']);
        }

        if ($event->is_full) {
            throw ValidationException::withMessages(['event' => 'This event has reached its capacity.']);
        }

        $status = $event->requires_approval ? 'pending' : 'approved';

        $registration = $this->registrationRepo->create([
            'event_id' => $event->id,
            'user_id'  => $user->id,
            'status'   => $status,
            'notes'    => $data['notes'] ?? null,
        ]);

        $user->notify(new RegistrationReceivedK($registration));

        return $registration;
    }

    public function approve(RegistrationK $registration): RegistrationK
    {
        $registration = $this->registrationRepo->approve($registration);
        $registration->user->notify(new RegistrationApprovedK($registration));
        return $registration;
    }

    public function decline(RegistrationK $registration): RegistrationK
    {
        $registration = $this->registrationRepo->decline($registration);
        $registration->user->notify(new RegistrationDeclinedK($registration));
        return $registration;
    }

    public function cancel(RegistrationK $registration, User $user): RegistrationK
    {
        if ($registration->user_id !== $user->id) {
            abort(403);
        }

        if (!in_array($registration->status, ['pending', 'approved'])) {
            throw ValidationException::withMessages(['registration' => 'This registration cannot be cancelled.']);
        }

        return $this->registrationRepo->cancel($registration);
    }
}
