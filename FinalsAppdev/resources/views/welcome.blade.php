<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Resortsphere!</title>
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

        .navbar .nav-link {
            color: white !important;
            font-size: 1.25rem;
            margin-right: 50px;
        }

        .navbar .nav-link:last-child {
            margin-right: 0;
        }

        .navbar {
            z-index: 3;
        }

        .footer-darkblue {
            background-color: ##001f3f;
        }

        .footer form .form-control,
        .footer form .form-select {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.3);
            color: white;
        }

        .footer form .form-control::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .footer form .form-control:focus,
        .footer form .form-select:focus {
            background-color: rgba(255,255,255,0.2);
            color: white;
            border-color: #bbdefb;
            box-shadow: 0 0 0 0.25rem rgba(187, 222, 251, 0.25);
        }

        .footer .invalid-feedback {
            color: #ffb3b3;
        }

        .footer .alert {
            margin-bottom: 1rem;
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

        @media (max-width: 768px) {
            .hero {
                background-attachment: scroll; /* Disable parallax on mobile */
            }
        }

        .footer-logo-img {
            width: 250px;  /* Adjust the width as needed */
            height: auto;  /* Maintain aspect ratio */
            display: block;
            margin-left: 0;  /* Align to the left */
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
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href="{{ url('/about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- HERO SECTION WITH TRANSPARENT NAV -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container h-100 d-flex justify-content-center align-items-center hero-content text-center">
            <div>
                <h1 class="display-3 fw-bold">RESORTSPHERE</h1>
                <p class="lead">Neque porro quis dolor sit amet, consectetur, adipisci velit...</p>
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

    <!-- FOOTER -->
    <footer class="footer-darkblue text-white py-4" style="background-color: #001f3f;">
        <div class="container">
            <div class="row">
                <!-- Copyright Info -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="text-start mb-4 px-3">
                        <img src="{{ asset('images/Logo.png') }}" alt="Footer Logo" class="img-fluid footer-logo-img">
                    </div>
                    <p>&copy; {{ date('Y') }} Resortsphere. All rights reserved.</p>
                    
                    <div class="mt-3">
                        <p><i class="fas fa-bolt me-2"></i> Powered by ResortSphere</p>
                    </div>
                </div>

                                
                <!-- Contact Form -->
                <div class="col-md-8">
                    <h5 class="mb-3">Contact Us</h5>
                    <form method="POST" action="{{ route('inquiry.submit') }}" id="inquiryForm">         
                        @csrf    
                        <div class="alert-container mb-3">
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
                        </div>

                        <div class="row g-3">
                            <!-- Inquiry Type -->
                            <div class="col-md-6">
                                <label for="footerInquiryType" class="form-label">Inquiry Type</label>
                                <select class="form-select" id="footerInquiryType" name="inquiryType" required
                                        onchange="toggleFooterOtherInquiry(this)">
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

                            <!-- Conditional Other Inquiry -->
                            <div class="col-md-6 d-none" id="footerOtherInquiryDiv">
                                <label for="footerOtherInquiry" class="form-label">Please specify</label>
                                <input type="text" class="form-control" id="footerOtherInquiry" name="otherInquiry" maxlength="100">
                            </div>

                            <!-- Full Name -->
                            <div class="col-md-6">
                                <label for="footerName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="footerName" name="name" required maxlength="100">
                            </div>

                            <!-- Contact Method -->
                            <div class="col-md-6">
                                <label for="footerContactMethod" class="form-label">Contact Method</label>
                                <select class="form-select" id="footerContactMethod" name="contactMethod" required
                                        onchange="toggleFooterContactField(this)">
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                </select>
                            </div>

                            <!-- Email/Phone Field -->
                            <div class="col-md-6" id="footerEmailDiv">
                                <label for="footerEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="footerEmail" name="email" 
                                    maxlength="255" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                    title="Please enter a valid email address">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <div class="col-md-6 d-none" id="footerPhoneDiv">
                                <label for="footerPhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="footerPhone" name="phone" 
                                    maxlength="20" pattern="^[0-9+\- ]+$"
                                    title="Please enter a valid phone number">
                                <div class="invalid-feedback">
                                    Please enter a valid phone number.
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="col-12">
                                <label for="footerMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="footerMessage" name="message" rows="3" required 
                                        maxlength="1000" oninput="checkFooterMaxLength(this)"></textarea>
                                <div id="footerMessageError" class="invalid-feedback" style="display: none;">
                                    The message cannot exceed 1000 characters.
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center align-items-center" 
                                        id="footerSubmitBtn" style="background-color:rgb(85, 128, 229); border-color:rgb(85, 128, 229);">
                                    <span id="footerBtnText">Send</span>
                                    <div class="spinner-border spinner-border-sm ms-2 d-none" role="status" id="footerLoadingSpinner"></div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Toggle between contact methods (email/phone)
            const contactMethodSelect = document.getElementById('footerContactMethod');
            if (contactMethodSelect) {
                contactMethodSelect.addEventListener('change', function() {
                    const isEmail = this.value === 'email';
                    document.getElementById('footerEmailDiv').classList.toggle('d-none', !isEmail);
                    document.getElementById('footerPhoneDiv').classList.toggle('d-none', isEmail);
                    
                    const emailInput = document.getElementById('footerEmail');
                    const phoneInput = document.getElementById('footerPhone');
                    isEmail ? emailInput.setAttribute('required', '') : emailInput.removeAttribute('required');
                    !isEmail ? phoneInput.setAttribute('required', '') : phoneInput.removeAttribute('required');
                });
            }

            // Toggle other inquiry field
            const inquiryTypeSelect = document.getElementById('footerInquiryType');
            if (inquiryTypeSelect) {
                inquiryTypeSelect.addEventListener('change', function() {
                    const showOther = this.value === 'others';
                    const otherDiv = document.getElementById('footerOtherInquiryDiv');
                    otherDiv.classList.toggle('d-none', !showOther);
                    if (!showOther) document.getElementById('footerOtherInquiry').value = '';
                });
            }

            // Message length validation
            const messageTextarea = document.getElementById('footerMessage');
            if (messageTextarea) {
                messageTextarea.addEventListener('input', function() {
                    const maxLength = parseInt(this.getAttribute('maxlength'));
                    const messageError = document.getElementById('footerMessageError');
                    const exceeded = this.value.length > maxLength;
                    
                    if (exceeded) {
                        this.value = this.value.substring(0, maxLength);
                    }
                    messageError.style.display = exceeded ? 'block' : 'none';
                    this.classList.toggle('is-invalid', exceeded);
                });
            }
        });

        // Form validation
        function validateFooterForm(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = document.getElementById('footerSubmitBtn');
            const btnText = document.getElementById('footerBtnText');
            const spinner = document.getElementById('footerLoadingSpinner');
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Sending...';
            spinner.classList.remove('d-none');
            
            // Reset previous errors
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            
            // Validate contact method
            const contactMethod = document.getElementById('footerContactMethod').value;
            let isValid = true;
            
            if (contactMethod === 'email') {
                const email = document.getElementById('footerEmail');
                const emailPattern = new RegExp(email.getAttribute('pattern'));
                if (!emailPattern.test(email.value)) {
                    email.classList.add('is-invalid');
                    isValid = false;
                }
            } else {
                const phone = document.getElementById('footerPhone');
                const phonePattern = new RegExp(phone.getAttribute('pattern'));
                if (!phonePattern.test(phone.value)) {
                    phone.classList.add('is-invalid');
                    isValid = false;
                }
            }
            
            // Validate message length
            const message = document.getElementById('footerMessage');
            if (message.value.length > 1000) {
                document.getElementById('footerMessageError').style.display = 'block';
                message.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                submitBtn.disabled = false;
                btnText.textContent = 'Submit Inquiry';
                spinner.classList.add('d-none');
                return false;
            }
            
            // If valid, submit the form programmatically
            setTimeout(() => {
                form.submit();
            }, 500);
            
            return true;
            }

            document.getElementById('inquiryForm').addEventListener('submit', function(e) {
                if (!validateFooterForm(e)) {
                    e.preventDefault();
                }
            });
    </script>
</body>
</html>
