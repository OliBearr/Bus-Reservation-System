<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    // 1. Show the list of buses
    public function index()
    {
        $buses = Bus::all();
        return view('admin.buses.index', compact('buses'));
    }

    // 2. Show the form to create a new bus
    public function create()
    {
        return view('admin.buses.create');
    }

    // 3. Store the new bus in the database
    public function store(Request $request)
    {
        $request->validate([
            'bus_number' => 'required|unique:buses',
            'plate_number' => 'required|unique:buses', // <--- New Rule
            'type' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required', // <--- New Rule
        ]);

        Bus::create($request->all());

        return redirect()->route('admin.buses.index')->with('success', 'Bus added successfully!');
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'bus_number' => 'required|unique:buses,bus_number,' . $bus->id,
            'plate_number' => 'required|unique:buses,plate_number,' . $bus->id, // <--- New Rule
            'type' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required',
        ]);

        $bus->update($request->all());

        return redirect()->route('admin.buses.index')->with('success', 'Bus updated successfully!');
    }
}