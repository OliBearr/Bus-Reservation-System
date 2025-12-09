<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{
    // Show the Seat Selection Page
    public function selectSeats($schedule_id)
    {
        // 1. Find the Schedule
        $schedule = Schedule::with(['bus', 'route', 'reservations'])->findOrFail($schedule_id);

        // 2. Get the IDs of seats that are already taken
        $takenSeats = $schedule->reservations->pluck('seat_number')->toArray();

        // 3. Return the view
        return view('booking.seats', compact('schedule', 'takenSeats'));
    }

    public function showReservationDetails(Request $request)
    {
        // 1. Validate incoming data
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats' => 'required|string', // "1,2,3"
        ]);

        // 2. Fetch Schedule Data
        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        
        // 3. Parse Seats
        $selectedSeats = explode(',', $request->seats);
        $totalPrice = count($selectedSeats) * $schedule->route->price;

        // 4. Return View
        return view('booking.reservation', compact('schedule', 'selectedSeats', 'totalPrice'));
    }

    // Step 3: Show Confirmation Page
    public function showConfirmation(Request $request)
    {
        // 1. Validate inputs
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats' => 'required|string',
            'passenger_name' => 'required|string',
            'passenger_email' => 'required|email',
            'passenger_phone' => 'required|string',
            'passenger_gender' => 'required|string',
        ]);

        // 2. Fetch Data
        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        $selectedSeats = explode(',', $request->seats);
        $totalPrice = count($selectedSeats) * $schedule->route->price;
        
        // 3. Group Passenger Info
        $passenger = $request->only(['passenger_name', 'passenger_email', 'passenger_phone', 'passenger_gender']);

        return view('booking.confirm', compact('schedule', 'selectedSeats', 'totalPrice', 'passenger'));
    }
    // Step 4: Show Payment Page
    public function showPayment(Request $request)
    {
        // Pass all the data forward to the payment view
        $data = $request->all();
        $schedule = Schedule::with('route')->findOrFail($request->schedule_id);
        $seats = explode(',', $request->seats);
        $totalPrice = count($seats) * $schedule->route->price;

        return view('booking.payment', compact('data', 'schedule', 'totalPrice', 'seats'));
    }

    // Step 5: Process Booking (Save to DB)
    public function processBooking(Request $request)
    {
        // 1. Generate a Secure Transaction Reference (Random string, no card info)
        $transactionId = 'TRX-' . strtoupper(uniqid()); 

        // 2. Create the reservations
        $seatList = explode(',', $request->seats);
        
        foreach ($seatList as $seat) {
            \App\Models\Reservation::create([
                'user_id' => auth()->id(),
                'schedule_id' => $request->schedule_id,
                'seat_number' => $seat,
                'status' => 'confirmed',
                'transaction_id' => $transactionId, // <--- Saving the Reference
                'payment_method' => 'SecurePay / Credit Card', // <--- Saving the Method
            ]);
        }

        // 3. Redirect to Success
        return redirect()->route('booking.success', ['id' => $transactionId]);
    }

    // Step 6: Show Success Ticket
    public function showSuccess($id)
    {
        return view('booking.success', compact('id'));
    }

    public function myBookings()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // 1. Fetch reservations, joining the schedules table to access departure_time
        $reservations = Reservation::where('reservations.user_id', auth()->id())
            ->join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            // Select reservations.* to avoid selecting duplicate IDs from the join
            ->select('reservations.*') 
            ->with(['schedule.route', 'schedule.bus'])
            
            // 2. Order by the column from the joined table
            ->orderBy('schedules.departure_time', 'desc') 
            ->get();

        return view('booking.my-bookings', compact('reservations'));
    }

    public function showReceipt(Reservation $reservation)
    {
        // 1. SECURITY CHECK: Ensure the reservation belongs to the logged-in user
        if ($reservation->user_id !== auth()->id()) {
            // Halt access if the user tries to view someone else's booking
            abort(403, 'Unauthorized. This booking does not belong to your account.');
        }

        // 2. Eager load related data
        $reservation->load(['user', 'schedule.route', 'schedule.bus']);

        // 3. Reuse the existing detailed Admin view (admin.reservations.show) 
        // to avoid duplicating the complex receipt template.
        return view('booking.receipt', compact('reservation')); 
    }

    // Cancel Booking
    public function cancelBooking(Request $request, $reservationId)
    {
        // 1. Validation (Must pass to proceed)
        $request->validate([
            'cancellation_reason' => ['required', 'string', 'min:10'],
        ]);
        
        // 2. Find the reservation and relationships
        $reservation = Reservation::with('schedule')->findOrFail($reservationId);
        
        // 3. Security and Policy Checks
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized. This booking does not belong to your account.');
        }

        $isPastTrip = Carbon::parse($reservation->schedule->departure_time)->isPast();
        
        if ($isPastTrip || $reservation->cancellation_status !== 'none') {
             return back()->with('error', 'This booking cannot be cancelled or is already under review.');
        }

        $updated = DB::table('reservations')
            ->where('id', $reservationId)
            ->update([
                'cancellation_status' => 'pending',
                'cancellation_reason' => $request->cancellation_reason,
                'updated_at' => now(), 
            ]);

        if (!$updated) {
            // If even raw SQL fails, the database connection is faulty or the ENUM definition is wrong.
            return back()->with('error', 'FATAL ERROR: Raw database update failed.');
        }
    }
}