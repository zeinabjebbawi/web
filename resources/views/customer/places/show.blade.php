<x-app-layout>
    <x-slot name="header">
        <h2>{{ $place->name }}</h2>
    </x-slot>

    <section>
        @php
            $images = json_decode($place->images ?? '[]', true) ?: [];
        @endphp

        @if(!empty($images))
            <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
                <h3>Photos</h3>
                <div class="grid grid-cols-1" style="gap: 1rem; margin-top: 1rem;">
                    @foreach($images as $image)
                        <div style="width: 100%; height: 250px; background: var(--light-gray); border-radius: 8px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $place->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('images/placeholder-hall.jpg') }}'">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
            <h3>Hall Details</h3>
            <p style="margin: 0.5rem 0;"><strong>Owner:</strong> {{ $place->owner->user->name ?? '—' }}</p>
            <p style="margin: 0.5rem 0;"><strong>Location:</strong> {{ $place->location }}</p>
            <p style="margin: 0.5rem 0;"><strong>Capacity:</strong> {{ $place->capacity }} people</p>
            <p style="margin: 0.5rem 0;"><strong>Price per day:</strong> ${{ number_format($place->price_per_day, 2) }}</p>
            @if($place->available_from || $place->available_to)
                <p style="margin: 0.5rem 0;">
                    <strong>Availability:</strong>
                    {{ $place->available_from ? \Carbon\Carbon::parse($place->available_from)->format('M d, Y') : '—' }} → 
                    {{ $place->available_to ? \Carbon\Carbon::parse($place->available_to)->format('M d, Y') : '—' }}
                </p>
            @endif
            <div style="margin-top: 1rem;">
                <strong>Description:</strong>
                <p style="margin-top: 0.5rem;">{{ $place->description }}</p>
            </div>
        </div>

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <h3>Reserve This Hall</h3>

            @if ($errors->any())
                <div class="error-message" style="margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="GET" action="{{ route('customer.reservations.confirm') }}">
                <input type="hidden" name="hall_id" value="{{ $place->id }}">

                <div class="field-row">
                    <div>
                        <label for="start_date">Start Date</label>
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ old('start_date') }}"
                            required
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        >
                    </div>
                    <div>
                        <label for="end_date">End Date</label>
                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ old('end_date') }}"
                            required
                            min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                        >
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ route('customer.places') }}" style="padding: 0.7rem 1.5rem; background: var(--light-gray); color: var(--dark-gray); text-decoration: none; border-radius: 25px; display: inline-block;">
                        Back to Halls
                    </a>
                    <button type="submit" class="btn-primary">Reserve Now</button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
