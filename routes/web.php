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


Route::get('/', function () {
    return view('landingPage');
});

Route::get('/about', [GeneralController::class, 'about'])->name('about');

// Use the controller for the homepage
Route::get('/', [LandingController::class, 'index'])->name('home');

// User Bookings Management
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('user.bookings.index');

Route::get('/dashboard', [LandingController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/booking/{schedule}/seats', [BookingController::class, 'selectSeats'])->name('booking.seats');
    Route::get('/my-bookings/{reservation}/receipt', [BookingController::class, 'showReceipt'])->name('user.bookings.receipt');
});
// Admin Routes (Protected by 'auth' AND 'admin' middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // User Cancellation Request
    Route::post('/my-bookings/{reservation}/cancel', [BookingController::class, 'cancelBooking'])->name('user.bookings.cancel');

    // Bus Management Routes
    Route::get('/admin/buses', [BusController::class, 'index'])->name('admin.buses.index');
    Route::get('/admin/buses/create', [BusController::class, 'create'])->name('admin.buses.create');
    Route::post('/admin/buses', [BusController::class, 'store'])->name('admin.buses.store');
    
    Route::get('/admin/buses/{bus}/edit', [BusController::class, 'edit'])->name('admin.buses.edit');
    Route::put('/admin/buses/{bus}', [BusController::class, 'update'])->name('admin.buses.update');
    Route::delete('/admin/buses/{bus}', [BusController::class, 'destroy'])->name('admin.buses.destroy');

    // Route Management (Uses Repository Pattern)
    Route::get('/admin/routes', [RouteController::class, 'index'])->name('admin.routes.index');
    Route::get('/admin/routes/create', [RouteController::class, 'create'])->name('admin.routes.create');
    Route::post('/admin/routes', [RouteController::class, 'store'])->name('admin.routes.store');
    Route::delete('/admin/routes/{id}', [RouteController::class, 'destroy'])->name('admin.routes.destroy');

    Route::get('/admin/routes/{route}/edit', [RouteController::class, 'edit'])->name('admin.routes.edit');
    Route::put('/admin/routes/{route}', [RouteController::class, 'update'])->name('admin.routes.update');
    Route::delete('/admin/routes/{id}', [RouteController::class, 'destroy'])->name('admin.routes.destroy');

    // Schedule Management
    Route::get('/admin/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/admin/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('/admin/schedules', [ScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::delete('/admin/schedules/{id}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');

    Route::get('/admin/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');

    Route::post('/admin/schedules', [ScheduleController::class, 'store'])->name('admin.schedules.store');

    Route::get('/admin/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('admin.schedules.edit');
    Route::put('/admin/schedules/{schedule}', [ScheduleController::class, 'update'])->name('admin.schedules.update');
    Route::delete('/admin/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');

});

// Step 2: Reservation Details
    Route::post('/booking/details', [BookingController::class, 'showReservationDetails'])->name('booking.details');

// Step 3: Confirmation
    Route::post('/booking/confirm', [BookingController::class, 'showConfirmation'])->name('booking.confirm');

// Step 4: Payment Page
    Route::post('/booking/payment', [BookingController::class, 'showPayment'])->name('booking.payment');
    
// Step 5: Finalize Booking (Save to DB)
    Route::post('/booking/process', [BookingController::class, 'processBooking'])->name('booking.process');

// Step 6: Success Page
    Route::get('/booking/success/{id}', [BookingController::class, 'showSuccess'])->name('booking.success');

// Reservation Management
    Route::get('/admin/reservations', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/admin/reservations/{id}', [AdminReservationController::class, 'show'])->name('admin.reservations.show');

// Cancellation Management
Route::prefix('admin/cancellations')->name('admin.cancellations.')->group(function () {
    Route::get('/', [CancellationController::class, 'index'])->name('index');
    Route::put('/{reservation}/approve', [CancellationController::class, 'approve'])->name('approve');
    Route::put('/{reservation}/reject', [CancellationController::class, 'reject'])->name('reject');
});

require __DIR__.'/auth.php';
