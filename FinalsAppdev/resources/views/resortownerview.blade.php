<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resort Owner Dashboard</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css" rel="stylesheet">
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

        .bg-custom-blue {
            background-color:rgb(0, 35, 91); /* Your requested blue color */
        }

        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title,
        .card-body p {
            color: #FFFFFF; /* White text for contrast */
        }

        .btn-light {
            background-color: #FFFFFF;
            color: #2A4D86;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-light:hover {
            background-color: #e1e1e1;
            transform: scale(1.05);
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-label {
            color: #333;
        }

        .modal-header {
            background-color: #2A4D86;
        }
        .modal-dialog {
            max-height: 90vh;
        }
        .modal-body {
            overflow-y: auto;
        }
        .toggle-desc {
        background: none;
        border: none;
        font-weight: bold;
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
                <a class="nav-link " href="{{ url('/resortowner') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="{{ url('/resortownerview') }}">
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
        <div class="container my-5">
        <h3 class="text-center mb-4">My Resorts</h3>
        <div class="row">
            <!-- Approved Resorts Section -->
        <div class="col-md-6 mb-4">
            <h4 class="text-dark mb-3">Approved Resorts</h4>
            @if($approvedResorts->isNotEmpty())
                <div class="row">
                    @foreach($approvedResorts as $resort)
                        <div class="col-md-12 mb-4">
                            <div class="card shadow-lg rounded-4 border-0 bg-custom-blue">
                                <div class="card-body">
                                    <h5 class="card-title text-light">{{ $resort->resortname }}</h5>
                                    <p class="text-light"><strong>Address:</strong> {{ $resort->resorts_address }}</p>
                                    <p class="text-light"><strong>Zipcode:</strong> {{ $resort->zipcode }}</p>
                                    <p class="text-light"><strong>Accommodation:</strong> {{ $resort->type_of_accommodation }}</p>
                                    <p class="text-light"><strong>Description:</strong>
                                        <span class="short-desc">{{ Str::limit($resort->description, 100) }}</span>
                                        <span class="full-desc d-none">{{ $resort->description }}</span>
                                        <button class="btn btn-sm btn-link text-light toggle-desc p-0">Read more</button>
                                    </p> 
                                    <button class="btn btn-light shadow-sm px-4 py-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            onclick="fillEditForm(this)"
                                            data-id="{{ $resort->id }}"
                                            data-name="{{ $resort->resortname }}"
                                            data-address="{{ $resort->resorts_address }}"
                                            data-zipcode="{{ $resort->zipcode }}"
                                            data-description="{{ $resort->description }}"
                                            data-accomodation="{{ $resort->type_of_accomodation }}">
                                        Edit
                                    </button>  
                                                                   
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No approved resorts found.</p>
            @endif
        </div>

        <!-- Pending Resorts Section -->
        <div class="col-md-6 mb-4">
            <h4 class="text-dark mb-3">Pending Resorts</h4>
            @if($pendingResorts->isNotEmpty())
                <div class="row">
                    @foreach($pendingResorts as $resort)
                        <div class="col-md-12 mb-4">
                            <div class="card shadow-lg rounded-4 border-0 bg-custom-blue">
                                <div class="card-body">
                                    <h5 class="card-title text-light">{{ $resort->resortname }}</h5>
                                    <p class="text-light"><strong>Address:</strong> {{ $resort->resorts_address }}</p>
                                    <p class="text-light"><strong>Zipcode:</strong> {{ $resort->zipcode }}</p>
                                    <p class="text-light"><strong>Accommodation:</strong> {{ $resort->type_of_accommodation }}</p>
                                    <p class="text-light"><strong>Description:</strong>
                                        <span class="short-desc">{{ Str::limit($resort->description, 100) }}</span>
                                        <span class="full-desc d-none">{{ $resort->description }}</span>
                                        <button class="btn btn-sm btn-link text-light toggle-desc p-0">Read more</button>
                                    </p>
                                    <button class="btn btn-light shadow-sm px-4 py-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            onclick="fillEditForm(this)"
                                            data-id="{{ $resort->id }}"
                                            data-name="{{ $resort->resortname }}"
                                            data-address="{{ $resort->resorts_address }}"
                                            data-zipcode="{{ $resort->zipcode }}"
                                            data-description="{{ $resort->description }}"
                                            data-accomodation="{{ $resort->type_of_accomodation }}">
                                        Edit
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No pending resorts found.</p>
            @endif
        </div>
    </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editModalLabel">Edit Resort Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="editForm" method="POST" class="mx-auto px-3" style="max-width: 700px;">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="resortname" class="form-label fw-semibold">Resort Name</label>
                                <input type="text" class="form-control shadow-sm rounded-3" id="resortname" name="resortname" required>
                            </div>

                            <div class="mb-3">
                                <label for="resorts_address" class="form-label fw-semibold">Address</label>
                                <input type="text" class="form-control shadow-sm rounded-3" id="resorts_address" name="resorts_address" required>
                            </div>

                            <div class="mb-3">
                                <label for="zipcode" class="form-label fw-semibold">Zipcode</label>
                                <input type="text" class="form-control shadow-sm rounded-3" id="zipcode" name="zipcode">
                            </div>

                            <div class="mb-3">
                                <label for="accomodation" class="form-label fw-semibold">Accommodation Type</label>
                                <select name="accomodation" id="accomodation" class="form-control form-control-sm shadow-sm rounded-3" required>
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

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control shadow-sm rounded-3" id="description" name="description" rows="3"></textarea>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm me-2">Save Changes</button>
                                <button type="button" class="btn btn-outline-secondary px-4 py-2 shadow-sm" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editModal = document.getElementById('editModal');

            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;

                    var resortId = button.getAttribute('data-id');
                    var resortName = button.getAttribute('data-name') || '';
                    var resortAddress = button.getAttribute('data-address') || '';
                    var zipCode = button.getAttribute('data-zipcode') || '';
                    var description = button.getAttribute('data-description') || '';
                    var accommodation = button.getAttribute('data-accomodation') || '';

                    var form = document.getElementById('editForm');
                    form.action = `/resorts/${resortId}`; // Adjust this URL as needed

                    form.querySelector('#resortname').value = resortName;
                    form.querySelector('#resorts_address').value = resortAddress;
                    form.querySelector('#zipcode').value = zipCode;
                    form.querySelector('#description').value = description;
                    form.querySelector('#accomodation').value = accommodation;
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-desc').forEach(button => {
            button.addEventListener('click', function () {
                const cardBody = this.closest('p');
                const shortDesc = cardBody.querySelector('.short-desc');
                const fullDesc = cardBody.querySelector('.full-desc');

                const isExpanded = !fullDesc.classList.contains('d-none');

                if (isExpanded) {
                    fullDesc.classList.add('d-none');
                    shortDesc.classList.remove('d-none');
                    this.textContent = 'Read more';
                } else {
                    fullDesc.classList.remove('d-none');
                    shortDesc.classList.add('d-none');
                    this.textContent = 'Show less';
                }
            });
        });
        });
    </script>
</body>
</html>
