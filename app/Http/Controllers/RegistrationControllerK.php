<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequestK;
use App\Models\EventK;
use App\Models\RegistrationK;
use App\Services\RegistrationServiceK;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationControllerK extends Controller
{
    public function __construct(private readonly RegistrationServiceK $registrationService) {}

    public function store(StoreRegistrationRequestK $request, EventK $event): RedirectResponse
    {
        $this->authorize('create', RegistrationK::class);

        try {
            $this->registrationService->register($event, $request->user(), $request->validated());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return redirect()
            ->route('events.show', $event->slug)
            ->with('success', 'You have successfully registered for this event.');
    }

    public function destroy(RegistrationK $registration): RedirectResponse
    {
        $this->authorize('cancel', $registration);

        try {
            $this->registrationService->cancel($registration, auth()->user());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Registration cancelled.');
    }

    public function approve(RegistrationK $registration): RedirectResponse
    {
        $this->authorize('approve', $registration);
        $this->registrationService->approve($registration);

        return back()->with('success', 'Registration approved.');
    }

    public function decline(RegistrationK $registration): RedirectResponse
    {
        $this->authorize('decline', $registration);
        $this->registrationService->decline($registration);

        return back()->with('success', 'Registration declined.');
    }

    public function index(EventK $event): View
    {
        $this->authorize('manageRegistrations', $event);

        $registrations = $event->registrations()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('registrations.index', compact('event', 'registrations'));
    }
}
