<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .privacy-toggle {
            cursor: pointer;
        }

        .book-card {
            transition: transform 0.3s ease;
        }

        .book-card:hover {
            transform: scale(1.05);
        }

        .gpa-progress {
            height: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="bi bi-person me-2"></i> My Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="bi bi-book me-2"></i> Courses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="bi bi-journal-text me-2"></i> Academic Records
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Profile Header -->
                <div class="profile-header text-center mb-4">
                    <div class="container">
                        <!-- <input type="file" id="profilePictureUpload" class="d-none" accept="image/*">
                        <label for="profilePictureUpload">
                            <img src="/api/placeholder/150/150" class="rounded-circle profile-picture mb-3"
                                alt="Profile Picture">
                            <div class="text-white">
                                <small><i class="bi bi-pencil me-2"></i>Edit Picture</small>
                            </div>
                        </label> -->
                        <h2 class="mb-1">Emily Johnson</h2>
                        <p class="mb-0">Student ID: 2023-45678</p>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="container">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Personal Information</h5>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editProfileModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Full Name:</strong> Emily Johnson</p>
                                    <p class="mb-2"><strong>Email:</strong> emily.johnson@university.edu</p>
                                    <p class="mb-2"><strong>Phone:</strong> +1 (555) 123-4567</p>
                                    <hr>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="emailVisibility">
                                        <label class="form-check-label" for="emailVisibility">
                                            Show Email Publicly
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Overview -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Academic Performance</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>Current GPA:</strong>
                                        <span>3.75</span>
                                    </div>
                                    <div class="progress gpa-progress mb-2">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%;"
                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="4.0">
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-2">
                                        Consistently performing above average
                                    </p>
                                    <hr>
                                    <h6>Enrolled Courses</h6>
                                    <ul class="list-unstyled">
                                        <li>• Computer Science 301</li>
                                        <li>• Mathematics 225</li>
                                        <li>• English Literature 210</li>
                                        <li>• Physics 202</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Books for Exchange -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Books for Exchange</h5>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#addBookModal">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="card book-card">
                                                <div class="card-body text-center p-2">
                                                    <img src="/api/placeholder/100/150" alt="Book"
                                                        class="img-fluid mb-2">
                                                    <p class="mb-0 small">Calculus Textbook</p>
                                                    <span class="badge bg-success">Available</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card book-card">
                                                <div class="card-body text-center p-2">
                                                    <img src="/api/placeholder/100/150" alt="Book"
                                                        class="img-fluid mb-2">
                                                    <p class="mb-0 small">Physics Reference</p>
                                                    <span class="badge bg-warning">Pending</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" value="Emily Johnson">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="emily.johnson@university.edu">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" value="+1 (555) 123-4567">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Privacy Settings</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showEmail">
                                <label class="form-check-label" for="showEmail">
                                    Show email address publicly
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showPhone">
                                <label class="form-check-label" for="showPhone">
                                    Show phone number publicly
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Book for Exchange</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Book Title</label>
                            <input type="text" class="form-control" placeholder="Enter book title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Book Condition</label>
                            <select class="form-select">
                                <option>Like New</option>
                                <option selected>Good</option>
                                <option>Acceptable</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Book Image</label>
                            <input type="file" class="form-control" accept="image/*">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="willExchange">
                            <label class="form-check-label" for="willExchange">
                                Willing to exchange/sell
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Book</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>