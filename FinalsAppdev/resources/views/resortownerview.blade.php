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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

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
                @if($resortsByStatus->has('approve'))
                <div class="col-md-12 mb-4">
                    <h4 class="text-dark mb-3">Approved Resorts</h4>
                    <div class="row">
                        @foreach($resortsByStatus->get('approve') as $resort)
                            <div class="col-md-12 mb-4">
                                <div class="card shadow-lg rounded-4 border-0 bg-custom-blue">
                                    <div class="card-body">
                                        <h5 class="card-title text-light">{{ $resort->resort_name }}</h5>
                                        <p class="text-light"><strong>Address:</strong> {{ $resort->resort_address }}</p>
                                        <p class="text-light"><strong>Accommodation:</strong> {{ $resort->accommodation_type }}</p>
                                        <p class="text-light"><strong>Status:</strong> Approved</p>
                                        
                                        <!-- Display Description -->
                                        <p class="text-light"><strong>Description:</strong> {{ $resort->description }}</p>
                                        
                                        <!-- Display multiple images -->
                                    <div class="image-gallery">
                                        @foreach($resort->resortImages as $image)
                                            <img src="{{ asset('storage/resort_images/' . $image->image) }}" alt="Resort Image" class="img-fluid mb-3">
                                        @endforeach
                                    </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-light mt-2 edit-btn"
                                        data-id="{{ $resort->id }}"
                                        data-name="{{ $resort->resort_name }}"
                                        data-address="{{ $resort->resort_address }}"
                                        data-accommodation="{{ $resort->accommodation_type }}"
                                        data-description="{{ $resort->description }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Pending Resorts Section -->
                @if($resortsByStatus->has('pending'))
                    <div class="col-md-12 mb-4">
                        <h4 class="text-dark mb-3">Pending Resorts</h4>
                        <div class="row">
                            @foreach($resortsByStatus->get('pending') as $resort)
                                <div class="col-md-12 mb-4">
                                    <div class="card shadow-lg rounded-4 border-0 bg-custom-blue">
                                        <div class="card-body">
                                            <h5 class="card-title text-light">{{ $resort->resort_name }}</h5>
                                            <p class="text-light"><strong>Address:</strong> {{ $resort->resort_address }}</p>
                                            <p class="text-light"><strong>Accommodation:</strong> {{ $resort->accommodation_type }}</p>
                                            <p class="text-light"><strong>Status:</strong> Pending</p>

                                            <!-- Display Description -->
                                            <p class="text-light"><strong>Description:</strong> {{ $resort->description }}</p>

                                            <!-- Display Resort Image -->
                                            @php
                                                $resortImage = \App\Models\ResortImage::where('resort_id', $resort->id)->first(); 
                                            @endphp
                                            @if($resortImage)
                                                <img src="{{ asset('storage/images/' . $resortImage->image) }}" alt="Resort Image" class="img-fluid">
                                            @else
                                                <p>No image available</p>
                                            @endif
                                        </div>
                                        <button class="btn btn-light mt-2 edit-btn"
                                            data-id="{{ $resort->id }}"
                                            data-name="{{ $resort->resort_name }}"
                                            data-address="{{ $resort->resort_address }}"
                                            data-accommodation="{{ $resort->accommodation_type }}"
                                            data-description="{{ $resort->description }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Rejected Resorts Section -->
                @if($resortsByStatus->has('reject'))
                    <div class="col-md-12 mb-4">
                        <h4 class="text-dark mb-3">Rejected Resorts</h4>
                        <div class="row">
                            @foreach($resortsByStatus->get('reject') as $resort)
                                <div class="col-md-12 mb-4">
                                    <div class="card shadow-lg rounded-4 border-0 bg-custom-blue">
                                        <div class="card-body">
                                            <h5 class="card-title text-light">{{ $resort->resort_name }}</h5>
                                            <p class="text-light"><strong>Address:</strong> {{ $resort->resort_address }}</p>
                                            <p class="text-light"><strong>Accommodation:</strong> {{ $resort->accommodation_type }}</p>
                                            <p class="text-light"><strong>Status:</strong> Rejected</p>

                                            <!-- Display Description -->
                                            <p class="text-light"><strong>Description:</strong> {{ $resort->description }}</p>

                                            <!-- Display Resort Image -->
                                            @php
                                                $resortImage = \App\Models\ResortImage::where('resort_id', $resort->id)->first(); 
                                            @endphp
                                            @if($resortImage)
                                                <img src="{{ asset('storage/images/' . $resortImage->image) }}" alt="Resort Image" class="img-fluid">
                                            @else
                                                <p>No image available</p>
                                            @endif
                                        </div>
                                        <button class="btn btn-light mt-2 edit-btn"
                                            data-id="{{ $resort->id }}"
                                            data-name="{{ $resort->resort_name }}"
                                            data-address="{{ $resort->resort_address }}"
                                            data-accommodation="{{ $resort->accommodation_type }}"
                                            data-description="{{ $resort->description }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Edit Resort Modal -->
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
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="resort_id" id="editResortId">

                    <div class="row">
                        <!-- Resort Name -->
                        <div class="col-md-6 mb-3">
                            <label for="resortname" class="form-label">Resort Name</label>
                            <input type="text" class="form-control" id="resortname" name="name" required>
                            <div class="error" id="name-error"></div>
                        </div>

                        <!-- Accommodation Type -->
                        <div class="col-md-6 mb-3">
                            <label for="type_of_accommodation" class="form-label">Accommodation Type</label>
                            <select class="form-control" id="type_of_accommodation" name="accommodation_type" required>
                                <option value="Room">Room</option>
                                <option value="Cottage">Cottage</option>
                                <option value="Scuba Diving">Scuba Diving</option>
                                <option value="Restaurant">Restaurant</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                        <!-- Resort Address -->
                        <div class="col-md-12 mb-3">
                            <label for="resortaddress" class="form-label">Resort Address</label>
                            <input type="text" class="form-control" id="resortaddress" name="address" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <!-- Dropzone Upload -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Upload Images</label>
                            <div class="dropzone" id="editDropzone"></div>
                            <small class="text-muted">You can drag and drop or click to upload.</small>
                        </div>

                        <!-- Map Picker -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Map Location</label>
                            <div id="map" style="height: 300px;"></div>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editForm" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const address = this.dataset.address;
                    const accommodation = this.dataset.accommodation;
                    const description = this.dataset.description;

                    document.getElementById('editResortId').value = id;
                    document.getElementById('resortname').value = name;
                    document.getElementById('resortaddress').value = address;
                    document.getElementById('type_of_accommodation').value = accommodation;
                    document.getElementById('description').value = description;
                });
            });
        });

         Dropzone.autoDiscover = false;

        const maxFiles = 6;

        const myDropzone = new Dropzone("#imageDropzone", {
            url: "#", // no actual upload for now
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: maxFiles,
            maxFiles: maxFiles,
            maxFilesize: 5, // MB
            acceptedFiles: "image/jpeg,image/jpg,image/png,image/gif,image/webp",
            addRemoveLinks: true,
            paramName: "images",
            dictDefaultMessage: "Drop images here or click to upload",
            dictRemoveFile: "Remove",
            previewsContainer: "#imageDropzone",
            init: function () {
                this.on("addedfile", function (file) {
                    if (this.files.length > maxFiles) {
                        this.removeFile(file);
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Limit Reached',
                            text: `You can only upload up to ${maxFiles} images.`,
                        });
                    }
                });

                this.on("maxfilesexceeded", function(file) {
                    this.removeFile(file);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Too many files',
                        text: `You can only upload up to ${maxFiles} images.`,
                    });
                });
            }
        });

        document.getElementById('submitButton').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('resort-registration-form');
            const formData = new FormData(form);

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            if (myDropzone.getAcceptedFiles().length < 3) {
                $('#images-error').text('Please upload at least 3 images');
                return false;
            }

            myDropzone.getAcceptedFiles().forEach((file, index) => {
                formData.append(`images[${index}]`, file);
            });

            $('#submitText').hide();
            $('#loadingSpinner').show();
            this.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Resort registration successfully sent for admin approval!',
                        confirmButtonText: 'Okay'
                    }).then(() => {
                        window.location.href = data.redirect || '/resortownerview';
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Handle validation errors
                if (error.errors) {
                    for (const [field, messages] of Object.entries(error.errors)) {
                        const errorEl = document.getElementById(`${field}-error`);
                        if (errorEl) errorEl.textContent = messages[0];
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'An error occurred. Please try again.'
                    });
                }
            })
            .finally(() => {
                $('#submitText').show();
                $('#loadingSpinner').hide();
                document.getElementById('submitButton').disabled = false;
            });
        });
        
        var map;
        var marker;
        function initMap() {
                var defaultLat = 10.3117;  
                var defaultLng = 123.4578; 

                map = L.map('map').setView([defaultLat, defaultLng], 12);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

                map.on('click', function(e) {
                    var lat = e.latlng.lat;
                    var lng = e.latlng.lng;
                    marker.setLatLng([lat, lng]);
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;

                    getAddress(lat, lng);
                });
        }

            function getAddress(lat, lng) {
                var apiUrl = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&addressdetails=1`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('resortaddress').value = data.display_name; 
                        } else {
                            document.getElementById('resortaddress').value = 'No address found.';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('resortaddress').value = 'Unable to retrieve address.';
                    });
            }

            window.onload = initMap;
            document.getElementById('type_of_accommodation').addEventListener('change', function () {
                var otherField = document.getElementById('other-accommodation-field');
                var accommodationType = this.value;

                if (accommodationType === 'other') {
                    otherField.style.display = 'block';  
                } else {
                    otherField.style.display = 'none';  
                }
            });

            document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('type_of_accommodation');
            const otherField = document.getElementById('other-accommodation-field');
            const otherInput = document.getElementById('other_accommodation');
            const form = select.closest('form');

            // Show/hide the "other" input
            select.addEventListener('change', function () {
                if (this.value === 'other') {
                    otherField.style.display = 'block';
                } else {
                    otherField.style.display = 'none';
                    otherInput.value = '';
                }
            });

            // Override select value with custom input if "other" is chosen
            form.addEventListener('submit', function () {
                if (select.value === 'other' && otherInput.value.trim() !== '') {
                    const customValue = otherInput.value.trim();

                    // Create a hidden input to replace the select value
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'accommodation_type';
                    hiddenInput.value = customValue;
                    form.appendChild(hiddenInput);

                    // Disable the original select so it doesn't override
                    select.disabled = true;
                }
            });
        });
    </script>
</body>
</html>
