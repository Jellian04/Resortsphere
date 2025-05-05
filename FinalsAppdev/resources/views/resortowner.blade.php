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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
            #myDropzone {
                min-height: 200px;
                border: 2px dashed #ccc;  /* Add a border to visualize the Dropzone area */
                background-color: #f9f9f9;
                padding: 20px;
            }
        </style>
</head>
<body>
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="text-center mb-4 px-3">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="img-fluid logo-img">
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
                    <a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/resortownerview') }}">
                        <i class="bi bi-building me-2"></i>My Resorts
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/welcome') }}"><i class="bi bi-globe me-2"></i>View Website</a>
                </li>
            </ul>

            <a class="nav-link logout-link mt-auto" href="{{ url('/login') }}">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="navbar-custom shadow-sm flex-column align-items-start py-2 mb-3">
                <h1 class="fw-bold fs-5 mb-1">Welcome, Resort Owner</h1>
                <p class="mb-0">Registering a resort needs admin approval. You can submit multiple resort registrations. Previous entries will still be processed.</p>
            </div>

            <div id="alert-box">
                @if(isset($statusMessage))
                    <div class="alert alert-info p-3">
                        {{ $statusMessage }}
                    </div>
                    <div id="form-container">
                        <div class="form-custom">
                            <h5 class="mb-4">Resort Owner Registration</h5>
                            <form id="resort-registration-form" method="POST" enctype="multipart/form-data" action="{{ route('resort.register') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control"  
                                            value="{{ old('firstname', Auth::user()->firstname ?? '') }}" required>
                                        <div class="error" id="firstname-error"></div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" 
                                        value="{{ old('lastname', Auth::user()->lastname ?? '') }}" 
                                        required>
                                        <div class="error" id="lastname-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" 
                                        value="{{ old('email', Auth::user()->email ?? '') }}" 
                                        required>
                                        <div class="error" id="email-error"></div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" class="form-control" 
                                        value="{{ old('username', Auth::user()->username ?? '') }}" required>
                                        <div class="error" id="username-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="zipcode">Zipcode</label>
                                        <input type="text" name="zipcode" id="zipcode" class="form-control"  
                                        value="{{ old('zipcode', Auth::user()->zipcode ?? '') }}" 
                                        required>
                                        <div class="error" id="zipcode-error"></div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="resortname">Resort Name</label>
                                        <input type="text" name="resortname" id="resortname" class="form-control" 
                                        value="{{ old('resortname', Auth::user()->resortname ?? '') }}" 
                                        required>
                                        <div class="error" id="resortname-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="resort_name">Resort Address</label>
                                        <input type="text" name="resorts_address" id="resorts_address" class="form-control" 
                                        value="{{ old('resorts_address', Auth::user()->resorts_address ?? '') }}" 
                                        required>
                                        <div class="error" id="resorts_address-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" class="form-control" minlength="6">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="type_of_accommodation">Accommodation Type</label>
                                        <select name="type_of_accommodation" id="type_of_accommodation" class="form-control" 
                                        value="{{ old('type_of_accommodation', Auth::user()->type_of_accommodation ?? '') }}" 
                                        required>
                                            <option value="" disabled selected>Select accommodation type</option>
                                            <option value="hotel">Hotel</option>
                                            <option value="cottage">Cottage</option>
                                            <option value="villa">Villa</option>
                                            <option value="bungalow">Bungalow</option>
                                            <option value="resort">Resort</option>
                                            <option value="hostel">Hostel</option>
                                            <option value="apartment">Apartment</option>
                                            <option value="guesthouse">Guesthouse</option>
                                            <option value="loft">Loft</option>
                                            <option value="farmhouse">Farmhouse</option>
                                            <option value="mansion">Mansion</option>
                                            <option value="AirBnB">AirBnB</option>
                                            <option value="penthouse">Penthouse</option>
                                        </select>
                                        <div class="error" id="type_of_accommodation-error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" 
                                    required>{{ old('description', Auth::user()->description ?? '') }}</textarea>
                                    <div class="error" id="description-error"></div>
                                </div>

                                <div id="loadingSpinner" style="display:none;">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </form>

                            <div class="container mt-5">
                                <form action="{{ route('upload.route') }}" class="dropzone" id="myDropzone">
                                    @csrf
                                </form>
                            </div>

                            <div class="mt-3">
                            <button type="button" id="submitButton" class="btn btn-custom w-100">Submit Registration</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#submitButton').click(function () {
                    var form = $('#resort-registration-form');

                    if (form[0].checkValidity()) {
                        $('#loadingSpinner').show();

                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: new FormData(form[0]),
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                $('#loadingSpinner').hide();
                                alert('Registration successful sent waiting for approval!');
                            },
                            error: function (xhr, status, error) {
                                $('#loadingSpinner').hide();
                                alert('An error occurred. Please try again.');
                            }
                        });
                    } else {
                        alert('Please fill in all required fields.');
                    }
                });
            });
        </script>
</body>
</html
