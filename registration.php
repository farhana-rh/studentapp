<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
    body{
        padding:50px;
    }
    .container{
    max-width: 600px;
    margin:0 auto;
    padding:50px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }
    .form-group{
    margin-bottom:30px;
    }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // just naming out the variables for php and db
         if (isset($_POST["submit"])) {
           $full_name = $_POST["full_name"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $repeat_password = $_POST["repeat_password"];
           $student_id = $_POST["student_id"];
           $university = $_POST["university"];
           $department = $_POST["department"];
           $academic_year = $_POST["academic_year"];

           // pass hash

           $password_hash = password_hash($password, PASSWORD_DEFAULT);
           // Errors Validation in Front end
           $errors = array();


           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$repeat_password) {
            array_push($errors,"Password does not match");
           }


           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }

           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{ 

                // insert data from here if no error
            $sql = "INSERT INTO users (full_name, email, password, student_id, university, department, academic_year) VALUES ( ?, ?, ? , ? , ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sssssss",$full_name, $email, $password_hash, $student_id, $university, $department, $academic_year );
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }

           
         }
        ?>
        <form action="registration.php" method="post" enctype="multipart/form-data">
            <h1 class="mb-4">Student App Registration</h1>
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
            </div>
            <div class="form-group mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
            </div>
            
           
            <div class="form-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <small class="form-text text-muted">Password must be at least 8 characters long</small>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password" required>
            </div>
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="student_id" placeholder="Student ID" required>
            </div>
            <div class="form-group mb-3">
                <select class="form-control" name="university">
                    <option value="" disabled selected>Select University</option>
                    <option value="North South University">North South University</option>
                    <option value="BRACU">BRACU</option>
                    <option value="Dhaka University">Dhaka University</option>
                    <!-- Add more departments as needed -->
                </select>
            </div>
            <div class="form-group mb-3">
                <select class="form-control" name="department">
                    <option value="" disabled selected>Select Department</option>
                    <option value="CSE">CSE</option>
                    <option value="EEE">EEE</option>
                    <option value="BBA">BBA</option>
                    <option value="ARCH">ARCH</option>
                    <option value="CEE">CEE</option>
                    <option value="Pharma">Pharma</option>
                    <!-- Add more departments as needed -->
                </select>
            </div>
            <div class="form-group mb-3">
                <select class="form-control" name="academic_year">
                    <option value="" disabled selected>Select Academic Year</option>
                    <option value="Freshman">Freshman (1st Year)</option>
                    <option value="Sophomore">Sophomore (2nd Year)</option>
                    <option value="Junior">Junior (3rd Year)</option>
                    <option value="Senior">Senior (4th Year)</option>
                    <option value="Graduate">Graduate Student</option>
                </select>
            </div>


            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                <label class="form-check-label" for="terms">I agree to the Terms of Service and Privacy Policy</label>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
            <div class="mt-3"><p>Already Registered? <a href="login.php">Login Here</a></p></div>
        </div>
</body>
</html>