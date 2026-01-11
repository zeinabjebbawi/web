<x-app-layout>
    <x-slot name="header">
        <h2>Add New Hall</h2>
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

        <form method="POST" action="{{ route('owner.places.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required>
            </div>

            <div class="field-row">
                <div>
                    <label for="price_per_day">Price per day</label>
                    <input type="number" step="0.01" id="price_per_day" name="price_per_day" value="{{ old('price_per_day') }}" required>
                </div>
                <div>
                    <label for="capacity">Capacity</label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" required>
                </div>
            </div>

            <div class="field-row">
                <div>
                    <label for="available_from">Available From (optional)</label>
                    <input type="date" id="available_from" name="available_from" value="{{ old('available_from') }}">
                </div>
                <div>
                    <label for="available_to">Available To (optional)</label>
                    <input type="date" id="available_to" name="available_to" value="{{ old('available_to') }}">
                </div>
            </div>

            <div>
                <label for="images">Photos (multiple allowed)</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
                <p style="font-size: 0.875rem; color: var(--dark-gray); margin-top: -1rem; margin-bottom: 1rem;">You can select multiple images. Max size: 2MB per image.</p>
            </div>

            <div class="actions">
                <a href="{{ route('owner.dashboard') }}" style="padding: 0.7rem 1.5rem; background: var(--light-gray); color: var(--dark-gray); text-decoration: none; border-radius: 25px; display: inline-block;">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">Save</button>
            </div>
        </form>
    </section>
</x-app-layout>
