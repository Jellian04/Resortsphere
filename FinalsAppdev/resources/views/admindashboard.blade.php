<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
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
            height: 60px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            padding: 0 20px;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .logo-img {
            max-height: 85px;
        }

        .list-group-item {
            border-left: 4px solid #2A4D86;
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
            color: white;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        /* Custom Table Styles */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .form-select {
            width: auto;
            max-width: 150px;
        }

        .btn-sm {
            padding: 6px 12px;
        }

        .img-thumbnail {
            border-radius: 10px;
            object-fit: cover;
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4 px-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid logo-img">
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/adminowner') }}"><i class="bi bi-person-badge me-2"></i>Owners</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/adminuser') }}"><i class="bi bi-people me-2"></i>Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/welcome') }}" target="_blank"><i class="bi bi-globe me-2"></i>View Website</a>
            </li>
        </ul>

        <!-- Logout Button -->
        <a class="nav-link logout-link" href="{{ url('/login') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="navbar-custom rounded-bottom">
            <h5 class="mb-0">Welcome Admin</h5>
        </div>

        <!-- Page Content -->
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-custom p-4 bg-white">
                        <h6 class="mb-1 text-muted">Total Resorts</h6>
                        <h3>{{ $totalResorts }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 bg-white">
                        <h6 class="mb-1 text-muted">Total Owners</h6>
                        <h3>{{ $totalOwners }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 bg-white">
                        <h6 class="mb-1 text-muted">Registered Users</h6>
                        <h3>{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4 class="mb-3">Pending Resort Owners</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover bg-white">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Zipcode</th>
                                <th>Resort Name</th>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingOwners as $owner)
                                <tr>
                                    <td>{{ $owner->id }}</td>
                                    <td>{{ $owner->firstname }} {{ $owner->lastname }}</td>
                                    <td>{{ $owner->email }}</td>
                                    <td>{{ $owner->username }}</td>
                                    <td>{{ $owner->zipcode }}</td>
                                    <td>{{ $owner->resortname }}</td>
                                    <td>{{ $owner->type_of_accommodation }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $owner->image) }}" alt="Owner Image" class="img-thumbnail">

                                    <td>
                                        <form action="{{ route('admin.updateStatus', $owner->id) }}" method="POST" class="d-flex">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm me-2">
                                                <option value="pending" {{ $owner->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved">Approved</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No pending owners found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
