<header>
    @php
        $dashboardRoute = Auth::user()->isAdmin() ? 'admin.dashboard' : (Auth::user()->isOwner() ? 'owner.dashboard' : 'customer.dashboard');
        $userName = Auth::user()->name;
    @endphp
    <h1>Welcome, {{ $userName }}</h1>
    <nav>
        <ul>
            <li><a href="{{ route($dashboardRoute) }}">Dashboard</a></li>
            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: var(--white); padding: 0.4rem 1.2rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; cursor: pointer;">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</header>
