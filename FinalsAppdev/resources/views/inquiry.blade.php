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
            background-image: url('{{ asset('images/hero.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 80vh;
            position: relative;
            color: white;
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
            background-color: rgba(255, 255, 255, 0.5); /* More visible translucent white */
            color: #000000 !important; /* Black text on hover */
            border-radius: 6px;
            padding: 6px 12px;
            transition: all 0.3s ease-in-out;
        }

        .navbar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.5) !important; /* Same translucent white background */
            color: #000000 !important; /* Black text */
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
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body .text-start {
            flex: 1;
        }

        .text-dark-blue {
            color: #001f3f;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-transparent position-absolute w-100">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Resortsphere Logo" class="me-3 logo-img">
                <h4 class="mb-0 text-white">Resortsphere</h4>
            </div>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/welcome') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Inquiry</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container h-100 d-flex justify-content-center align-items-center hero-content text-center">
            <div>
                <h1 class="display-3 fw-bold text-white">INQUIRY</h1>
                <p class="lead text-white">We're here to help! Select your inquiry type and send us your message.</p>
            </div>
        </div>
    </section>

   <!-- INQUIRY FORM SECTION -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="row g-0 align-items-stretch">
                        <!-- LEFT: Icon or Image -->
                        <div class="col-md-6 d-none d-md-block">
                            <img src="{{ asset('/images/msgs.jpg') }}" alt="Inquiry Icon" 
                                class="img-fluid h-100 w-100 object-fit-cover" 
                                style="object-fit: cover;">
                        </div>

                        <!-- RIGHT: Form -->
                        <div class="col-md-6 p-4 d-flex align-items-center">
                            <form class="w-100">
                                <div class="mb-3">
                                    <label for="inquiryType" class="form-label">Inquiry Type</label>
                                    <select class="form-select" id="inquiryType" required>
                                        <option selected disabled value="">Choose an option</option>
                                        <option value="booking">Booking</option>
                                        <option value="pricing">Pricing</option>
                                        <option value="services">Resort Services</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Submit Inquiry</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    <!-- EXPLORE SECTION -->
    <section class="py-5">
            <div class="container text-center">
                <h2>EXPLORE YOUR DREAM GETAWAY</h2>
                <p>Find the perfect place to relax...</p>
                <div class="row mt-4">

                    @php
                        $resorts = [
                            ['name' => 'Sogod Bay Scuba Resort', 'email' => 'sogod.scuba@gmail.com', 'image' => 'sogod bay scuba resort.jpg', 'link' => 'resort1'],
                            ['name' => 'Peters Dive Resort', 'email' => 'peters.dive@gmail.com', 'image' => 'peters dive resort.jpg', 'link' => 'resort2'],
                            ['name' => 'Padre Burgos Castle Resort', 'email' => 'padreburgos.castle@gmail.com', 'image' => 'padre burgos castle resort.jpg', 'link' => 'resort3'],
                            ['name' => 'Burgos Reef Boutique Resort', 'email' => 'burgos.reefresort@gmail.com', 'image' => 'burgos reef boutique resort.jpg', 'link' => 'resort4']
                        ];
                    @endphp

                    @foreach ($resorts as $resort)
                        <div class="col-md-3 mb-4">
                            <a href="{{ url('/' . $resort['link']) }}" class="text-decoration-none text-dark">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset('/images/' . $resort['image']) }}" class="card-img-top" alt="{{ $resort['name'] }}">
                                    <div class="card-body">
                                        <div class="text-start">
                                            <h5 class="card-title mb-1">{{ $resort['name'] }}</h5>
                                            <p class="card-text text-muted mb-0">{{ $resort['email'] }}</p>
                                        </div>
                                        <i class="bi bi-info-circle-fill text-dark-blue fs-4 ms-2"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        </div>
    </section>


    <!-- FOOTER -->
    <footer class="footer-darkblue text-white text-center py-3">
        <div class="container">
            <p>&copy; {{ date('Y') }} Resortsphere. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
