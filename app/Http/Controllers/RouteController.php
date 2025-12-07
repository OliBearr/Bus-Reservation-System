<?php

namespace App\Http\Controllers;

use App\Interfaces\RouteRepositoryInterface; // Using Interface, not Model!
use Illuminate\Http\Request;

class RouteController extends Controller
{
    private RouteRepositoryInterface $routeRepository;

    // CONSTRUCTOR INJECTION (Design Pattern)
    public function __construct(RouteRepositoryInterface $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    public function index()
    {
        // The controller doesn't know "how" data is fetched, it just asks the repo.
        $routes = $this->routeRepository->getAllRoutes();
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $this->routeRepository->createRoute($validated);

        return redirect()->route('admin.routes.index')->with('success', 'Route added via Repository Pattern!');
    }

    public function destroy($id)
    {
        $this->routeRepository->deleteRoute($id);
        return redirect()->route('admin.routes.index')->with('success', 'Route deleted successfully!');
    }
}