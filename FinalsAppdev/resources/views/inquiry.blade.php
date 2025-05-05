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
        .spinner-border {
            vertical-align: middle;
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
                    <div class="col-md-6 d-none d-md-block">
                        <img src="{{ asset('/images/msgs.jpg') }}" alt="Inquiry Icon" class="img-fluid h-100 w-100 object-fit-cover">
                    </div>
                    <div class="col-md-6 p-4 d-flex align-items-center">
                        <form class="w-100" method="POST" action="{{ route('inquiry.submit') }}" onsubmit="return validateForm()">
                            @csrf
                            <div class="alert-container">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                               <!-- Inquiry Type -->
                            <div class="mb-3">
                                <label for="inquiryType" class="form-label">Inquiry Type</label>
                                <select class="form-select" id="inquiryType" name="inquiryType" required 
                                        onchange="toggleOtherInquiry(this)" 
                                        data-bs-toggle="tooltip" title="Select the category that best describes your concern.">
                                    <option selected disabled value="">Choose an option</option>
                                    <option value="booking">Booking</option>
                                    <option value="pricing">Pricing</option>
                                    <option value="services">Resort Services</option>
                                    <option value="availability">Availability</option>
                                    <option value="amenities">Amenities</option>
                                    <option value="events">Event Hosting</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="otherInquiryDiv">
                                <label for="otherInquiry" class="form-label">Please specify</label>
                                <input type="text" class="form-control" id="otherInquiry" name="otherInquiry" maxlength="100">
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required maxlength="100">
                            </div>

                            <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                                <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                required 
                                maxlength="255" 
                                pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" 
                                title="Only Gmail addresses are allowed (e.g., user@gmail.com)"
                                data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                data-bs-title="Please enter a Gmail address (e.g., yourname@gmail.com)"
                                >
                                <div class="invalid-feedback">
                                Please enter a valid Gmail address (e.g., user@gmail.com).
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required maxlength="1000" oninput="checkMaxLength(this)"></textarea>
                                <div id="messageError" class="invalid-feedback" style="display: none;">
                                    The message cannot exceed 1000 characters.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center align-items-center" id="submitBtn">
                                <span id="btnText">Submit Inquiry</span>
                                <div class="spinner-border spinner-border-sm ms-2 d-none" role="status" id="loadingSpinner"></div>
                            </button>
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
    <script>
        function validateForm() {
            const emailInput = document.getElementById("email");
            const messageInput = document.getElementById("message");
            const submitBtn = document.getElementById("submitBtn");
            const btnText = document.getElementById("btnText");
            const spinner = document.getElementById("loadingSpinner");
            const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

            // Check if email is valid
            if (!emailPattern.test(emailInput.value)) {
                emailInput.classList.add("is-invalid");
                return false;
            } else {
                emailInput.classList.remove("is-invalid");
            }

            // Check if message exceeds character limit
            if (messageInput.value.length > 1000) {
                messageInput.classList.add("is-invalid");
                document.getElementById("messageError").style.display = "block";  // Show error
                return false;  // Prevent form submission
            } else {
                messageInput.classList.remove("is-invalid");
                document.getElementById("messageError").style.display = "none";  // Hide error
            }

            btnText.textContent = "Submitting...";
            spinner.classList.remove("d-none");
            submitBtn.disabled = true;

            return true; 
        }

        // Toggle 'Others' Inquiry input visibility
        function toggleOtherInquiry(select) {
            const otherDiv = document.getElementById('otherInquiryDiv');
            const otherInput = document.getElementById('otherInquiry');
            
            if (select.value === "others") {
                otherDiv.classList.remove("d-none");
                otherInput.required = true;
            } else {
                otherDiv.classList.add("d-none");
                otherInput.required = false;
                otherInput.value = "";
            }
        }

        // Validate Email input with feedback
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');

            if (!emailInput.checkValidity()) {
                emailInput.classList.add('is-invalid');
                emailError.style.display = 'block'; 
            } else {
                emailInput.classList.remove('is-invalid');
                emailError.style.display = 'none'; 
            }
        }

        function checkMaxLength(textarea) {
            const messageError = document.getElementById('messageError');

            if (textarea.value.length > 1000) {
                textarea.classList.add("is-invalid");
                messageError.style.display = "block";  // Show error
            } else {
                textarea.classList.remove("is-invalid");
                messageError.style.display = "none";  // Hide error
            }
        }


        document.querySelector('form').addEventListener('submit', function(e) {
            const emailInput = document.getElementById('email');
            if (!emailInput.checkValidity()) {
                e.preventDefault(); // Prevent form submission if the email is invalid
                validateEmail(); // Ensure the error is displayed
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        document.getElementById('email').addEventListener('input', function () {
            const emailInput = this;
            const pattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

            if (emailInput.value === '' || !pattern.test(emailInput.value)) {
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
            } else {
                emailInput.classList.add('is-valid');
                emailInput.classList.remove('is-invalid');
            }
        });          
    </script>
</body>
</html>
