<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Halls Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
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
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
        </nav>
    </header>

    <div class="page-content">
        <div class="card">
            <h2>Login</h2>
            <p>Sign in to access your dashboard as an Admin, Owner, or Customer.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <button type="submit" class="btn-primary">Login</button>

                    <a class="link" href="{{ route('register') }}">
                        Don't have an account?
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
