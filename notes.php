<?php
    session_start();
   include('database.php');
   $user_id = $_SESSION["user"]["id"];
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

// Get course details (for heading)
$courseInfo = null;
if ($course_id) {
    $courseQuery = "SELECT * FROM courses WHERE id = $course_id AND user_id = $user_id";
    $courseResult = mysqli_query($conn, $courseQuery);
    $courseInfo = mysqli_fetch_assoc($courseResult);
}

// Notes query
$sqlSelect = "SELECT notes.*, courses.course_code, courses.course_name 
              FROM notes 
              JOIN courses ON notes.course_id = courses.id 
              WHERE notes.user_id = $user_id";

if ($course_id) {
    $sqlSelect .= " AND notes.course_id = $course_id";
}

$sqlSelect .= " ORDER BY notes.created_at DESC";

$result = mysqli_query($conn, $sqlSelect);
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
                       
                    </ul>
                    <div class="ms-auto d-flex align-items-center">
                       
                    <button class="btn btn-light btn-sm"><a href="logout.php">Logout</a></button>
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
                            <a href="notes.php?course_id=<?php echo $course['id']; ?>" class="list-group-item list-group-item-action  d-flex align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($course['course_name']); ?> </strong>
                                    <div class="small"><?php echo htmlspecialchars($course['course_code']); ?>
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
                    <!-- <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3>CS101 Notes</h3>
                            <p class="text-muted">Introduction to Computer Science</p>
                        </div>
                        
                    </div> -->
                    <?php if ($courseInfo): ?>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h3><?php echo htmlspecialchars($courseInfo['course_code']); ?> Notes</h3>
                                <p class="text-muted"><?php echo htmlspecialchars($courseInfo['course_name']); ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mb-4">
                            <h3>All Notes</h3>
                            <p class="text-muted">Select a course to filter notes.</p>
                        </div>
                    <?php endif; ?>
                    <div class="row g-4">
                        <?php
                        
                        // $user_id = $_SESSION["user"]["id"];

                        // $sqlSelect = "SELECT notes.*, courses.course_code, courses.course_name 
                        //             FROM notes 
                        //             JOIN courses ON notes.course_id = courses.id 
                        //             WHERE notes.user_id = $user_id 
                        //             ORDER BY notes.created_at DESC";
                        // $result = mysqli_query($conn, $sqlSelect);
                        // filtering code:

             
                    // $user_id = $_SESSION["user"]["id"];
                    // $course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

                    // // Get course details (for heading)
                    // $courseInfo = null;
                    // if ($course_id) {
                    //     $courseQuery = "SELECT * FROM courses WHERE id = $course_id AND user_id = $user_id";
                    //     $courseResult = mysqli_query($conn, $courseQuery);
                    //     $courseInfo = mysqli_fetch_assoc($courseResult);
                    // }

                    // Notes query
                    $sqlSelect = "SELECT notes.*, courses.course_code, courses.course_name 
                                FROM notes 
                                JOIN courses ON notes.course_id = courses.id 
                                WHERE notes.user_id = $user_id";

                    if ($course_id) {
                        $sqlSelect .= " AND notes.course_id = $course_id";
                    }

                    $sqlSelect .= " ORDER BY notes.created_at DESC";

                    $result = mysqli_query($conn, $sqlSelect);
                        

                        while($note = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="card note-card">
                                    <div class="card-body">
                                        <span class="badge bg-info category-badge">
                                            <?php echo ucfirst($note['note_type']); ?>
                                        </span>
                                        <h5 class="card-title"><?php echo htmlspecialchars($note['title']); ?></h5>
                                        <p class="note-date">
                                            <i class="far fa-calendar-alt me-1"></i> 
                                            <?php echo date("F j, Y", strtotime($note['created_at'])); ?>
                                        </p>
                                        <p class="card-text note-preview">
                                            <?php echo nl2br(htmlspecialchars(substr($note['content'], 0, 150))) . '...'; ?>
                                        </p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <div class="d-flex justify-content-between">
                                      
                                            <button class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editNoteModal"
                                                    data-id="<?php echo $note['id']; ?>"
                                                    data-title="<?php echo $note['title']; ?>"
                                                    data-category="<?php echo $note['note_type']; ?>"
                                                    data-course="<?php echo $note['course_id']; ?>"
                                                    data-content="<?php echo htmlspecialchars($note['content']); ?>">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>
                                            <div>
                                            <button class="btn btn-sm btn-outline-danger delete-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteNoteModal"
                                                    data-id="<?php echo $note['id']; ?>">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                  
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
                        <form action="notes_process.php" method="post">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="noteTitle" class="form-label">Note Title</label>
                                    <input type="text" name="title" class="form-control" id="noteTitle"
                                        placeholder="Enter note title" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="noteCategory" class="form-label">Category</label>
                                    <select class="form-select" name="note_type"  id="noteCategory" required>
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
                                <select class="form-select" name="course_id" id="noteCourse" required>
                                    <!-- <option value="">Select course</option>
                                    <option value="cs101" selected>CS101 - Introduction to Computer Science</option> -->
                                    <?php
                                    $user_id = $_SESSION['user']['id'];
                                    $courseQuery = "SELECT * FROM courses WHERE user_id = $user_id";
                                    $courseResult = mysqli_query($conn, $courseQuery);
                                    while($row = mysqli_fetch_assoc($courseResult)) {
                                        echo "<option value='{$row['id']}'>{$row['course_code']} - {$row['course_name']}</option>";
                                    }
                                    ?>
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
                                <textarea class="form-control" name="content" id="noteContent" rows="10"
                                    placeholder="Write your notes here..." required></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="add_note"  class="btn btn-primary">Save Note</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>


        <!-- Edit Note Modal -->

        <div class="modal fade" id="editNoteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="notes_process.php" method="post">
                            <input type="hidden" name="note_id" id="noteId">
                            <div class="row mb-3">
                            <div class="col-md-8">
                                        <label for="noteTitle" class="form-label">Note Title</label>
                                        <input type="text" name="title" class="form-control" id="noteTitle"
                                            placeholder="Enter note title" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="noteCategory" class="form-label">Category</label>
                                        <select class="form-select" name="note_type"  id="noteCategory" required>
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
                                    <select class="form-select" name="course_id" id="noteCourse" required>
                                        <!-- <option value="">Select course</option>
                                        <option value="cs101" selected>CS101 - Introduction to Computer Science</option> -->
                                        <?php
                                        $user_id = $_SESSION['user']['id'];
                                        $courseQuery = "SELECT * FROM courses WHERE user_id = $user_id";
                                        $courseResult = mysqli_query($conn, $courseQuery);
                                        while($row = mysqli_fetch_assoc($courseResult)) {
                                            echo "<option value='{$row['id']}'>{$row['course_code']} - {$row['course_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="noteContent" class="form-label">Note Content</label>
                                    
                                    <textarea class="form-control" name="content" id="noteContent" rows="10"
                                        placeholder="Write your notes here..." required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Note Modal -->


        <div class="modal fade" id="deleteNoteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="notes_process.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Note</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="delete_note_id" id="deleteNoteId">
                            <p>Are you sure you want to delete this note? This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="delete_note" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
            <script>
   document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('[data-bs-target="#editNoteModal"]');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const noteId = this.getAttribute('data-id');
            const noteTitle = this.getAttribute('data-title');
            const noteCategory = this.getAttribute('data-category');
            const noteCourse = this.getAttribute('data-course');
            const noteContent = this.getAttribute('data-content');
            
            const editForm = document.querySelector('#editNoteModal form');
            editForm.querySelector('#noteId').value = noteId;
            editForm.querySelector('#noteTitle').value = noteTitle;
            editForm.querySelector('#noteCategory').value = noteCategory;
            editForm.querySelector('#noteCourse').value = noteCourse;
            editForm.querySelector('#noteContent').value = noteContent;
        });
    });
});
    // Attach note ID to delete modal
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('deleteNoteId').value = btn.dataset.id;
    });
});
</script>

    </body>

</html>