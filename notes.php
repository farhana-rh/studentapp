<?php
    session_start();
   include('database.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notes Management</title>
    <style>
        .note-card {
            transition: all 0.3s ease;
            height: 100%;
        }

        .note-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .note-preview {
            height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }

        .note-date {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .btn-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
        }

        .course-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-right: 15px;
            font-weight: bold;
            color: white;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">StudyNotes</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo "dashboard.php" ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Courses</a>
                        </li>
                    </ul>
                    <div class="ms-auto d-flex align-items-center">
                        <div class="input-group me-3">
                            <input type="text" class="form-control" placeholder="Search notes...">
                            <button class="btn btn-light" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> John Doe
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                
                <div class="col-lg-3 col-md-4 p-0">
                    <div class="sidebar bg-light p-3">
                        <h5 class="mb-3">My Courses</h5>
                        <?php
                   
                         
                        $user_id = $_SESSION["user"]["id"];
                        $sqlSelect = "SELECT * FROM courses WHERE user_id = $user_id";
                        //  $sqlSelect = "SELECT * FROM courses";
                        $result = mysqli_query($conn, $sqlSelect);
                        while($course = mysqli_fetch_array($result)) {
                        ?> 
                        <div class="list-group mb-4">
                            <a href="#" class="list-group-item list-group-item-action active d-flex align-items-center">
                                <div>
                                    <div class="small"><?php echo htmlspecialchars($course['course_name']); ?>
                                </div>
                                </div>
                            </a>  
                        </div>
                        <?php } ?>
                        <h5 class="mb-3">Categories</h5>
                        <div class="list-group mb-4">
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-book-open me-2"></i>Lectures</span>
                                <span class="badge bg-primary rounded-pill">6</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-tasks me-2"></i>Assignments</span>
                                <span class="badge bg-primary rounded-pill">3</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-clipboard-list me-2"></i>Topics</span>
                                <span class="badge bg-primary rounded-pill">8</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-lightbulb me-2"></i>Exam Prep</span>
                                <span class="badge bg-primary rounded-pill">4</span>
                            </a>
                        </div>

                        
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 col-md-8 py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3>CS101 Notes</h3>
                            <p class="text-muted">Introduction to Computer Science</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Notes</a></li>
                                <li><a class="dropdown-item" href="#">Recent First</a></li>
                                <li><a class="dropdown-item" href="#">Oldest First</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Lectures Only</a></li>
                                <li><a class="dropdown-item" href="#">Assignments Only</a></li>
                                <li><a class="dropdown-item" href="#">Topics Only</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Note Card 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card note-card">
                                <div class="card-body">
                                    <span class="badge bg-info category-badge">Lecture</span>
                                    <h5 class="card-title">Introduction to Algorithms</h5>
                                    <p class="note-date"><i class="far fa-calendar-alt me-1"></i> March 2, 2025</p>
                                    <p class="card-text note-preview">Algorithm analysis is the determination of the
                                        computational complexity of algorithms, that is the amount of time, storage
                                        and/or other resources necessary to execute them...</p>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i>
                                            Edit</button>
                                        <div>                                           
                                            <button class="btn btn-sm btn-outline-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                     

                      

                       

                       
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Add New Note Button -->
        <button class="btn btn-primary btn-lg rounded-circle btn-floating shadow" data-bs-toggle="modal"
            data-bs-target="#addNoteModal">
            <i class="fas fa-plus"></i>
        </button>

        <!-- Add Note Modal -->
        <div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="noteTitle" class="form-label">Note Title</label>
                                    <input type="text" class="form-control" id="noteTitle"
                                        placeholder="Enter note title" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="noteCategory" class="form-label">Category</label>
                                    <select class="form-select" id="noteCategory" required>
                                        <option value="">Select category</option>
                                        <option value="lecture">Lecture</option>
                                        <option value="assignment">Assignment</option>
                                        <option value="topic">Topic</option>
                                        <option value="exam">Exam Prep</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="noteCourse" class="form-label">Course</label>
                                <select class="form-select" id="noteCourse" required>
                                    <option value="">Select course</option>
                                    <option value="cs101" selected>CS101 - Introduction to Computer Science</option>
                                    <option value="math201">MATH201 - Calculus I</option>
                                    <option value="eng105">ENG105 - English Composition</option>
                                    <option value="phys102">PHYS102 - Introduction to Physics</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="noteContent" class="form-label">Note Content</label>
                                <div class="btn-toolbar mb-2" role="toolbar">
                                    <div class="btn-group me-2" role="group">
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-bold"></i></button>
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-italic"></i></button>
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-underline"></i></button>
                                    </div>
                                    <div class="btn-group me-2" role="group">
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-list-ul"></i></button>
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-list-ol"></i></button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-link"></i></button>
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-image"></i></button>
                                        <button type="button" class="btn btn-outline-secondary"><i
                                                class="fas fa-code"></i></button>
                                    </div>
                                </div>
                                <textarea class="form-control" id="noteContent" rows="10"
                                    placeholder="Write your notes here..." required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="noteTags" class="form-label">Tags (Optional)</label>
                                    <input type="text" class="form-control" id="noteTags"
                                        placeholder="algorithms, data structures">
                                    <div class="form-text">Separate tags with commas</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="noteAttachment" class="form-label">Attachments (Optional)</label>
                                    <input class="form-control" type="file" id="noteAttachment">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save Note</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </body>

</html>