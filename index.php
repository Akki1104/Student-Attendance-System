<?php
include 'Includes/dbcon.php';
session_start();
include 'Includes/postDataUnset.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="student attendence system">
    <meta name="keywords" content="attendence,student,system">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <title>AMS | Login</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/ruang-admin.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">LOGIN</h1>
                                    </div>
                                    <form class="user" method="Post" action="index.php">
                                        <div class="form-group">
                                            <select name="userType" class="form-control mb-3" required>
                                                <option value="">--Select User Roles--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="Teacher">Teacher</option>
                                                <option value="Student">Student</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="username" id="exampleInputEmail" placeholder="Enter Email Address" pattern="^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="Enter a valid email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[.,!@#$%^&*])[a-zA-Z0-9.,!@#$%^&*]{7,20}$" minlength="6" maxlength="20" title="Enter a valid password" name="password" class="form-control" id="password" placeholder="Enter Password" autocomplete="current-password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck" onclick="myFunction()">show password</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block" value="Login" name="login" />
                                        </div>
                                        <a class="d-flex align-items-center justify-content-center collapse-item" href="studentRegistration.php">Student?Not Registered</a>
                                    </form>
                                    <?php
                                    if (isset($_POST['login'])) {

                                        $userType = $_POST['userType'];
                                        $username = $_POST['username'];
                                        $password = $_POST['password'];

                                        if ($userType == "Administrator") {
                                            $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND pass = '$password'";
                                            $rs = $conn->query($query);
                                            $num = $rs->num_rows;
                                            $rows = $rs->fetch_assoc();

                                            if ($num > 0) {
                                                $_SESSION['userId'] = $rows['Id'];
                                                $_SESSION['firstName'] = $rows['firstName'];
                                                $_SESSION['lastName'] = $rows['lastName'];
                                                $_SESSION['emailAddress'] = $rows['emailAddress'];

                                                echo '<script>swal("login successful!", "Welcome back ' . $rows['firstName'] . " " . $rows['lastName'] . '!", "success").then((value) => {window.location.href = "Admin/index.php";});</script>';
                                            } else {
                                                echo "<div class='alert alert-danger' role='alert'>
                                                       Invalid Email/Password!
                                                      </div>";
                                            }
                                        } else if ($userType == "Teacher") {

                                            $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND pass = '$password'";
                                            $rs = $conn->query($query);
                                            $num = $rs->num_rows;
                                            $rows = $rs->fetch_assoc();

                                            if ($num > 0) {
                                                $_SESSION['userId'] = $rows['Id'];
                                                $_SESSION['firstName'] = $rows['firstName'];
                                                $_SESSION['lastName'] = $rows['lastName'];
                                                $_SESSION['emailAddress'] = $rows['emailAddress'];
                                                $_SESSION['branchId'] = $rows['branchId'];
                                                $_SESSION['yearId'] = $rows['yearId'];

                                                echo '<script>swal("login successful!", "Welcome back ' . $rows['firstName'] . " " . $rows['lastName'] . '!", "success").then((value) => {window.location.href = "ClassTeacher/index.php";});</script>';
                                            } else {
                                                echo "<div class='alert alert-danger' role='alert'>
                                                        Invalid Email/Password!
                                                      </div>";
                                            }
                                        } else if ($userType == "Student") {
                                            $query = "SELECT tblstudentregister.studentId AS Id, tblstudents.firstName AS firstName, tblstudents.lastName AS lastName, tblstudentregister.emailAddress AS emailAddress, tblstudents.branchId AS branchId, tblstudents.yearId AS yearId FROM tblstudentregister INNER JOIN tblstudents ON tblstudentregister.studentId = tblstudents.Id INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId WHERE tblstudentregister.emailAddress = '$username' AND tblstudentregister.pass = '$password' AND tblsessionterm.isAdActive = '1'";
                                            $rs = $conn->query($query);
                                            $num = $rs->num_rows;
                                            $rows = $rs->fetch_assoc();

                                            if ($num > 0) {
                                                $_SESSION['userId'] = $rows['Id'];
                                                $_SESSION['firstName'] = $rows['firstName'];
                                                $_SESSION['lastName'] = $rows['lastName'];
                                                $_SESSION['emailAddress'] = $rows['emailAddress'];
                                                $_SESSION['branchId'] = $rows['branchId'];
                                                $_SESSION['yearId'] = $rows['yearId'];

                                                echo '<script>swal("login successful!", "Welcome back ' . $rows['firstName'] . " " . $rows['lastName'] . '!", "success").then((value) => {window.location.href = "Student/index.php";});</script>';
                                            } else {
                                                echo "<div class='alert alert-danger' role='alert'>
                                                    Invalid Email/Password!
                                                  </div>";
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger' role='alert'>
                                                    Wrong User Type!
                                                  </div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>