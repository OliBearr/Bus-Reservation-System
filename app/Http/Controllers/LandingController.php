<?php

namespace App\Http\Controllers;

use App\Models\Route as BusRoute; // Renamed to avoid confusion with Laravel Route
use App\Models\Schedule;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $origins = BusRoute::select('origin')->distinct()->orderBy('origin')->pluck('origin');
        $destinations = BusRoute::select('destination')->distinct()->orderBy('destination')->pluck('destination');
        
        // NEW: Get unique Bus Types for the filter dropdown
        $busTypes = \App\Models\Bus::select('type')->distinct()->orderBy('type')->pluck('type');

        $searchDate = $request->input('date', date('Y-m-d'));

        // Generate Date Carousel
        $dates = [];
        $carbonDate = \Carbon\Carbon::parse($searchDate);
        for ($i = -3; $i <= 3; $i++) {
            $dates[] = $carbonDate->copy()->addDays($i);
        }

        // Query Schedules
        $query = Schedule::with(['bus', 'route','reservations'])
            ->withCount('reservations')
            ->whereDate('departure_time', $searchDate);

        if ($request->filled('origin')) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('origin', $request->origin);
            });
        }

        if ($request->filled('destination')) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('destination', $request->destination);
            });
        }

        // NEW: Filter by Bus Type
        if ($request->filled('bus_type')) {
            $query->whereHas('bus', function($q) use ($request) {
                $q->where('type', $request->bus_type);
            });
        }

        // Get results
        $schedules = $query->orderBy('departure_time')->get();

        // NEW (Fixed): Only filter if the value is explicitly '1'
        if ($request->input('hide_full') == '1') {
            $schedules = $schedules->filter(function ($schedule) {
                return ($schedule->bus->capacity - $schedule->reservations_count) > 0;
            });
        }

        // Pass $busTypes to the view
        return view('welcome', compact('origins', 'destinations', 'schedules', 'searchDate', 'dates', 'busTypes'));
    }

    // Add this new method for the Logged-in Dashboard
    public function dashboard(Request $request)
    {
        // --- FIX: ADMIN REDIRECT ---
        // If the logged-in user is an Admin, send them to the Admin Panel immediately
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // --- NORMAL USER LOGIC (Search & Booking) ---
        $origins = BusRoute::select('origin')->distinct()->orderBy('origin')->pluck('origin');
        $destinations = BusRoute::select('destination')->distinct()->orderBy('destination')->pluck('destination');
        $busTypes = \App\Models\Bus::select('type')->distinct()->orderBy('type')->pluck('type');

        $searchDate = $request->input('date', date('Y-m-d'));

        // Date Carousel
        $dates = [];
        $carbonDate = \Carbon\Carbon::parse($searchDate);
        for ($i = -3; $i <= 3; $i++) {
            $dates[] = $carbonDate->copy()->addDays($i);
        }

        // Query
        $query = Schedule::with(['bus', 'route', 'reservations'])
            ->withCount('reservations')
            ->whereDate('departure_time', $searchDate);

        if ($request->filled('origin')) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('origin', $request->origin);
            });
        }

        if ($request->filled('destination')) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('destination', $request->destination);
            });
        }

        if ($request->filled('bus_type')) {
            $query->whereHas('bus', function($q) use ($request) {
                $q->where('type', $request->bus_type);
            });
        }

        $schedules = $query->orderBy('departure_time')->get();

        if ($request->input('hide_full') == '1') {
            $schedules = $schedules->filter(function ($schedule) {
                return ($schedule->bus->capacity - $schedule->reservations_count) > 0;
            });
        }

        return view('dashboard', compact('origins', 'destinations', 'schedules', 'searchDate', 'dates', 'busTypes'));
    }
}