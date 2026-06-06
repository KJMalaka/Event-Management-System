<?php

namespace App\Repositories;

use App\Models\EventK;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepositoryK implements EventRepositoryInterface
{
    public function __construct(private readonly EventK $model) {}

    public function paginate(int $perPage = 12, array $filters = []): LengthAwarePaginator
    {
        return $this->model
            ->with(['organizer', 'category'])
            ->published()
            ->when(isset($filters['category']), fn($q) => $q->byCategory($filters['category']))
            ->when(isset($filters['search']), fn($q) => $q->where('title', 'like', "%{$filters['search']}%"))
            ->when(isset($filters['upcoming']), fn($q) => $q->upcoming())
            ->orderBy('start_date')
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): EventK
    {
        return $this->model
            ->with(['organizer', 'category', 'approvedRegistrations.user'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function create(array $data): EventK
    {
        return $this->model->create($data);
    }

    public function update(EventK $event, array $data): EventK
    {
        $event->update($data);
        return $event->fresh();
    }

    public function delete(EventK $event): void
    {
        $event->delete();
    }

    public function getUpcomingForCalendar(): array
    {
        return $this->model
            ->published()
            ->upcoming()
            ->get(['id', 'title', 'slug', 'start_date', 'end_date', 'location'])
            ->map(fn($event) => [
                'id'    => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toIso8601String(),
                'end'   => $event->end_date->toIso8601String(),
                'url'   => route('events.show', $event->slug),
                'color' => $event->category?->color ?? '#3B82F6',
            ])
            ->toArray();
    }

    public function getOrganizerEvents(int $userId): LengthAwarePaginator
    {
        return $this->model
            ->with(['category', 'registrations'])
            ->withCount('registrations')
            ->forOrganizer($userId)
            ->latest()
            ->paginate(10);
    }
}
