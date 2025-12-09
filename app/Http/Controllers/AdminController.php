<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Get Counts
        $totalBuses = Bus::count();
        $totalSchedules = Schedule::count();
        $totalBookings = Reservation::count();
        
        // 2. Calculate Revenue
        // Sum of all: (Reservation -> Schedule -> Route -> Price)
        $totalRevenue = Reservation::with(['schedule.route'])
            ->get()
            ->sum(function($reservation) {
                return $reservation->schedule->route->price ?? 0;
            });

        // 3. Get Recent Reservations (Top 5 latest)
        $recentReservations = Reservation::with(['user', 'schedule.route'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalBuses', 'totalSchedules', 'totalBookings', 'totalRevenue', 'recentReservations'));
    }
}