<?php

use App\Http\Controllers\AdminControllerK;
use App\Http\Controllers\CalendarControllerK;
use App\Http\Controllers\DashboardControllerK;
use App\Http\Controllers\EventControllerK;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationControllerK;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('events.index');
})->name('home');

// Public event routes
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventControllerK::class, 'index'])->name('index');
    Route::get('/{event:slug}', [EventControllerK::class, 'show'])
        ->where('event', '^(?!create$).+')
        ->name('show');
});

// Calendar
Route::prefix('calendar')->name('calendar.')->group(function () {
    Route::get('/', [CalendarControllerK::class, 'index'])->name('index');
    Route::get('/data', [CalendarControllerK::class, 'data'])->name('data')
        ->middleware('throttle:60,1');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (role-aware)
    Route::get('/dashboard', [DashboardControllerK::class, 'index'])->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Event management (organizer + admin)
    Route::middleware('role:admin,organizer')->prefix('events')->name('events.')->group(function () {
        Route::get('/create', [EventControllerK::class, 'create'])->name('create');
        Route::post('/', [EventControllerK::class, 'store'])->name('store');
        Route::get('/{event:slug}/edit', [EventControllerK::class, 'edit'])->name('edit');
        Route::put('/{event:slug}', [EventControllerK::class, 'update'])->name('update');
        Route::patch('/{event:slug}/publish', [EventControllerK::class, 'publish'])->name('publish');
        Route::patch('/{event:slug}/cancel', [EventControllerK::class, 'cancel'])->name('cancel');
        Route::delete('/{event:slug}', [EventControllerK::class, 'destroy'])->name('destroy');
    });

    // Registrations
    Route::prefix('events/{event:slug}/registrations')->name('events.registrations.')->group(function () {
        Route::post('/', [RegistrationControllerK::class, 'store'])->name('store')
            ->middleware('role:attendee');
        Route::get('/', [RegistrationControllerK::class, 'index'])->name('index')
            ->middleware('role:admin,organizer');
    });

    Route::prefix('registrations')->name('registrations.')->group(function () {
        Route::delete('/{registration}', [RegistrationControllerK::class, 'destroy'])->name('destroy');
        Route::patch('/{registration}/approve', [RegistrationControllerK::class, 'approve'])->name('approve')
            ->middleware('role:admin,organizer');
        Route::patch('/{registration}/decline', [RegistrationControllerK::class, 'decline'])->name('decline')
            ->middleware('role:admin,organizer');
    });

    // Admin-only routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/users', [AdminControllerK::class, 'users'])->name('users');
        Route::patch('/users/{user}/role', [AdminControllerK::class, 'updateUserRole'])->name('users.role');
        Route::get('/events', [AdminControllerK::class, 'events'])->name('events');
        Route::delete('/events/{event}', [AdminControllerK::class, 'destroyEvent'])->name('events.destroy');
        Route::get('/categories', [AdminControllerK::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminControllerK::class, 'storeCategory'])->name('categories.store');
    });
});

require __DIR__ . '/auth.php';
