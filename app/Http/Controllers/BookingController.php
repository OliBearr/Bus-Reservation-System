<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Reservation; // Main model used for bookings
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
// use App\Models\Booking; // Unused if we are sticking to Reservation model

class BookingController extends Controller
{
    // Step 1: Show the Seat Selection Page
    public function selectSeats($schedule_id)
    {
        // FIX: Filter the reservations relation.
        // We only want to retrieve "Active" or "Pending" reservations.
        // "Approved" cancellations are ignored, so the seat appears FREE.
        $schedule = Schedule::with(['bus', 'route', 'reservations' => function($query) {
            $query->where(function($q) {
                $q->where('cancellation_status', '!=', 'approved') // If approved, ignore it (seat free)
                  ->orWhereNull('cancellation_status');            // If null, it's active (seat taken)
            });
        }])->findOrFail($schedule_id);

        // Pluck only the seat numbers found by the filter above
        $takenSeats = $schedule->reservations->pluck('seat_number')->toArray();

        return view('booking.seats', compact('schedule', 'takenSeats'));
    }

    // Step 2: Show Details Form
    public function showReservationDetails(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats' => 'required|string',
        ]);

        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        
        $selectedSeats = explode(',', $request->seats);
        $totalPrice = count($selectedSeats) * $schedule->route->price;

        return view('booking.reservation', compact('schedule', 'selectedSeats', 'totalPrice'));
    }

    // Step 3: Show Confirmation Page
    public function showConfirmation(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
            'passengers' => 'required|array',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.surname' => 'required|string',
            'passengers.*.discount_id' => 'nullable|string',
        ]);

        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        $selectedSeats = explode(',', $request->seats);
        $totalPrice = count($selectedSeats) * $schedule->route->price;

        return view('booking.confirm', compact(
            'schedule', 
            'selectedSeats', 
            'totalPrice', 
            'validated'
        ));
    }

    // Step 4: Show Payment Page
    public function showPayment(Request $request)
    {
        $data = $request->all(); 
        
        $schedule = Schedule::with('route')->findOrFail($request->schedule_id);
        $seats = explode(',', $request->seats);
        $basePrice = $schedule->route->price;
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
                'passenger_name' => $fullName,
                'discount_id_number' => $discountId,
                'cancellation_status' => null
            ]);
        }

        return redirect()->route('booking.success', ['id' => $transactionId]);
    }

    // Step 6: Show Success Ticket
    public function showSuccess($id)
    {
        return view('booking.success', compact('id'));
    }
    
    // User My Bookings Page
    public function myBookings()
    {
        $userId = auth()->id();
        $now = \Carbon\Carbon::now();

        // 1. Get UPCOMING Trips
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
        $reservation = \App\Models\Reservation::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['schedule.route', 'schedule.bus'])
            ->firstOrFail();

        return view('booking.receipt', compact('reservation'));
    }

    // ACTION: User Requests Cancellation
    public function cancelBooking(Request $request, $id)
    {
        // 1. Find the Reservation
        $reservation = \App\Models\Reservation::findOrFail($id);

        // 2. Security: Owner check
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // 3. Mark as PENDING cancellation
        // The record stays, and the seat is STILL TAKEN until admin approves.
        $reservation->update([
            'cancellation_status' => 'pending',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->back()->with('success', 'Cancellation requested. Waiting for admin approval.');
    }

    // ACTION: Admin Approves Cancellation (Releases Seat)
    public function approveCancellation($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        $reservation->update([
            'cancellation_status' => 'approved' 
        ]);

        return redirect()->back()->with('success', 'Booking cancelled and seat released.');
    }
}