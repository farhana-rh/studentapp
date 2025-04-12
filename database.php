<?php

$hostName = "localhost:4306";
$dbUser = "root";
$dbPassword = "";
$dbName = "studentapp";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>