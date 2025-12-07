<?php
use App\Http\Controllers\BusController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RouteController;

Route::get('/', function () {
    return view('landingPage');
});

Route::get('/dashboard', function () {
    // If user is Admin, send them to Admin Dashboard
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Otherwise, show standard user dashboard
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
});

require __DIR__.'/auth.php';
