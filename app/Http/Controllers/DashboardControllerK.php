<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogK;
use App\Models\CategoryK;
use App\Models\EventK;
use App\Models\RegistrationK;
use App\Models\User;
use App\Services\EventServiceK;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardControllerK extends Controller
{
    public function __construct(private readonly EventServiceK $eventService) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isOrganizer()) {
            return $this->organizerDashboard($user);
        }

        return $this->attendeeDashboard($user);
    }

    private function adminDashboard(): View
    {
        $stats = [
            'total_events'        => EventK::count(),
            'published_events'    => EventK::published()->count(),
            'total_users'         => User::count(),
            'total_registrations' => RegistrationK::count(),
            'pending_registrations' => RegistrationK::pending()->count(),
        ];

        $recentEvents    = EventK::with('organizer')->latest()->limit(5)->get();
        $recentLogs      = ActivityLogK::with('user')->recent(10)->get();
        $usersByRole     = User::selectRaw('role, count(*) as count')->groupBy('role')->pluck('count', 'role');

        return view('dashboard.admin', compact('stats', 'recentEvents', 'recentLogs', 'usersByRole'));
    }

    private function organizerDashboard(User $user): View
    {
        $events = $this->eventService->getOrganizerEvents($user->id);

        $stats = [
            'total_events'    => EventK::forOrganizer($user->id)->count(),
            'published'       => EventK::forOrganizer($user->id)->published()->count(),
            'total_attendees' => RegistrationK::whereHas('event', fn($q) => $q->where('organizer_id', $user->id))
                ->approved()->count(),
            'pending'         => RegistrationK::whereHas('event', fn($q) => $q->where('organizer_id', $user->id))
                ->pending()->count(),
        ];

        return view('dashboard.organizer', compact('events', 'stats'));
    }

    private function attendeeDashboard(User $user): View
    {
        $registrations = RegistrationK::with(['event.category', 'event.organizer'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $upcomingCount = RegistrationK::where('user_id', $user->id)
            ->approved()
            ->whereHas('event', fn($q) => $q->upcoming())
            ->count();

        return view('dashboard.attendee', compact('registrations', 'upcomingCount'));
    }
}
