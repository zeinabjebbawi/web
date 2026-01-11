<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rental Halls Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="{{ asset('script.js') }}"></script>
    <style>
        body {
            background: linear-gradient(120deg, var(--secondary), var(--primary-color));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <header>
        <h1>Rental Halls Portal</h1>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="page-content">
        <div class="card">
            <h2>Create an Account</h2>
            <p>
                Register as an <strong>Owner</strong> to list your halls, as a <strong>Customer</strong>
                to reserve halls, or as an <strong>Admin</strong> to manage the system.
            </p>

            <form method="POST" action="{{ route('register') }}" onsubmit="return validateRegisterForm()">
                @csrf

                <div>
                    <label for="name">Full Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-row">
                    <div>
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                        >
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        >
                        @error('password_confirmation')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="role">Register As</label>
                    <select id="role" name="role" required onchange="toggleRoleFields()">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role</option>
                        <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>Owner (list halls)</option>
                        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer (reserve halls)</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (manage system)</option>
                    </select>
                    @error('role')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-row" id="phone-address-row">
                    <div>
                        <label for="phone">Phone (optional)</label>
                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                        >
                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="address-field">
                        <label for="address">Address (owners/customers)</label>
                        <input
                            id="address"
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                        >
                        @error('address')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="department-field" style="display: none;">
                        <label for="department">Department (admins)</label>
                        <input
                            id="department"
                            type="text"
                            name="department"
                            value="{{ old('department') }}"
                            placeholder="e.g., IT, Operations"
                        >
                        @error('department')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-primary">Register</button>

                    <a class="link" href="{{ route('login') }}">
                        Already registered?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2025 Rental Halls Management System. All rights reserved.
    </footer>
</body>
</html>
