<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Halls Portal</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <header>
        <h1>Welcome to Our Rental Halls Portal</h1>
        <nav>
            <ul>
                <li><a href="#intro">About Us</a></li>
                <li><a href="#intro-image">View Our Halls</a></li>
                <li><a href="#appointment-info">Popular Halls</a></li>
                <li><a href="#clinic-stats">Our Platform at a Glance</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
        </nav>
    </header>

    <section id="intro">
        <h2>About Our Platform</h2>
        <p>
            We connect customers with the best rental halls and event places in your city.
            Whether you're planning a wedding, conference, graduation party, or any special event,
            our verified owners offer a variety of spaces to fit your needs and budget.
        </p>
        <h3>Our services include:</h3>
        <ul>
            <li>Wedding and celebration halls</li>
            <li>Conference and meeting venues</li>
            <li>Graduation and birthday party spaces</li>
            <li>Outdoor event areas</li>
            <li>Customizable packages with catering and decoration (owner-dependent)</li>
        </ul>
    </section>

    <section id="intro-image">
        <h2>View Our Featured Halls</h2>
        <p>
            Get a quick feel of the types of venues listed on our platform. Each hall has
            detailed information, photos, pricing, and availability dates.
        </p>
        <div class="image-wrapper">
            <img src="{{ asset('images/hall-intro.jpg') }}" alt="Beautiful decorated event hall">
        </div>
    </section>

    <section id="appointment-info">
        <h2>Book Your Hall</h2>
        <p>
            Booking a hall with us is easy! Browse places, check availability, and send your
            reservation request. Owners can approve or decline your reservation based on
            their schedule.
        </p>
        <h3>Popular Halls on Our Platform</h3>
        <ol>
            <li>Grand Aurora Hall – Perfect for weddings and large celebrations</li>
            <li>Skyline Conference Center – Ideal for corporate events</li>
            <li>Green Garden Venue – Outdoor events and parties</li>
            <li>Crystal Ballroom – Premium indoor events</li>
        </ol>
        <a href="{{ route('login') }}" class="cta-button">Login to start booking</a>
    </section>

    <section id="clinic-stats">
        <h2>Our Platform at a Glance</h2>
        <p>Here are some quick facts about our rental halls system:</p>
        <table>
            <tr>
                <th>Stat</th>
                <th>Number</th>
            </tr>
            <tr>
                <td>Registered Owners</td>
                <td>50+</td>
            </tr>
            <tr>
                <td>Available Halls</td>
                <td>120+</td>
            </tr>
            <tr>
                <td>Reservations Processed</td>
                <td>5,000+</td>
            </tr>
            <tr>
                <td>Years of Service</td>
                <td>5</td>
            </tr>
        </table>
    </section>

    <footer>
        <p>&copy; 2025 Rental Halls Management System. All rights reserved.</p>
    </footer>

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
