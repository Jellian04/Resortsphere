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

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet">
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

        .img-thumbnail {
            border-radius: 10px;
            object-fit: cover;
            width: 60px;
            height: 60px;
        }

        /* Adjusting Search Filter and Table Spacing */
        .dataTables_filter {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .dataTables_filter input {
            margin-left: 10px;
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .dataTables_length {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
        }

        .dataTables_length select {
            margin-left: 10px;
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="text-center mb-4 px-3">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="img-fluid logo-img">
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link " href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            </li>   
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('/adminuser') }}"><i class="bi bi-people me-2"></i>Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/welcome') }}"><i class="bi bi-globe me-2"></i>View Website</a>
            </li>
        </ul>
        <a class="nav-link logout-link" href="{{ url('/login') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>

    <div class="main-content">
        <div class="navbar-custom rounded-bottom">
            <h5 class="mb-0">Welcome Admin</h5>
        </div>

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
                <h4 class="mb-3">Registered Users</h4>
                <div class="table-responsive">
                    <table id="usersTable" class="table table-bordered table-striped table-hover bg-white">
                    <thead class="table-secondary">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Registered Date</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('F d, Y') }}</td>
                                <td>
                                    <button type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-delete-url="{{ route('admin.delete.user', $user->id) }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No users registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                    <span id="deleteBtnText">Delete</span>
                    <span id="deleteBtnSpinner" class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"></span>
                </button>
                </div>
            </form>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search users..."
            }
        });
    });

    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteBtnText = document.getElementById('deleteBtnText');
    const deleteBtnSpinner = document.getElementById('deleteBtnSpinner');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const deleteUrl = button.getAttribute('data-delete-url');
        deleteForm.action = deleteUrl;

        confirmDeleteBtn.disabled = false;
        deleteBtnText.classList.remove('d-none');
        deleteBtnSpinner.classList.add('d-none');
    });

    deleteForm.addEventListener('submit', function () {
        confirmDeleteBtn.disabled = true;
        deleteBtnText.classList.add('d-none');
        deleteBtnSpinner.classList.remove('d-none');
    });
</script>

</body>
</html>
