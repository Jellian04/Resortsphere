<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resortsphere</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero {
            background-image: url('{{ asset('images/burgos reef boutique resort.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 80vh;
            position: relative;
            color: white;
            background-attachment: fixed;
        }

        .hero-overlay {
            background: rgba(0, 0, 0, 0.5);
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .logo-img {
            height: 50px;
        }

        .navbar-nav {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-link {
            color: white !important;
            font-size: 1.25rem;
            margin-right: 50px;
        }

        .navbar .nav-link:last-child {
            margin-right: 0;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            background-color: rgba(255, 255, 255, 0.5);
            color: #000000 !important;
            border-radius: 6px;
            padding: 6px 12px;
            transition: all 0.3s ease-in-out;
        }

        .navbar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.5) !important;
            color: #000000 !important;
            border-radius: 6px;
            font-weight: bold;
        }

        .navbar {
            z-index: 3;
        }

        .footer-darkblue {
            background-color: #001f3f;
        }

        .card-img-top {
            object-fit: cover;
            height: 220px;
            border-bottom: 1px solid #eee;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.25rem;
            height: 100%;
        }

        .card-body .text-start {
            flex: 1;
            margin-bottom: 1.25rem; /* Adds space between the text and button */
        }

        .card-body button {
            font-size: 0.9rem;
            padding: 8px 16px;
            position: absolute;
            bottom: 15px;
            right: 15px;
            background-color: #003366; /* Dark Blue */
            color: white;
            border: 1px solid #003366;
            border-radius: 6px;
        }

        .card-body button:hover {
            background-color: #002244; /* Darker Blue */
            border-color: #002244;
            color: #ffffff;
        }

        .card-body h5,
        .card-body p {
            margin-bottom: 0.5rem;
        }

        .card-body .btn {
            float: right;
        }

        .text-dark-blue {
            color: #001f3f;
        }

        .amenities-list {
            list-style-type: none;
            padding-left: 0;
        }

        .amenities-list li {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rating {
            font-size: 1.9rem;
            color: #FFA500; /* Yellow-orange */
            letter-spacing: 2px; /* Adds spacing between stars */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .collapse.show {
            display: block;
        }

        .collapse {
            overflow: hidden;x
        }
        .home-btn {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            text-decoration: none;
            color: inherit;
            z-index: 4;
            transition: transform 0.3s ease;
            position: sticky; 
            right: 20px; 
            bottom: 5000px; 
        }

        .home-btn:hover {
            transform: scale(1.1);
        }

        .home-btn .bi {
            line-height: 1;
        }
    </style>
</head>
<body>
    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <nav class="navbar navbar-expand-lg bg-transparent position-absolute w-100">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/Logo.png') }}" alt="Resortsphere Logo" class="me-3 logo-img">
                    <h4 class="mb-0 text-white">Resortsphere</h4>
                </div>
                <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/welcome') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/inquiry') }}">Inquiry</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container h-100 d-flex justify-content-center align-items-center hero-content text-center">
            <div>
                <h1 class="display-3 fw-bold">BURGOS REEF BOUTIQUE RESORT</h1>
                <p class="lead">Find the perfect place to relax..</p>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Accommodations</h2>
        <div class="row g-4 justify-content-center">
        @php
            $accommodations = [
                [
                    'title' => 'Kayaking',
                    'image' => 'images/r4 kayaking.jpg',
                    'desc' => 'Paddle through calm waters and explore scenic coastlines with our safe and fun kayaking experience.',
                    'price' => '₱500 – ₱800 (per hour)',
                    'rating' => 4,
                    'checkin' => '9:00 AM',
                    'checkout' => '5:00 PM',
                    'amenities' => ['Kayak Rental', 'Life Vest', 'Paddle', 'Guided Tours'],
                    'more' => 'Open daily. Rental includes life vest and paddle. No prior experience required.',
                ],
                [
                    'title' => 'Restaurant',
                    'image' => 'images/r4 restaurant.jpg',
                    'desc' => 'Enjoy a variety of delicious meals in a comfortable and spacious dining area, perfect for relaxation.',
                    'price' => '₱500 – ₱1,500 per meal',
                    'rating' => 4,
                    'checkin' => '7:00 AM',
                    'checkout' => '10:00 PM',
                    'amenities' => ['Air Conditioning', 'Free Wi-Fi', 'Sea View', 'Outdoor Seating'],
                    'more' => 'Opens daily for breakfast, lunch, and dinner. A variety of cuisines with a focus on fresh, local ingredients.',
                ],
                [
                    'title' => 'Swimming Pool',
                    'image' => 'images/r4 swimming pool.jpg',
                    'desc' => 'Take a refreshing dip in our crystal-clear pool with ocean views and lounge area.',
                    'price' => '₱200 – ₱500 (per session)',
                    'rating' => 4,
                    'checkin' => '8:00 AM',
                    'checkout' => '7:00 PM',
                    'amenities' => ['Lounge Chairs', 'Pool Bar', 'Lifeguard on Duty', 'Kids Pool Area'],
                    'more' => 'Open daily. Towels and lockers available for rent. Pool bar serves snacks and drinks.',
                ],
            ];
        @endphp


            @foreach ($accommodations as $acc)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 position-relative">
                    <img src="{{ asset($acc['image']) }}" class="card-img-top" alt="{{ $acc['title'] }}">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-start text-dark">{{ $acc['title'] }}</h5>
                            <p class="text-muted text-start">{{ $acc['desc'] }}</p>

                            <div class="d-flex justify-content-between text-muted text-start">
                                <span><strong>Price per Night:</strong> {{ $acc['price'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted text-start">
                                <span><strong>Check-in:</strong> {{ $acc['checkin'] }}</span>
                                <span><strong>Check-out:</strong> {{ $acc['checkout'] }}</span>
                            </div>

                            <!-- Amenities -->
                            <ul class="amenities-list mt-2">
                                @foreach ($acc['amenities'] as $amenity)
                                    <li><i class="bi bi-check-circle-fill"></i> {{ $amenity }}</li>
                                @endforeach
                            </ul>

                            <!-- Rating -->
                            <div class="mt-2">
                                <span class="d-inline-block fw-semibold me-1 text-dark">Rating:</span>
                                <span class="rating">
                                    @for ($i = 0; $i < $acc['rating']; $i++)
                                        ★
                                    @endfor
                                    @for ($i = $acc['rating']; $i < 5; $i++)
                                        ☆
                                    @endfor
                                </span>
                            </div>

                            <!-- More Info Text -->
                            <p class="small text-muted mt-2">{{ $acc['more'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
              <!-- Home Button -->
        <a href="{{ url('/welcome') }}" class="home-btn d-flex justify-content-center align-items-center position-absolute bottom-0 end-0 m-3 rounded-circle bg-white shadow-lg p-3">
            <i class="bi bi-house-door fs-4 text-dark"></i>
        </a>
</section>

    <!-- FOOTER -->
    <footer class="footer-darkblue text-white text-center py-3">
        <div class="container">
            <p>&copy; {{ date('Y') }} Resortsphere. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const homeButton = document.querySelector('.home-btn');
            const scrollPosition = window.scrollY; 
            const parallaxEffect = scrollPosition * 0.5; 
            homeButton.style.transform = `translateY(${parallaxEffect}px)`;
        });
    </script>
</body>
</html>  