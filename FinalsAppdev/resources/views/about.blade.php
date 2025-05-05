<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Resortsphere</title>
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
            background-attachment: fixed;  /* Parallax effect */
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

        .about-section {
            padding: 60px 0;
            background-color: #f7f7f7;
        }

        .about-section .text-dark-blue {
            color: #001f3f;
        }

        .about-logo img {
            height: 150px; /* Adjust the logo size */
            margin-right: 30px; /* Space between logo and content */
        }

        .about-logo {
            display: flex;
            align-items: center;
        }

        .content-section {
            display: flex;
            align-items: center;
        }

        .content-section .text-section {
            flex: 1;
        }

    </style>
</head>
<body>

    <!-- NAVBAR -->
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
                    <li class="nav-item"><a class="nav-link active" href="#">About Us</a></li>
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
                <h1 class="display-3 fw-bold text-white">ABOUT US</h1>
                <p class="lead text-white">Learn more about Resortsphere, our mission, and what we offer.</p>
            </div>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <section class="about-section">
        <div class="container">
            <h2 class="text-center text-dark-blue">Who We Are</h2>
            <p class="text-center text-muted mb-5">At Resortsphere, we are committed to offering exceptional getaway experiences. Our platform connects you with some of the best resorts for a perfect holiday.</p>
            
            <div class="content-section">
                <!-- Logo beside the content -->
                <div class="about-logo">
                    <img src="{{ asset('images/Logo.png') }}" alt="Resortsphere Logo">
                </div>

                <div class="text-section">
                    <h4 class="text-dark-blue">Our Mission</h4>
                    <p class="text-muted">We aim to revolutionize the way people discover and book resorts by providing a seamless platform that simplifies the process and makes it easier to plan your dream vacation.</p>
                    
                    <h4 class="text-dark-blue">What We Offer</h4>
                    <ul class="text-muted">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                        <li>Nullam suscipit turpis non erat tempor, a laoreet nisl aliquet.</li>
                        <li>Quisque maximus risus vel metus convallis, in gravida felis luctus.</li>
                        <li>Curabitur vel felis ac magna scelerisque malesuada.</li>
                    </ul>
                </div>
            </div>

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
