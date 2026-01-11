<x-app-layout>
    <x-slot name="header">
        <h2>Customers List</h2>
    </x-slot>

    <section>
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3>All Customers</h3>
                <div>
                    <a href="{{ route('admin.dashboard') }}" style="padding: 0.5rem 1rem; background: var(--light-gray); color: var(--dark-gray); text-decoration: none; border-radius: 4px; margin-right: 0.5rem;">
                        Back to Dashboard
                    </a>
                    <a href="{{ route('admin.customers.create') }}" style="padding: 0.5rem 1rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px;">
                        Add Customer
                    </a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->user->name ?? '-' }}</td>
                            <td>{{ $customer->user->email ?? '-' }}</td>
                            <td>{{ $customer->address ?? '-' }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
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
                            <td colspan="6" style="text-align: center; padding: 2rem;">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
