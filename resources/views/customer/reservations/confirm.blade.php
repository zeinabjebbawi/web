<x-app-layout>
    <x-slot name="header">
        <h2>Confirm Reservation</h2>
    </x-slot>

    <section>
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
            <h3>Reservation Summary</h3>
            
            <div style="margin-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">Hall:</span>
                    <span>{{ $place->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">Owner:</span>
                    <span>{{ $place->owner->user->name ?? '—' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">Location:</span>
                    <span>{{ $place->location }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">Capacity:</span>
                    <span>{{ $place->capacity }} people</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">Start Date:</span>
                    <span>{{ \Carbon\Carbon::parse($start_date)->format('M d, Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">End Date:</span>
                    <span>{{ \Carbon\Carbon::parse($end_date)->format('M d, Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">Number of Days:</span>
                    <span>{{ $number_of_days }} day(s)</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-weight: 600;">Price per Day:</span>
                    <span>${{ number_format($place->price_per_day, 2) }}</span>
                </div>
                <div style="border-top: 2px solid var(--border-color); padding-top: 1rem; margin-top: 1rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 1.25rem;">
                        <span style="font-weight: 700;">Total Price:</span>
                        <span style="font-weight: 700; color: var(--primary-color);">${{ number_format($total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @php
            $images = json_decode($place->images ?? '[]', true) ?: [];
            $mainImage = !empty($images) ? asset('storage/' . $images[0]) : asset('images/placeholder-hall.jpg');
        @endphp
        @if(!empty($images))
            <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
                <div style="width: 100%; height: 300px; background: var(--light-gray); border-radius: 8px; overflow: hidden;">
                    <img src="{{ $mainImage }}" alt="{{ $place->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('images/placeholder-hall.jpg') }}'">
                </div>
            </div>
        @endif

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <p style="margin-bottom: 1.5rem; font-size: 0.9rem;">
                Please review your reservation details above. Once confirmed, your reservation will be submitted for approval by the hall owner.
            </p>

            <form method="POST" action="{{ route('customer.reservations.store') }}">
                @csrf
                <input type="hidden" name="hall_id" value="{{ $place->id }}">
                <input type="hidden" name="start_date" value="{{ $start_date }}">
                <input type="hidden" name="end_date" value="{{ $end_date }}">

                <div class="actions">
                    <a href="{{ route('customer.places.show', $place->id) }}" style="padding: 0.7rem 1.5rem; background: var(--light-gray); color: var(--dark-gray); text-decoration: none; border-radius: 25px; display: inline-block;">
                        Back
                    </a>
                    <button type="submit" class="btn-primary" onclick="showBookConfirmation()">Confirm Reservation</button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
