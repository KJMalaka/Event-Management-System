<?php

namespace App\Http\Controllers;

use App\Services\EventServiceK;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CalendarControllerK extends Controller
{
    public function __construct(private readonly EventServiceK $eventService) {}

    public function index(): View
    {
        return view('calendar.index');
    }

    public function data(): JsonResponse
    {
        return response()->json($this->eventService->getCalendarData());
    }
}
