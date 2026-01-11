<x-app-layout>
    <x-slot name="header">
        <h2>Owners List</h2>
    </x-slot>

    <section>
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div style="background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(15,76,117,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3>All Owners</h3>
                <div>
                    <a href="{{ route('admin.dashboard') }}" style="padding: 0.5rem 1rem; background: var(--light-gray); color: var(--dark-gray); text-decoration: none; border-radius: 4px; margin-right: 0.5rem;">
                        Back to Dashboard
                    </a>
                    <a href="{{ route('admin.owners.create') }}" style="padding: 0.5rem 1rem; background: var(--primary-color); color: var(--white); text-decoration: none; border-radius: 4px;">
                        Add Owner
                    </a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($owners as $owner)
                        <tr>
                            <td>{{ $owner->id }}</td>
                            <td>{{ $owner->user->name ?? '-' }}</td>
                            <td>{{ $owner->user->email ?? '-' }}</td>
                            <td>{{ $owner->phone ?? '-' }}</td>
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
                            <td colspan="5" style="text-align: center; padding: 2rem;">No owners found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
