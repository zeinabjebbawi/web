<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\Owner;

class OwnerController extends Controller
{
    /**
     * Owner dashboard
     */
    public function dashboard()
    {
        // Get owner profile
        $user = Auth::user();
        $owner = $user->owner;

        // Check if owner profile exists
        if (!$owner) {
            // If owner profile doesn't exist, create it
            $owner = Owner::create([
                'id' => $user->id,
                'phone' => '',
            ]);
        }

        // Load ONLY this owner's places
        $places = Place::where('owner_id', $owner->id)->get();

        // Load reservations ONLY for owner's places
        $reservations = Reservation::with(['customer.user', 'place'])
            ->whereIn('hall_id', $places->pluck('id'))
            ->orderBy('start_date', 'asc')
            ->get();

        return view('owner.dashboard', compact('owner', 'places', 'reservations'));
    }

    /**
     * Create place form
     */
    public function createPlace()
    {
        return view('owner.places.create');
    }

    /**
     * Store new place (OWNER ONLY)
     */
    public function storePlace(Request $request)
    {
        // Get owner
        $owner = Auth::user()->owner;

        // Validate
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'price_per_day' => 'required|numeric',
            'capacity' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('places', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create place for this owner
        Place::create([
            'owner_id' => $owner->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'price_per_day' => $validated['price_per_day'],
            'capacity' => $validated['capacity'],
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : null,
            'available_from' => $validated['available_from'] ?? null,
            'available_to' => $validated['available_to'] ?? null,
        ]);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Place created successfully.');
    }

    /**
     * Edit place (ONLY own)
     */
    public function editPlace($id)
    {
        $owner = Auth::user()->owner;

        // Ownership security check
        $place = Place::where('id', $id)
            ->where('owner_id', $owner->id)
            ->firstOrFail();

        return view('owner.places.edit', compact('place'));
    }

    /**
     * Update place (ONLY own)
     */
    public function updatePlace(Request $request, $id)
    {
        $owner = Auth::user()->owner;

        $place = Place::where('id', $id)
            ->where('owner_id', $owner->id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'price_per_day' => 'required|numeric',
            'capacity' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
        ]);

        // Handle image uploads
        $imagePaths = json_decode($place->images ?? '[]', true) ?: [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('places', 'public');
                $imagePaths[] = $path;
            }
        }

        $place->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'price_per_day' => $validated['price_per_day'],
            'capacity' => $validated['capacity'],
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : null,
            'available_from' => $validated['available_from'] ?? null,
            'available_to' => $validated['available_to'] ?? null,
        ]);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Place updated successfully.');
    }

    /**
     * Delete place (ONLY own)
     */
    public function deletePlace($id)
    {
        $owner = Auth::user()->owner;

        $place = Place::where('id', $id)
            ->where('owner_id', $owner->id)
            ->firstOrFail();

        $place->delete();

        return redirect()->route('owner.dashboard')
            ->with('success', 'Place deleted successfully.');
    }

    /**
     * Approve reservation (ONLY for own place)
     */
    public function approveReservation($id)
    {
        $owner = Auth::user()->owner;

        $reservation = Reservation::where('id', $id)
            ->whereHas('place', fn ($q) => $q->where('owner_id', $owner->id))
            ->where('status', 'pending') // Only allow approving pending reservations
            ->firstOrFail();

        // Check for conflicts with other approved reservations
        $conflictingReservation = Reservation::where('hall_id', $reservation->hall_id)
            ->where('id', '!=', $id)
            ->where('status', 'approved')
            ->where(function ($query) use ($reservation) {
                $query->whereBetween('start_date', [$reservation->start_date, $reservation->end_date])
                    ->orWhereBetween('end_date', [$reservation->start_date, $reservation->end_date])
                    ->orWhere(function ($q) use ($reservation) {
                        $q->where('start_date', '<=', $reservation->start_date)
                          ->where('end_date', '>=', $reservation->end_date);
                    });
            })
            ->first();

        if ($conflictingReservation) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'Cannot approve: This reservation conflicts with an already approved reservation.');
        }

        $reservation->update(['status' => 'approved']);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Reservation approved.');
    }

    /**
     * Decline reservation (ONLY for own place)
     */
    public function declineReservation($id)
    {
        $owner = Auth::user()->owner;

        $reservation = Reservation::where('id', $id)
            ->whereHas('place', fn ($q) => $q->where('owner_id', $owner->id))
            ->where('status', 'pending') // Only allow declining pending reservations
            ->firstOrFail();

        $reservation->update(['status' => 'declined']);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Reservation declined.');
    }
}
