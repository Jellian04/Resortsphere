<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resort Owner Dashboard</title>

    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            border: none;
            transition: background-color 0.3s;
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
            text-decoration: none;
            display: block;
        }

        .logout-link:hover {
            background-color: #1f3a64;
            color: white;
        }

        /* Dropzone Styling */
        #imageDropzone {
            border: 2px dashed #dee2e6;
            border-radius: 5px;
            background: #f8f9fa;
            min-height: 150px;
            padding: 20px;
            cursor: pointer;
        }

        #imageDropzone .dz-message {
            text-align: center;
            margin: 3em 0;
            font-size: 1.2rem;
        }

        #imageDropzone .dz-preview {
            margin: 0.5rem;
            display: inline-block;
        }

        #imageDropzone .dz-preview .dz-image {
            border-radius: 5px;
            width: 120px;
            height: 120px;
        }

        #imageDropzone .dz-remove {
            color: #dc3545;
            margin-top: 5px;
            font-size: 0.9rem;
        }

        /* Loading spinner */
        #loadingSpinner {
            color: #2A4D86;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        /* Make dropzone message more visible */
        .dz-message i {
            font-size: 3rem;
            color: #2A4D86;
            margin-bottom: 10px;
        }

        .dz-message span.text-primary {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4 px-3">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 80px;">
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

        <a class="logout-link" href="{{ url('/login') }}">
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
            @endif
            
            <div id="form-container" class="form-custom">
                <h5 class="mb-4">Resort Registration</h5>
                @auth

                <form id="resort-registration-form" method="POST" enctype="multipart/form-data" action="{{ route('resort.register') }}">
                    @csrf

                    <div class="row">
                        <!-- Resort Name and Accommodation Type (Stacked) Section -->
                        <div class="col-md-6">
                            <!-- Resort Name Section -->
                            <div class="form-group">
                                <label for="resortname">Resort Name</label>
                                <input type="text" name="name" id="resortname" class="form-control" 
                                    value="{{ old('name') }}" required>
                                <div class="error" id="name-error"></div>
                            </div>

                            <!-- Accommodation Type Section -->
                            <div class="form-group">
                                <label for="type_of_accommodation">Accommodation Type</label>
                                <select name="accommodation_type" id="type_of_accommodation" class="form-control" required>
                                    <option value="" disabled selected>Select accommodation type</option>
                                    <option value="hotel" {{ old('accommodation_type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                    <option value="cottage" {{ old('accommodation_type') == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                    <option value="villa" {{ old('accommodation_type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                    <option value="bungalow" {{ old('accommodation_type') == 'bungalow' ? 'selected' : '' }}>Bungalow</option>
                                    <option value="resort" {{ old('accommodation_type') == 'resort' ? 'selected' : '' }}>Resort</option>
                                    <option value="hostel" {{ old('accommodation_type') == 'hostel' ? 'selected' : '' }}>Hostel</option>
                                    <option value="apartment" {{ old('accommodation_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="other" {{ old('accommodation_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <div class="error" id="accommodation_type-error"></div>
                            </div>

                            <!-- Other Accommodation Section -->
                            <div class="form-group" id="other-accommodation-field" style="display: none;">
                                <label for="other_accommodation">Specify Other Accommodation Type</label>
                                <input type="text" name="other_accommodation" id="other_accommodation" class="form-control">
                                <div class="error" id="other_accommodation-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="resortaddress">Resort Address</label>
                                <input type="text" name="address" id="resortaddress" class="form-control" 
                                    value="{{ old('address') }}" required readonly>
                                <div class="error" id="address-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                                <div class="error" id="description-error"></div>
                            </div>
                        </div>

                        <!-- Map Section (Beside the form) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="map">Select Resort Location</label>
                                <div id="map" style="height: 400px; width: 100%;"></div>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                                <div id="address-output"></div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mt-4">
                        <label for="imageDropzone">Upload Resort Images (minimum 3)</label>
                        <div id="imageDropzone" class="dropzone needsclick">
                            <div class="dz-message needsclick">
                                <i class="bi bi-cloud-arrow-up-fill d-block"></i>
                                <span class="text-primary">Drag and drop images here or click to upload</span>
                                <div class="small text-muted mt-1">JPEG, PNG, GIF only. Max 5MB each. Up to 6 images.</div>
                            </div>
                        </div>
                        <div class="error mt-2" id="images-error"></div>
                    </div>

                    
                    <div class="form-group mt-4">
                        <button type="submit" id="submitButton" class="btn btn-custom w-100">
                            <span id="submitText">Submit Registration</span>
                            <span id="loadingSpinner" style="display: none;">
                                <i class="fa fa-spinner fa-spin"></i> Processing...
                            </span>
                        </button>
                    </div>
                </form>
                @endauth
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script>
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