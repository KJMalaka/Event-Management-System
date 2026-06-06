<?php

namespace App\Services;

use App\Models\EventK;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class EventServiceK
{
    public function __construct(private readonly EventRepositoryInterface $eventRepo) {}

    public function listPublished(array $filters = []): LengthAwarePaginator
    {
        return $this->eventRepo->paginate(12, $filters);
    }

    public function store(array $validated, int $organizerId): EventK
    {
        $validated['organizer_id'] = $organizerId;
        $validated['status']       = $validated['status'] ?? 'draft';

        if (isset($validated['banner_image']) && $validated['banner_image'] instanceof UploadedFile) {
            $validated['banner_image'] = $validated['banner_image']->store('banners', 'public');
        }

        return $this->eventRepo->create($validated);
    }

    public function update(EventK $event, array $validated): EventK
    {
        if (isset($validated['banner_image']) && $validated['banner_image'] instanceof UploadedFile) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $validated['banner_image']->store('banners', 'public');
        }

        return $this->eventRepo->update($event, $validated);
    }

    public function destroy(EventK $event): void
    {
        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }
        $this->eventRepo->delete($event);
    }

    public function getCalendarData(): array
    {
        return $this->eventRepo->getUpcomingForCalendar();
    }

    public function getOrganizerEvents(int $userId): LengthAwarePaginator
    {
        return $this->eventRepo->getOrganizerEvents($userId);
    }
}
