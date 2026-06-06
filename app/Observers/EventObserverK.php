<?php

namespace App\Observers;

use App\Models\ActivityLogK;
use App\Models\EventK;

class EventObserverK
{
    public function created(EventK $event): void
    {
        $this->log('event.created', $event);
    }

    public function updated(EventK $event): void
    {
        $this->log('event.updated', $event, [
            'changed' => array_keys($event->getChanges()),
        ]);
    }

    public function deleted(EventK $event): void
    {
        $this->log('event.deleted', $event);
    }

    private function log(string $action, EventK $event, array $extra = []): void
    {
        ActivityLogK::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'model_type' => EventK::class,
            'model_id'   => $event->id,
            'properties' => array_merge(['title' => $event->title], $extra),
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
