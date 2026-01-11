<x-app-layout>
    <x-slot name="header">
        <h2>Admin Dashboard</h2>
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

        @if($errors->any())
            <div class="error-message">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
            <h3>System Overview</h3>
            <p>Manage owners, customers, and listed halls from a single place.</p>
        </div>

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3>Owners</h3>
                <a href="{{ route('admin.owners.create') }}" style="padding: 0.5rem 1rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px;">
                    Add Owner
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($owners as $owner)
                        <tr>
                            <td>{{ $owner->id }}</td>
                            <td>{{ $owner->user->name ?? '-' }}</td>
                            <td>{{ $owner->user->email ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.owners.delete', $owner->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return showDeleteConfirmation()">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem;">No owners found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1); margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3>Customers</h3>
                <a href="{{ route('admin.customers.create') }}" style="padding: 0.5rem 1rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px;">
                    Add Customer
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->user->name ?? '-' }}</td>
                            <td>{{ $customer->user->email ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.customers.delete', $customer->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return showDeleteConfirmation()">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem;">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <h3>All Halls / Places</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Location</th>
                        <th>Price / Day</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($places as $place)
                        <tr>
                            <td>{{ $place->id }}</td>
                            <td>{{ $place->name }}</td>
                            <td>{{ $place->owner->user->name ?? '—' }}</td>
                            <td>{{ $place->location }}</td>
                            <td>${{ number_format($place->price_per_day, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem;">No halls found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
