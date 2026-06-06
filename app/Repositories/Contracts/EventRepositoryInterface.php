<?php

namespace App\Repositories\Contracts;

use App\Models\EventK;
use Illuminate\Pagination\LengthAwarePaginator;

interface EventRepositoryInterface
{
    public function paginate(int $perPage = 12, array $filters = []): LengthAwarePaginator;
    public function findBySlug(string $slug): EventK;
    public function create(array $data): EventK;
    public function update(EventK $event, array $data): EventK;
    public function delete(EventK $event): void;
    public function getUpcomingForCalendar(): array;
    public function getOrganizerEvents(int $userId): LengthAwarePaginator;
}
