<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\Customer;
use App\Models\Reservation;

class CustomerController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function dashboard()
    {
        // 1) Get logged-in user
        $user = Auth::user();

        // 2) Get related customer profile
        $customer = $user->customer;

        // 3) Check if customer profile exists
        if (!$customer) {
            // If customer profile doesn't exist, create it
            $customer = Customer::create([
                'id' => $user->id,
                'address' => '',
                'phone' => null,
            ]);
        }

        // 4) Load this customer's reservations
        $reservations = Reservation::with(['place.owner.user'])
            ->where('customer_id', $customer->id)
            ->orderBy('start_date', 'asc')
            ->get();

        // 5) Return dashboard view
        return view('customer.dashboard', [
            'customer' => $customer,
            'reservations' => $reservations,
        ]);
    }

    /**
     * List available places
     */
    public function listPlaces()
    {
        $places = Place::with('owner.user')->get();

        return view('customer.places.index', [
            'places' => $places,
        ]);
    }

    /**
     * Show a single place
     */
    public function showPlace($id)
    {
        $place = Place::with('owner.user')->findOrFail($id);

        return view('customer.places.show', [
            'place' => $place,
        ]);
    }

    /**
     * Show reservation confirmation page.
     */
    public function confirmReservation(Request $request)
    {
        $validated = $request->validate([
            'hall_id' => 'required|exists:places,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $place = Place::with('owner.user')->findOrFail($validated['hall_id']);

        // Calculate total price
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $numberOfDays = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $numberOfDays * $place->price_per_day;

        return view('customer.reservations.confirm', [
            'place' => $place,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'number_of_days' => $numberOfDays,
            'total_price' => $totalPrice,
        ]);
    }

    /**
     * Store a new reservation.
     */
    public function storeReservation(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;

        // Ensure customer profile exists
        if (!$customer) {
            $customer = Customer::create([
                'id' => $user->id,
                'address' => '',
                'phone' => null,
            ]);
        }

        // Validate booking data
        $validated = $request->validate([
            'hall_id' => 'required|exists:places,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Get the place
        $place = Place::findOrFail($validated['hall_id']);

        // Check availability window (if set)
        if ($place->available_from && $place->available_from > $validated['start_date']) {
            return back()->withErrors(['start_date' => 'The selected date is before the place availability start date.'])->withInput();
        }
        if ($place->available_to && $place->available_to < $validated['end_date']) {
            return back()->withErrors(['end_date' => 'The selected date is after the place availability end date.'])->withInput();
        }

        // Check for overlapping reservations (approved or pending)
        $overlappingReservation = Reservation::where('hall_id', $validated['hall_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                          ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->first();

        if ($overlappingReservation) {
            return back()->withErrors(['hall_id' => 'This place is already reserved for the selected dates.'])->withInput();
        }

        // Calculate total price
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $numberOfDays = $startDate->diffInDays($endDate) + 1; // +1 to include both start and end date
        $totalPrice = $numberOfDays * $place->price_per_day;

        // Create reservation
        Reservation::create([
            'customer_id' => $customer->id,
            'hall_id' => $validated['hall_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Reservation created successfully and is pending approval.');
    }

    /**
     * Update an existing reservation.
     */
    public function updateReservation(Request $request, $id)
    {
        $user = Auth::user();
        $customer = $user->customer;

        // Ensure customer profile exists
        if (!$customer) {
            $customer = Customer::create([
                'id' => $user->id,
                'address' => '',
                'phone' => null,
            ]);
        }

        // Ensure reservation belongs to this customer and is still pending
        $reservation = Reservation::where('id', $id)
            ->where('customer_id', $customer->id)
            ->where('status', 'pending') // Only allow updates to pending reservations
            ->firstOrFail();

        $validated = $request->validate([
            'hall_id' => 'required|exists:places,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Get the place
        $place = Place::findOrFail($validated['hall_id']);

        // Check availability window (if set)
        if ($place->available_from && $place->available_from > $validated['start_date']) {
            return back()->withErrors(['start_date' => 'The selected date is before the place availability start date.'])->withInput();
        }
        if ($place->available_to && $place->available_to < $validated['end_date']) {
            return back()->withErrors(['end_date' => 'The selected date is after the place availability end date.'])->withInput();
        }

        // Check for overlapping reservations (approved or pending), excluding current reservation
        $overlappingReservation = Reservation::where('hall_id', $validated['hall_id'])
            ->where('id', '!=', $id) // Exclude current reservation
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                          ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->first();

        if ($overlappingReservation) {
            return back()->withErrors(['hall_id' => 'This place is already reserved for the selected dates.'])->withInput();
        }

        // Calculate total price
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $numberOfDays = $startDate->diffInDays($endDate) + 1; // +1 to include both start and end date
        $totalPrice = $numberOfDays * $place->price_per_day;

        $reservation->update([
            'hall_id' => $validated['hall_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Cancel a reservation.
     */
    public function cancelReservation($id)
    {
        $user = Auth::user();
        $customer = $user->customer;

        // Ensure customer profile exists
        if (!$customer) {
            $customer = Customer::create([
                'id' => $user->id,
                'address' => '',
                'phone' => null,
            ]);
        }

        $reservation = Reservation::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        $reservation->delete();

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Reservation cancelled successfully.');
    }
}