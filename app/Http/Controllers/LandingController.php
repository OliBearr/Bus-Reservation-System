<?php

namespace App\Http\Controllers;

use App\Models\Route as BusRoute; // Renamed to avoid confusion with Laravel Route
use App\Models\Schedule;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get unique Origins and Destinations for the dropdowns
        $origins = BusRoute::select('origin')->distinct()->orderBy('origin')->pluck('origin');
        $destinations = BusRoute::select('destination')->distinct()->orderBy('destination')->pluck('destination');

        // 2. Prepare the Schedules Query
        $schedules = collect(); // Empty by default
        $searchDate = $request->input('date', date('Y-m-d')); // Default to today

        // 3. If User clicked "Find Available" (Search parameters exist)
        if ($request->has('origin') && $request->has('destination')) {
            $schedules = Schedule::with(['bus', 'route'])
                ->whereHas('route', function($q) use ($request) {
                    $q->where('origin', $request->origin)
                      ->where('destination', $request->destination);
                })
                ->whereDate('departure_time', $searchDate)
                ->orderBy('departure_time')
                ->get();
        }

        // 4. Return the view with data
        return view('welcome', compact('origins', 'destinations', 'schedules', 'searchDate'));
    }
}