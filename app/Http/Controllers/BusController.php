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
        // Validation (Security)
        $request->validate([
            'bus_number' => 'required|unique:buses',
            'type' => 'required',
            'capacity' => 'required|integer',
            'operator' => 'nullable|string',
        ]);

        // Save to Database
        Bus::create($request->all());

        // Redirect back with success message
        return redirect()->route('admin.buses.index')->with('success', 'Bus added successfully!');
    }
}