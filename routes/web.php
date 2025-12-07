<?php
use App\Http\Controllers\BusController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
});

require __DIR__.'/auth.php';
