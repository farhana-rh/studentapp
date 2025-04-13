<?php
session_start();
include 'database.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $user_id = $_SESSION['user']['id'];
//     $title = mysqli_real_escape_string($conn, $_POST['title']);
//     $content = mysqli_real_escape_string($conn, $_POST['content']);
//     $note_type = $_POST['note_type'];
//     $course_id = intval($_POST['course_id']);

//     $sql = "INSERT INTO notes (user_id, course_id, title, content, note_type)
//             VALUES ('$user_id', '$course_id', '$title', '$content', '$note_type')";

//     if (mysqli_query($conn, $sql)) {
//         header("Location: notes.php?course_id=$course_id");
//         exit();
//     } else {
//         echo "Error: " . mysqli_error($conn);
//     }
// }



//add new note

if (isset($_POST['add_note'])) {
    $user_id = $_SESSION['user']['id'];
    
    // Validate that these fields are set before using them
    $title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : '';
    $content = isset($_POST['content']) ? mysqli_real_escape_string($conn, $_POST['content']) : '';
    $note_type = isset($_POST['note_type']) ? $_POST['note_type'] : '';
    $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;

    if (!$title || !$content || !$note_type || !$course_id) {
        echo "Missing required fields.";
        exit();
    }

    $sql = "INSERT INTO notes (user_id, course_id, title, content, note_type)
            VALUES ('$user_id', '$course_id', '$title', '$content', '$note_type')";

    if (mysqli_query($conn, $sql)) {
        header("Location: notes.php?course_id=$course_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Handle note update
if (isset($_POST['update'])) {
    include('database.php');
    
    $note_id = mysqli_real_escape_string($conn, $_POST['note_id']);
    $title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : '';
    $content = isset($_POST['content']) ? mysqli_real_escape_string($conn, $_POST['content']) : '';
    $note_type = isset($_POST['note_type']) ? mysqli_real_escape_string($conn, $_POST['note_type']) : '';
    $course_id = isset($_POST['course_id']) ? mysqli_real_escape_string($conn, $_POST['course_id']) : '';

    $sqlUpdate = "UPDATE notes 
                  SET title='$title', content='$content', note_type='$note_type', course_id='$course_id' 
                  WHERE id=$note_id";

    if (mysqli_query($conn, $sqlUpdate)) {
        header("Location: notes.php");
        exit();
    } else {
        echo "Error updating note: " . mysqli_error($conn);
    }
}
// Handle note deletion via POST request
if (isset($_POST['delete_note'])) {
    include('database.php');

    $note_id = intval($_POST['delete_note_id']);
    $user_id = $_SESSION['user']['id'];

    $sqlDelete = "DELETE FROM notes WHERE id = $note_id AND user_id = $user_id";

    if (mysqli_query($conn, $sqlDelete)) {
        header("Location: notes.php");
        exit();
    } else {
        echo "Error deleting note: " . mysqli_error($conn);
    }
}
?>
