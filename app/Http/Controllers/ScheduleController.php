<?php

namespace App\Http\Controllers;

use App\Interfaces\ScheduleRepositoryInterface;
use App\Models\Bus;   // Needed for the dropdown
use App\Models\Route; // Needed for the dropdown
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private ScheduleRepositoryInterface $scheduleRepository;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function index()
    {
        $schedules = $this->scheduleRepository->getAllSchedules();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        // We need to pass all Buses and Routes to the view so the Admin can select them
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.schedules.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        $this->scheduleRepository->createSchedule($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Trip scheduled successfully!');
    }

    public function destroy($id)
    {
        $this->scheduleRepository->deleteSchedule($id);
        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted!');
    }
}