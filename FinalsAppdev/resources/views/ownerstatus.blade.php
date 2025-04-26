<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resort Owner Dashboard</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
            margin: 0;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #2A4D86;
            color: white;
            position: fixed;
            padding-top: 1.5rem;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar h4 {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .sidebar .nav-link {
            color: #ffffffcc;
            padding: 14px 24px;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #1f3a64;
            color: #fff;
        }

        .navbar-custom {
            background-color: #2A5677;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: white;
            border-radius: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .form-custom {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-custom {
            background-color: #2A4D86;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-custom:hover {
            background-color: #1f3a64;
        }

        .logout-link {
            margin-top: auto;
            color: white;
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 10px;
            font-weight: 700;
            transition: background-color 0.2s ease;
        }

        .logout-link:hover {
            background-color: #1f3a64;
        }

        /* Image preview */
        #image-preview {
            max-width: 200px;
            margin-top: 10px;
        }

        .error {
            color: red;
            font-size: 0.9rem;
        }

        #loadingSpinner {
            display: none;
        }

        input[readonly], select[readonly], textarea[readonly] {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4 px-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 80px;">
        </div>

        <ul class="nav flex-column">
            <li class="nav-item px-3 mb-3">
                <span class="fw-bold d-block text-center">
                    @if(Auth::check())
                    Welcome, {{ Auth::user()->username ?? Auth::user()->name ?? 'User' }}!
                    @else
                        Welcome, Guest!
                    @endif
                </span>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            </li>

            <li class="nav-item">
            <a class="nav-link active" href="{{ url('/ownerstatus') }}"><i class="bi bi-info-circle me-2"></i>Information Status</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/welcome') }}" target="_blank"><i class="bi bi-globe me-2"></i>View Website</a>
            </li>
        </ul>

        <a class="nav-link logout-link mt-auto" href="{{ url('/login') }}">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="navbar-custom shadow-sm flex-column align-items-start py-2">
            <h1 class="fw-bold fs-5 mb-1">Welcome, Resort Owner</h1>
            <p class="mb-0">Registering a resort needs admin approval.</p>
        </div>

        <div class="container mt-4">
            <div id="alert-box">
                @if($status === 'approved')
                    <div class="alert alert-success">Your resort has been approved!</div>
                @elseif($status === 'pending')
                    <div class="alert alert-warning">Your request is still pending.</div>
                @elseif($status === 'rejected')
                    <div class="alert alert-danger">Your request was rejected.</div>
                @else
                    <div id="form-container">
                        @if($alreadyRegistered)
                            <div class="alert alert-warning">
                                You have already submitted your resort registration. Please wait for admin approval.
                            </div>
                        @else
                        <div class="form-custom">
                            <h5 class="mb-4">Resort Owner Information</h5>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <p class="form-control-plaintext">{{ $user->firstname ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <p class="form-control-plaintext">{{ $user->lastname ?? '' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Email</label>
                                    <p class="form-control-plaintext">{{ $user->email ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Username</label>
                                    <p class="form-control-plaintext">{{ $user->username ?? '' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Zipcode</label>
                                    <p class="form-control-plaintext">{{ $user->zipcode ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Resort Name</label>
                                    <p class="form-control-plaintext">{{ $user->resortname ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Resort Address</label>
                                <p class="form-control-plaintext">{{ $user->resorts_address ?? '' }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Password</label>
                                    <p class="form-control-plaintext text-muted">********</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Accommodation Type</label>
                                    <p class="form-control-plaintext text-capitalize">{{ $user->type_of_accommodation ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <p class="form-control-plaintext">{{ $user->description ?? '' }}</p>
                            </div>

                            <div class="form-group">
                                <label>Resort Image</label><br>
                                @if(!empty($user->resort_img))
                                    <img src="{{ asset('storage/' . $user->resort_img) }}" alt="Resort Image" class="img-thumbnail" style="max-width: 300px;">
                                @else
                                    <p class="form-control-plaintext text-muted">No image uploaded</p>
                                @endif
                            </div>
                        </div>

                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    // Show password toggle functionality
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        var toggleIcon = document.getElementById('toggleIcon');
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
        }
    });

    // Preview image before uploading
    document.getElementById("resort_img").addEventListener("change", function(event) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("image-preview").style.display = "block";
            document.getElementById("image-preview").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });

    // Form submit
    document.getElementById("resort-registration-form").onsubmit = function(event) {
        event.preventDefault(); // Prevent default form submission
        var form = this;

        // Show the loading spinner
        document.getElementById("loadingSpinner").style.display = "inline-block";

        // Disable the submit button and inputs after form submission
        document.getElementById("submitButton").disabled = true;
        Array.from(form.elements).forEach(function(input) {
            if (input.type !== "submit") {
                input.setAttribute('readonly', true);
            }
        });

        // Submit the form via AJAX or proceed with normal form submission
        // Here we'll use a setTimeout to simulate the form submission
        setTimeout(function() {
            // Simulate form submission
            form.submit(); // You can replace this with AJAX to handle submission without a page reload.
        }, 2000); // Simulate a 2-second delay for submission (remove if using AJAX)
    };
</script>
</body>
</html>
