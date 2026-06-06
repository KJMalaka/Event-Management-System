<?php

namespace App\Repositories;

use App\Models\RegistrationK;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RegistrationRepositoryK implements RegistrationRepositoryInterface
{
    public function __construct(private readonly RegistrationK $model) {}

    public function create(array $data): RegistrationK
    {
        return $this->model->create($data);
    }

    public function approve(RegistrationK $registration): RegistrationK
    {
        $registration->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'declined_at' => null,
        ]);
        return $registration->fresh(['event', 'user']);
    }

    public function decline(RegistrationK $registration): RegistrationK
    {
        $registration->update([
            'status'      => 'declined',
            'declined_at' => now(),
            'approved_at' => null,
        ]);
        return $registration->fresh(['event', 'user']);
    }

    public function cancel(RegistrationK $registration): RegistrationK
    {
        $registration->update(['status' => 'cancelled']);
        return $registration->fresh();
    }

    public function findByEventAndUser(int $eventId, int $userId): ?RegistrationK
    {
        return $this->model
            ->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();
    }

    public function getEventRegistrations(int $eventId, string $status = null): LengthAwarePaginator
    {
        return $this->model
            ->with('user')
            ->where('event_id', $eventId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);
    }
}
