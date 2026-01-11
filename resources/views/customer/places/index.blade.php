<x-app-layout>
    <x-slot name="header">
        <h2>Available Halls</h2>
    </x-slot>

    <section>
        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <p style="margin-bottom: 1.5rem;">Browse all halls and click "View Details" to see more information and create a reservation.</p>

            <div class="grid grid-cols-1" style="gap: 2rem;">
                @forelse($places as $place)
                    @php
                        $images = json_decode($place->images ?? '[]', true) ?: [];
                        $mainImage = !empty($images) ? asset('storage/' . $images[0]) : asset('images/placeholder-hall.jpg');
                    @endphp
                    <div style="border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; background: var(--white);">
                        <div style="width: 100%; height: 200px; background: var(--light-gray); overflow: hidden;">
                            <img src="{{ $mainImage }}" alt="{{ $place->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('images/placeholder-hall.jpg') }}'">
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: var(--secondary);">{{ $place->name }}</h3>
                            <p style="margin-bottom: 0.5rem; font-size: 0.9rem;"><strong>Owner:</strong> {{ $place->owner->user->name ?? '—' }}</p>
                            <p style="margin-bottom: 0.5rem; font-size: 0.9rem;"><strong>Location:</strong> {{ $place->location }}</p>
                            <p style="margin-bottom: 0.5rem; font-size: 0.9rem;"><strong>Capacity:</strong> {{ $place->capacity }} people</p>
                            <p style="font-size: 1.1rem; font-weight: 600; color: var(--primary-color); margin: 1rem 0;">
                                ${{ number_format($place->price_per_day, 2) }} / day
                            </p>
                            <a href="{{ route('customer.places.show', $place->id) }}" style="display: block; text-align: center; padding: 0.75rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px; margin-top: 1rem;">
                                View Details & Reserve
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 3rem;">
                        <p style="color: var(--dark-gray);">No halls available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>
