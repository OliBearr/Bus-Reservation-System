<?php
use App\Http\Controllers\BusController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LandingController;

Route::get('/', function () {
    return view('landingPage');
});

// Use the controller for the homepage
Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user instanceof \App\Models\User && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Admin Routes (Protected by 'auth' AND 'admin' middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Bus Management Routes
    Route::get('/admin/buses', [BusController::class, 'index'])->name('admin.buses.index');
    Route::get('/admin/buses/create', [BusController::class, 'create'])->name('admin.buses.create');
    Route::post('/admin/buses', [BusController::class, 'store'])->name('admin.buses.store');

    // Route Management (Uses Repository Pattern)
    Route::get('/admin/routes', [RouteController::class, 'index'])->name('admin.routes.index');
    Route::get('/admin/routes/create', [RouteController::class, 'create'])->name('admin.routes.create');
    Route::post('/admin/routes', [RouteController::class, 'store'])->name('admin.routes.store');
    Route::delete('/admin/routes/{id}', [RouteController::class, 'destroy'])->name('admin.routes.destroy');

    // Schedule Management
    Route::get('/admin/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/admin/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('/admin/schedules', [ScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::delete('/admin/schedules/{id}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
});

require __DIR__.'/auth.php';
