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
    <title>AMS | Student Registeration</title>
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/ruang-admin.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        //Function Call For ajaxYearDrop.php file
        function yearDrop(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "Admin/ajaxYearDrop.php?cid=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-25 col-lg-27 col-md-24">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">REGISTRATION</h1>
                                    </div>
                                    <form method="Post" action="studentRegistration.php">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">First Name<span class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="firstName" maxlength="32" pattern="^[A-Za-z]{1,32}$" title="Please enter a valid first name containing only letters" placeholder="Enter First Name">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Last Name<span class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="lastName" maxlength="32" pattern="^[A-Za-z ]{1,32}$" title="Please enter a valid last name containing only letters" placeholder="Enter Last Name">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Date Of Birth<span class="text-danger ml-2">*</span></label>
                                                <input type="date" class="form-control" required name="dateOfBirth" max="<?php echo date("Y-m-d") ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Email Address<span class="text-danger ml-2">*</span></label>
                                                <input type="email" pattern="^[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" class="form-control" required name="emailAddress" placeholder="Enter Email Address">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Phone Number<span class="text-danger ml-2">*</span></label>
                                                <input type="tel" pattern="[6789]{1}[0-9]{9}" title="Please enter valid phone number" maxlength="10" class="form-control" required name="phoneNo" placeholder="Enter Phone Number">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Roll Number<span class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" pattern="[0-9]{9,30}" title="Please enter a valid roll number" maxlength="30" required name="rollNumber" placeholder="Enter Roll Number">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Branch<span class="text-danger ml-2">*</span></label>
                                                <?php
                                                $qry = "SELECT * FROM tblbranch ORDER BY branchName ASC";
                                                $result = $conn->query($qry);
                                                $num = $result->num_rows;
                                                if ($num > 0) {
                                                    echo ' <select required name="branchId" onchange="yearDrop(this.value)" class="form-control mb-3">';
                                                    echo '<option value="">--Select Branch--</option>';
                                                    while ($rows = $result->fetch_assoc()) {
                                                        echo '<option value="' . $rows['Id'] . '" >' . $rows['branchName'] . '</option>';
                                                    }
                                                    echo '</select>';
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Year<span class="text-danger ml-2">*</span></label>
                                                <?php
                                                echo "<div id='txtHint'></div>";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Password<span class="text-danger ml-2">*</span></label>
                                                <input type="text" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.,;!@#$%^&*])[a-zA-Z0-9.,;!@#$%^&*]{7,20}$" minlength="6" maxlength="20" title="Please enter 7 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character" class=" form-control" name="password" required placeholder="Enter Password">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Confirm Password<span class="text-danger ml-2">*</span></label>
                                                <input type="text" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.,;!@#$%^&*])[a-zA-Z0-9.,;!@#$%^&*]{7,20}$" minlength="6" maxlength="20" title="Please enter 7 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character" class=" form-control" for="password" name="cpassword" required placeholder="Reenter Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-block btn-primary" value="register" name="register" />
                                        </div>
                                        <a class="d-flex align-items-center justify-content-center collapse-item" href="index.php">Login?</a>
                                    </form>

                                    <?php

                                    if (isset($_POST['register'])) {
                                        $firstName = $_POST['firstName'];
                                        $lastName = $_POST['lastName'];
                                        $dob = $_POST['dateOfBirth'];
                                        $emailAddress = $_POST['emailAddress'];
                                        $phoneNo = $_POST['phoneNo'];
                                        $rollNumber = $_POST['rollNumber'];
                                        $branchId = $_POST['branchId'];
                                        $yearId = $_POST['yearId'];
                                        $password = $_POST['password'];
                                        $cpassword = $_POST['cpassword'];
                                        $date = date("Y-m-d");

                                        $qurty = mysqli_query($conn, "SELECT * FROM tblstudents
                                        WHERE tblstudents.rollNumber = '$rollNumber' AND tblstudents.branchId = '$branchId' AND tblstudents.yearId = '$yearId' AND tblstudents.dateOfBirth = '$dob'");
                                        $nums = $qurty->num_rows;
                                        $rows = $qurty->fetch_assoc();
                                        if ($nums > 0) {
                                            $qury = mysqli_query($conn, "SELECT * FROM tblstudentregister WHERE studentId = '$rows[Id]'");
                                            $num = $qury->num_rows;
                                            if ($num <= 0) {
                                                $arr = explode('@', $emailAddress);
                                                if (($password == $cpassword) && ($arr[1] == "gmail.com" || $arr[1] == "yahoo.com" || $arr[1] == "hotmail.com" || $arr[1] == "outlook.com")) {
                                                    $qury = mysqli_query($conn, "INSERT INTO tblstudentregister(studentId,phoneNo,emailAddress,pass,dateCreated) VALUE('$rows[Id]','$phoneNo','$emailAddress','$password','$date')");

                                                    if ($qury) {
                                                        echo '<script>swal("Registeration successful!", "Login Now!", "success").then((value) => {window.location.href = "index.php";});</script>';
                                                    } else {
                                                        echo "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
                                                    }
                                                } else if (!($password == $cpassword)) {
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                                Password must be same!
                                                            </div>";
                                                } else if ($arr[1] != "gmail.com" || $arr[1] != "yahoo.com" || $arr[1] != "hotmail.com" || $arr[1] != "outlook.com") {
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                                E-mail is not correct!
                                                            </div>";
                                                } else {
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                            Invalid Details!
                                                        </div>";
                                                }
                                            } else {
                                                echo '<script>swal("Already Registered!", "Login Now!", "error").then((value) => {window.location.href = "index.php";});</script>';
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger' role='alert'>
                                                No Record Found!
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