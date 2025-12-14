<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;


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
        // 1. Validate inputs (Updated for Arrays)
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
            // Validate the array of passengers
            'passengers' => 'required|array',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.surname' => 'required|string',
            'passengers.*.discount_id' => 'nullable|string',
        ]);

        // 2. Fetch Data
        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        $selectedSeats = explode(',', $request->seats);
        $totalPrice = count($selectedSeats) * $schedule->route->price;
        
        // 3. Pass data to View
        return view('booking.confirm', compact(
            'schedule', 
            'selectedSeats', 
            'totalPrice', 
            'validated' // Contains passengers and contact info
        ));
    }
    // Step 4: Show Payment Page
    public function showPayment(Request $request)
    {
        $data = $request->all(); 
        
        $schedule = Schedule::with('route')->findOrFail($request->schedule_id);
        $seats = explode(',', $request->seats);
        $basePrice = $schedule->route->price;

        // --- CALCULATE BREAKDOWN ---
        $priceBreakdown = [];
        $totalPrice = 0;

        if (isset($data['passengers']) && is_array($data['passengers'])) {
            foreach ($data['passengers'] as $index => $passenger) {
                $ticketPrice = $basePrice;
                $discountId = $passenger['discount_id'] ?? '';
                $isDiscounted = false;

                // CHECK FORMAT: 4 digits - 4 digits (e.g., 1234-5678)
                if (preg_match('/^\d{4}-\d{4}$/', $discountId)) {
                    $ticketPrice = $basePrice * 0.80; // 20% Off
                    $isDiscounted = true;
                }

                $totalPrice += $ticketPrice;

                // Save details for the view
                $priceBreakdown[] = [
                    'name' => $passenger['first_name'] . ' ' . $passenger['surname'],
                    'original_price' => $basePrice,
                    'final_price' => $ticketPrice,
                    'is_discounted' => $isDiscounted,
                    'seat' => $seats[$index] ?? 'N/A'
                ];
            }
        } else {
            // Fallback
            $totalPrice = count($seats) * $basePrice;
        }

        return view('booking.payment', compact('data', 'schedule', 'totalPrice', 'seats', 'priceBreakdown'));
    }

    // Step 5: Process Booking (Save to DB)
    public function processBooking(Request $request)
    {
        $transactionId = 'TRX-' . strtoupper(uniqid()); 
        $seatList = explode(',', $request->seats);
        
        // Loop through the seats and the passengers array simultaneously
        // Note: The array keys for 'passengers' correspond to the index of seats
        foreach ($seatList as $index => $seat) {
            
            // Get the specific passenger details for this seat index
            $passenger = $request->passengers[$index];
            $fullName = $passenger['first_name'] . ' ' . $passenger['surname'];
            $discountId = $passenger['discount_id'] ?? null;

            \App\Models\Reservation::create([
                'user_id' => auth()->id(),
                'schedule_id' => $request->schedule_id,
                'seat_number' => $seat,
                'status' => 'confirmed',
                'transaction_id' => $transactionId,
                'payment_method' => 'SecurePay / Credit Card',
                
                // SAVE NEW FIELDS
                'passenger_name' => $fullName,
                'discount_id_number' => $discountId,
            ]);
        }

        return redirect()->route('booking.success', ['id' => $transactionId]);
    }

    // Step 6: Show Success Ticket
    public function showSuccess($id)
    {
        return view('booking.success', compact('id'));
    }
    
    public function myBookings()
    {
        $userId = auth()->id();
        $now = \Carbon\Carbon::now();

        // 1. Get UPCOMING Trips
        // We use the 'Reservation' model instead of 'Booking'
        $upcomingBookings = \App\Models\Reservation::where('user_id', $userId)
            ->whereHas('schedule', function($q) use ($now) {
                $q->where('departure_time', '>=', $now);
            })
            ->with(['schedule.route', 'schedule.bus'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Get PAST Trips
        $pastBookings = \App\Models\Reservation::where('user_id', $userId)
            ->whereHas('schedule', function($q) use ($now) {
                $q->where('departure_time', '<', $now);
            })
            ->with(['schedule.route', 'schedule.bus'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.my-bookings', compact('upcomingBookings', 'pastBookings'));
    }

    public function showReceipt($id)
    {
        // 1. Fetch data using the ID
        $reservation = \App\Models\Reservation::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['schedule.route', 'schedule.bus'])
            ->firstOrFail();

        // 2. Pass it to the view as 'reservation' (NOT 'booking')
        return view('booking.receipt', compact('reservation'));
    }

    public function cancelBooking(Request $request, $id)
    {
        // 1. Get the Reservation ID safely
        $reservationId = ($id instanceof \App\Models\Reservation) ? $id->id : $id;

        // 2. Validate the Reason
        $request->validate([
            'cancellation_reason' => ['required', 'string', 'min:5'],
        ]);

        // 3. Find the Booking
        $reservation = \App\Models\Reservation::findOrFail($reservationId);

        // 4. Security Check (Ensure user owns this booking)
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // 5. Update the Database
        // Since you fixed $fillable in Reservation.php, we can use the clean update() method
        $reservation->update([
            'cancellation_status' => 'pending',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        // 6. Redirect with Success Message
        return redirect()->route('user.bookings.index')
            ->with('success', 'Cancellation request submitted successfully.');
    }
}