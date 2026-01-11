<x-app-layout>
    <x-slot name="header">
        <h2>Customer Dashboard</h2>
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
            <h3>Welcome, {{ $customer->user->name ?? 'Customer' }}</h3>
            <p>Browse available halls and manage your reservations.</p>
            <div style="margin-top: 1rem;">
                <a href="{{ route('customer.places') }}" style="padding: 0.5rem 1rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px; display: inline-block;">
                    Make Reservation
                </a>
            </div>
        </div>

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <h3>My Reservations</h3>
            <table>
                <thead>
                    <tr>
                        <th>Hall</th>
                        <th>Owner</th>
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
                            <td>{{ $reservation->place->owner->user->name ?? '—' }}</td>
                            <td>{{ $reservation->start_date }} → {{ $reservation->end_date }}</td>
                            <td>${{ number_format($reservation->total_price, 2) }}</td>
                            <td style="text-transform: capitalize;">{{ $reservation->status }}</td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <form method="POST" action="{{ route('customer.reservations.cancel', $reservation->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" onclick="return showDeleteConfirmation()">Cancel</button>
                                    </form>
                                @else
                                    <span style="color: var(--dark-gray); font-size: 0.875rem;">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">You have no reservations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
