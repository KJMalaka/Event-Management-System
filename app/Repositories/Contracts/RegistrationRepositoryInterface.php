<?php

namespace App\Repositories\Contracts;

use App\Models\RegistrationK;
use Illuminate\Pagination\LengthAwarePaginator;

interface RegistrationRepositoryInterface
{
    public function create(array $data): RegistrationK;
    public function approve(RegistrationK $registration): RegistrationK;
    public function decline(RegistrationK $registration): RegistrationK;
    public function cancel(RegistrationK $registration): RegistrationK;
    public function findByEventAndUser(int $eventId, int $userId): ?RegistrationK;
    public function getEventRegistrations(int $eventId, string $status = null): LengthAwarePaginator;
}
