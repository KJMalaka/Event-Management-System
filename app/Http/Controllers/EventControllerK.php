<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequestK;
use App\Http\Requests\UpdateEventRequestK;
use App\Models\CategoryK;
use App\Models\EventK;
use App\Services\EventServiceK;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventControllerK extends Controller
{
    public function __construct(private readonly EventServiceK $eventService) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category', 'upcoming']);
        $events     = $this->eventService->listPublished($filters);
        $categories = CategoryK::all();

        return view('events.index', compact('events', 'categories', 'filters'));
    }

    public function create(): View
    {
        $this->authorize('create', EventK::class);
        $categories = CategoryK::all();

        return view('events.create', compact('categories'));
    }

    public function store(StoreEventRequestK $request): RedirectResponse
    {
        $event = $this->eventService->store($request->validated(), $request->user()->id);

        return redirect()
            ->route('events.show', $event->slug)
            ->with('success', 'Event created successfully.');
    }

    public function show(EventK $event): View
    {
        $event->load(['organizer', 'category', 'approvedRegistrations.user']);

        $userRegistration = auth()->check()
            ? $event->registrations()->where('user_id', auth()->id())->first()
            : null;

        return view('events.show', compact('event', 'userRegistration'));
    }

    public function edit(EventK $event): View
    {
        $this->authorize('update', $event);
        $categories = CategoryK::all();

        return view('events.edit', compact('event', 'categories'));
    }

    public function update(UpdateEventRequestK $request, EventK $event): RedirectResponse
    {
        $this->eventService->update($event, $request->validated());

        return redirect()
            ->route('events.show', $event->slug)
            ->with('success', 'Event updated successfully.');
    }

    public function publish(EventK $event): RedirectResponse
    {
        $this->authorize('publish', $event);
        $this->eventService->update($event, ['status' => 'published']);

        return back()->with('success', 'Event published successfully.');
    }

    public function cancel(EventK $event): RedirectResponse
    {
        $this->authorize('update', $event);
        $this->eventService->update($event, ['status' => 'cancelled']);

        return back()->with('success', 'Event cancelled successfully.');
    }

    public function destroy(EventK $event): RedirectResponse
    {
        $this->authorize('delete', $event);
        $this->eventService->destroy($event);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Event deleted successfully.');
    }
}
