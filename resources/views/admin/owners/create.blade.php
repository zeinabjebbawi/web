<x-app-layout>
    <x-slot name="header">
        <h2>Add New Owner</h2>
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

        <form method="POST" action="{{ route('admin.owners.store') }}">
            @csrf

            <div>
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="6">
                <p style="font-size: 0.875rem; color: var(--dark-gray); margin-top: -1rem; margin-bottom: 1rem;">Minimum 6 characters</p>
            </div>

            <div>
                <label for="phone">Phone (optional)</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="actions">
                <a href="{{ route('admin.owners.index') }}" style="padding: 0.7rem 1.5rem; background: var(--light-gray); color: var(--dark-gray); text-decoration: none; border-radius: 25px; display: inline-block;">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">Save Owner</button>
            </div>
        </form>
    </section>
</x-app-layout>
