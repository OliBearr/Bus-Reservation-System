<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\GeneralController;
use App\Models\Reservation;
use App\Http\Controllers\Admin\CancellationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/about', [GeneralController::class, 'about'])->name('about');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (User & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [LandingController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Process (Authenticated)
    Route::get('/booking/{schedule}/seats', [BookingController::class, 'selectSeats'])->name('booking.seats');
    
    // User My Bookings
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('user.bookings.index');
    Route::get('/my-bookings/{reservation}/receipt', [BookingController::class, 'showReceipt'])->name('user.bookings.receipt');
    
    // ✅ MOVED HERE: User Cancellation (Accessible by regular users)
    Route::post('/my-bookings/{reservation}/cancel', [BookingController::class, 'cancelBooking'])->name('user.bookings.cancel');
});

/*
|--------------------------------------------------------------------------
| Booking Flow (Public or Auth handled by controller validation)
|--------------------------------------------------------------------------
*/
Route::post('/booking/details', [BookingController::class, 'showReservationDetails'])->name('booking.details');
Route::post('/booking/confirm', [BookingController::class, 'showConfirmation'])->name('booking.confirm');
Route::post('/booking/payment', [BookingController::class, 'showPayment'])->name('booking.payment');
Route::post('/booking/process', [BookingController::class, 'processBooking'])->name('booking.process');
Route::get('/booking/success/{id}', [BookingController::class, 'showSuccess'])->name('booking.success');


/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by 'auth' AND 'admin')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Bus Management
    Route::resource('/admin/buses', BusController::class)->names([
        'index' => 'admin.buses.index',
        'create' => 'admin.buses.create',
        'store' => 'admin.buses.store',
        'edit' => 'admin.buses.edit',
        'update' => 'admin.buses.update',
        'destroy' => 'admin.buses.destroy',
    ]);

    // Route Management
    Route::get('/admin/routes', [RouteController::class, 'index'])->name('admin.routes.index');
    Route::get('/admin/routes/create', [RouteController::class, 'create'])->name('admin.routes.create');
    Route::post('/admin/routes', [RouteController::class, 'store'])->name('admin.routes.store');
    Route::get('/admin/routes/{route}/edit', [RouteController::class, 'edit'])->name('admin.routes.edit');
    Route::put('/admin/routes/{route}', [RouteController::class, 'update'])->name('admin.routes.update');
    Route::delete('/admin/routes/{id}', [RouteController::class, 'destroy'])->name('admin.routes.destroy');

    // Schedule Management (Removed Duplicates)
    Route::get('/admin/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/admin/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('/admin/schedules', [ScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::get('/admin/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('admin.schedules.edit');
    Route::put('/admin/schedules/{schedule}', [ScheduleController::class, 'update'])->name('admin.schedules.update');
    Route::delete('/admin/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');

    // ✅ MOVED HERE: Admin Reservation Viewing (Protected)
    Route::get('/admin/reservations', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/admin/reservations/{id}', [AdminReservationController::class, 'show'])->name('admin.reservations.show');

    // ✅ MOVED HERE: Admin Cancellation Approvals (Protected)
    Route::prefix('admin/cancellations')->name('admin.cancellations.')->group(function () {
        Route::get('/', [CancellationController::class, 'index'])->name('index');
        Route::put('/{reservation}/approve', [CancellationController::class, 'approve'])->name('approve');
        Route::put('/{reservation}/reject', [CancellationController::class, 'reject'])->name('reject');
    });
});

require __DIR__.'/auth.php';