<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user']['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $note_type = $_POST['note_type'];
    $course_id = intval($_POST['course_id']);

    $sql = "INSERT INTO notes (user_id, course_id, title, content, note_type)
            VALUES ('$user_id', '$course_id', '$title', '$content', '$note_type')";

    if (mysqli_query($conn, $sql)) {
        header("Location: notes.php?course_id=$course_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
