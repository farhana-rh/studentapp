<?php
session_start(); 
include("database.php");

if (!isset($_SESSION["user"]["id"])) {
    die("Error: User not logged in.");
}

$user_id = $_SESSION["user"]["id"];

if (isset($_POST["create"])) {
    $course_name = mysqli_real_escape_string($conn, $_POST["course_name"]);
    $course_code = mysqli_real_escape_string($conn, $_POST["course_code"]);
    $credit_hours = filter_input(INPUT_POST, 'credit_hours', FILTER_VALIDATE_INT);
    $instructor_name = mysqli_real_escape_string($conn, $_POST["instructor_name"]);
    $instructor_email = mysqli_real_escape_string($conn, $_POST["instructor_email"]);

    $sqlInsert = "INSERT INTO courses(user_id, course_code, course_name, credit_hours, instructor_name, instructor_email)
                  VALUES ($user_id, '$course_code', '$course_name', $credit_hours, '$instructor_name', '$instructor_email')";

    if (mysqli_query($conn, $sqlInsert)) {
        echo "Record inserted";
    } else {
        die("Something went wrong: " . mysqli_error($conn));
    }
}



// if (isset($_POST["edit"])) {
//     $course_id = mysqli_real_escape_string($conn, $_POST["id"]);
//     $course_name = mysqli_real_escape_string($conn, $_POST["course_name"]);
//     $course_code = mysqli_real_escape_string($conn, $_POST["course_code"]);
//     $credit_hours = filter_input(INPUT_POST, 'credit_hours', FILTER_VALIDATE_INT);
//     $instructor_name = mysqli_real_escape_string($conn, $_POST["instructor_name"]);
//     $instructor_email = mysqli_real_escape_string($conn, $_POST["instructor_email"]);

//     $sqlUpdate = "UPDATE courses 
//               SET course_code = '$course_code', 
//                   course_name = '$course_name', 
//                   credit_hours = $credit_hours, 
//                   instructor_name = '$instructor_name', 
//                   instructor_email = '$instructor_email' 
//               WHERE id = $course_id AND user_id = $user_id";

//     if (mysqli_query($conn, $sqlUpdate)) {
//         echo "Record inserted";
//     } else {
//         die("Something went wrong: " . mysqli_error($conn));
//     }
// }
?> 
