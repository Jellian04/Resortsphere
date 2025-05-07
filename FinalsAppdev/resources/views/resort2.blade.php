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
            background-image: url('{{ asset('images/peters dive resort.jpg') }}');
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
            overflow: hidden;
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
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ url('/login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container h-100 d-flex justify-content-center align-items-center hero-content text-center">
            <div>
                <h1 class="display-3 fw-bold">PETERS DIVE RESORT</h1>
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
                        'title' => 'Swimming Pool',
                        'image' => 'images/r2 swimming pool.jpg',
                        'desc' => 'Take a refreshing dip in our crystal-clear pool overlooking the beach.',
                        'price' => '₱150 – ₱300 (Day Use)',
                        'rating' => 4,
                        'checkin' => '8:00 AM',
                        'checkout' => '9:00 PM',
                        'amenities' => ['Lounge Chairs', 'Pool Bar', 'Lifeguard on Duty', 'Kids Pool Area'],
                        'more' => 'Open daily. Towels and lockers available for rent. Pool bar serves snacks and drinks.',
                    ],
                    [
                        'title' => 'Standard Room',
                        'image' => 'images/r2 bedroom.jpg',
                        'desc' => 'Cozy air-conditioned room with essential amenities and garden or sea view.',
                        'price' => '₱2,000 – ₱3,000 per night',
                        'rating' => 4,
                        'checkin' => '2:00 PM',
                        'checkout' => '11:00 AM',
                        'amenities' => ['Air Conditioning', 'Double Bed', 'Private Bathroom', 'Free Wi-Fi'],
                        'more' => 'Ideal for couples or solo travelers. Includes complimentary bottled water and toiletries.',
                    ],
                    [
                        'title' => 'Scuba Diving',
                        'image' => 'images/r2 scuba diving.jpg',
                        'desc' => 'Dive into clear waters and explore rich coral reefs with our expert divers.',
                        'price' => '₱1,500 – ₱2,500 per session',
                        'rating' => 5,
                        'checkin' => 'Session starts: 9:00 AM / 2:00 PM',
                        'checkout' => 'Session ends: 11:30 AM / 4:30 PM',
                        'amenities' => ['Dive Equipment', 'Certified Instructors', 'Boat Transfers'],
                        'more' => 'Includes safety orientation and full gear. Ideal for beginners and experienced divers.',
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
        window.addEventListener('scroll', function() {
            const homeButton = document.querySelector('.home-btn');
            const scrollPosition = window.scrollY; 
            const parallaxEffect = scrollPosition * 0.5; 
            homeButton.style.transform = `translateY(${parallaxEffect}px)`;
        });
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