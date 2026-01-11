<x-app-layout>
    <x-slot name="header">
        <h2>Owner Dashboard</h2>
    </x-slot>

    <section>
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
            <h3>Welcome, {{ $owner->user->name ?? 'Owner' }}</h3>
            <p>Here you can manage your halls and respond to customer reservation requests.</p>
            <div style="margin-top: 1rem;">
                <a href="{{ route('owner.places.create') }}" style="padding: 0.5rem 1rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px; display: inline-block;">
                    Add New Hall
                </a>
            </div>
        </div>

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
            <h3>My Halls</h3>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Price / Day</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($places as $place)
                        @php
                            $images = json_decode($place->images ?? '[]', true) ?: [];
                            $mainImage = !empty($images) ? asset('storage/' . $images[0]) : asset('images/placeholder-hall.jpg');
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ $mainImage }}" alt="{{ $place->name }}" style="width: 64px; height: 64px; object-fit: cover; border-radius: 4px;" onerror="this.src='{{ asset('images/placeholder-hall.jpg') }}'">
                            </td>
                            <td>{{ $place->name }}</td>
                            <td>{{ $place->location }}</td>
                            <td>{{ $place->capacity }}</td>
                            <td>${{ number_format($place->price_per_day, 2) }}</td>
                            <td>
                                <a href="{{ route('owner.places.edit', $place->id) }}" style="padding: 0.4rem 0.8rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px; font-size: 0.875rem; margin-right: 0.5rem;">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('owner.places.delete', $place->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return showDeleteConfirmation()">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">You have not added any halls yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <h3>Reservation Requests</h3>
            <table>
                <thead>
                    <tr>
                        <th>Hall</th>
                        <th>Customer</th>
                        <th>Dates</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->place->name }}</td>
                            <td>{{ $reservation->customer->user->name ?? '—' }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($reservation->start_date)->format('M d, Y') }} → 
                                {{ \Carbon\Carbon::parse($reservation->end_date)->format('M d, Y') }}
                            </td>
                            <td>${{ number_format($reservation->total_price, 2) }}</td>
                            <td>
                                <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem; 
                                    @if($reservation->status === 'pending') background: var(--warning-orange); color: var(--white);
                                    @elseif($reservation->status === 'approved') background: var(--success-green); color: var(--white);
                                    @else background: var(--danger-red); color: var(--white);
                                    @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <form method="POST" action="{{ route('owner.reservations.approve', $reservation->id) }}" style="display: inline; margin-right: 0.5rem;">
                                        @csrf
                                        <button type="submit" style="padding: 0.4rem 0.8rem; background: var(--success-green); color: var(--white); border: none; border-radius: 4px; font-size: 0.875rem; cursor: pointer;" onclick="showApproveMessage()">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('owner.reservations.decline', $reservation->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="padding: 0.4rem 0.8rem; background: var(--danger-red); color: var(--white); border: none; border-radius: 4px; font-size: 0.875rem; cursor: pointer;" onclick="showDeclineMessage()">
                                            Decline
                                        </button>
                                    </form>
                                @else
                                    <span style="color: var(--dark-gray); font-size: 0.875rem;">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">No reservations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
