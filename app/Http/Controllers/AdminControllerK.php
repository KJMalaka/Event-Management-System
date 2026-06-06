<?php

namespace App\Http\Controllers;

use App\Models\CategoryK;
use App\Models\EventK;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminControllerK extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function users(): View
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:admin,organizer,attendee'],
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role updated to {$request->role} for {$user->name}.");
    }

    public function events(): View
    {
        $events = EventK::with(['organizer', 'category'])
            ->withCount('registrations')
            ->latest()
            ->paginate(20);

        return view('admin.events', compact('events'));
    }

    public function categories(): View
    {
        $categories = CategoryK::withCount('events')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'color'       => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        CategoryK::create($validated);

        return back()->with('success', 'Category created.');
    }

    public function destroyEvent(EventK $event): RedirectResponse
    {
        $event->delete();
        return back()->with('success', 'Event removed.');
    }
}
