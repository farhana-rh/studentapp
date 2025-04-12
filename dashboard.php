<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .course-card {
            transition: transform 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Student Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Grades</a></li>
                </ul>
                <div class="ms-auto">
                    <span class="navbar-text text-white me-3">
                        <i class="fas fa-user-circle me-1"></i> John Doe
                    </span>
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Courses</h2>
            <div>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search courses..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4" id="courseContainer">
            <?php
            session_start();
            include('database.php');
            $user_id = $_SESSION["user"]["id"];
            $sqlSelect = "SELECT * FROM courses WHERE user_id = $user_id";
            $result = mysqli_query($conn, $sqlSelect);
            while($data = mysqli_fetch_array($result)) {
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="card course-card h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $data['id'] ?></h5>
                        <span class="badge bg-primary"><?php echo $data['credit_hours'] ?></span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $data['course_name'] ?></h5>
                        <div class="card-text">
                            <div class="mt-3">
                                <strong><i class="fas fa-chalkboard-teacher me-2"></i>Instructor:</strong>
                                <p class="mb-1"><?php echo $data['instructor_name'] ?></p>
                                <p class="text-muted"><small><?php echo $data['instructor_email'] ?></small></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <div class="btn-group w-100">
                            <button type="button" class="btn btn-outline-primary edit-btn"
                                data-id="<?php echo $data['id'] ?>"
                                data-name="<?php echo htmlspecialchars($data['course_name']) ?>"
                                data-code="<?php echo htmlspecialchars($data['course_code']) ?>"
                                data-hours="<?php echo $data['credit_hours'] ?>"
                                data-instructor="<?php echo htmlspecialchars($data['instructor_name']) ?>"
                                data-email="<?php echo htmlspecialchars($data['instructor_email']) ?>"
                                data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <button class="btn btn-primary btn-lg rounded-circle btn-floating shadow" data-bs-toggle="modal"
            data-bs-target="#addCourseModal">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="process.php" method="post">
                        <div class="mb-3">
                            <label for="courseName" class="form-label">Course Name</label>
                            <input type="text" name="course_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="courseCode" class="form-label">Course Code</label>
                            <input type="text" name="course_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="creditHours" class="form-label">Credit Hours</label>
                            <input type="number" name="credit_hours" class="form-control" min="1" max="6" required>
                        </div>
                        <div class="mb-3">
                            <label for="instructorName" class="form-label">Instructor Name</label>
                            <input type="text" name="instructor_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="instructorEmail" class="form-label">Instructor Email</label>
                            <input type="email" name="instructor_email" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="create" class="btn btn-primary">Save Course</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="process.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editCourseId">
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" name="course_name" id="editCourseName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Code</label>
                        <input type="text" name="course_code" id="editCourseCode" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Credit Hours</label>
                        <input type="number" name="credit_hours" id="editCreditHours" class="form-control" min="1" max="6" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instructor Name</label>
                        <input type="text" name="instructor_name" id="editInstructorName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instructor Email</label>
                        <input type="email" name="instructor_email" id="editInstructorEmail" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('editCourseId').value = btn.dataset.id;
                document.getElementById('editCourseName').value = btn.dataset.name;
                document.getElementById('editCourseCode').value = btn.dataset.code;
                document.getElementById('editCreditHours').value = btn.dataset.hours;
                document.getElementById('editInstructorName').value = btn.dataset.instructor;
                document.getElementById('editInstructorEmail').value = btn.dataset.email;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>