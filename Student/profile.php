<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';

$query = "SELECT * FROM tblstudents
    INNER JOIN tblbranch ON tblbranch.Id = tblstudents.branchId  
    INNER JOIN tblyear ON tblyear.Id = tblstudents.yearId 
    INNER JOIN tblterm ON tblterm.yearId = tblstudents.yearId
    INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId
    INNER JOIN tblstudentregister ON tblstudentregister.studentId = tblstudents.Id 
    WHERE tblstudents.Id = '$_SESSION[userId]' AND tblsessionTerm.isAdActive = '1'";
$qry = $conn->query($query);
$row = $qry->fetch_assoc();

//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {


    $phoneNo = $_POST['phoneNo'];
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $dateCreated = date("d-m-Y");

    $query4 = mysqli_query($conn, "update tblstudentregister set emailAddress = '$emailAddress', phoneNo = '$phoneNo', pass = '$password', dateCreated = '$dateCreated' where studentId='$Id'");
    if ($query4) {

      $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Updated Successfully!</div>";
      echo $statusMsg;

      echo "<script>
                window.location = (\"profile.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/logo/attnlg.jpg" rel="icon">
  <title>AMS | Profile</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/ruang-admin.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manage Profile</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-4">
                        <label class="form-control-label">First Name</label>
                        <input type="text" class="form-control" name="firstName" value="<?php echo $row['firstName']; ?>" disabled>
                      </div>
                      <div class="col-xl-4">
                        <label class="form-control-label">Last Name</label>
                        <input type="text" class="form-control" name="lastName" value="<?php echo $row['lastName']; ?>" disabled>
                      </div>
                      <div class="col-xl-4">
                        <label class="form-control-label">Date Of Birth<span class="text-danger ml-2">*</span></label>
                        <input type="date" class="form-control" name="dateOfBirth" max="<?php echo date("Y-m-d") ?>" value="<?php echo $row['dateOfBirth'] ?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Roll Number</label>
                        <input type="text" class="form-control" name="rollNumber" value="<?php echo $row['rollNumber']; ?>" disabled>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Branch</label>
                        <input type="text" class="form-control" name="branch" value="<?php echo $row['branchName']; ?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Year</label>
                        <input type="text" class="form-control" name="year" value="<?php echo $row['yearName']; ?>" disabled>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Semester</label>
                        <input type="text" class="form-control" name="term" value="<?php echo $row['termName']; ?>" disabled>
                      </div>
                    </div>
                    <?php
                    if (isset($Id)) {
                    ?>
                      <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">Email<span class="text-danger ml-2">*</span></label>
                          <input type="email" pattern="^[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" class="form-control" name="emailAddress" value="<?php echo $row['emailAddress']; ?>" placeholder="Enter Email Address" required>
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Phone Number<span class="text-danger ml-2">*</span></label>
                          <input type="tel" pattern="[6789]{1}[0-9]{9}" title="Please enter valid phone number" class="form-control" name="phoneNo" value="<?php echo $row['phoneNo']; ?>" placeholder="Enter Phone Number" required>
                        </div>
                      </div>
                      <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">Password<span class="text-danger ml-2">*</span></label>
                          <input type="text" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.,;!@#$%^&*])[a-zA-Z0-9.,;!@#$%^&*]{7,20}$" minlength="6" maxlength="20" title="Please enter 7 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character" class="form-control" name="password" value="<?php echo $row['pass']; ?>" placeholder="Enter Password" required>
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Confirm Password<span class="text-danger ml-2">*</span></label>
                          <input type="text" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.,;!@#$%^&*])[a-zA-Z0-9.,;!@#$%^&*]{7,20}$" minlength="6" maxlength="20" class="form-control" for="password" name="cpassword" placeholder="Reenter Password" required>
                        </div>
                      </div>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <button type="submit" name="cancel" onclick="javascript:window.location='profile.php'" class="btn btn-primary">Cancel</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    } else {
                    ?>
                      <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">Email</label>
                          <input type="text" class="form-control" required name="emailAddress" value="<?php echo $row['emailAddress']; ?>" disabled>
                        </div>
                        <div class="col-xl-6">
                          <label class="form-control-label">Phone Number</label>
                          <input type="text" class="form-control" name="phoneNo" value="<?php echo $row['phoneNo']; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row mb-3">
                        <div class="col-xl-6">
                          <label class="form-control-label">Password</label>
                          <input type="password" class="form-control" required name="password" value="<?php echo $row['pass']; ?>" disabled>
                        </div>
                      </div>
                      <a class="btn btn-primary" style="text-decoration: none; color: white;" href="?action=edit&Id=<?php echo $_SESSION['userId'] ?>">Edit</a>
                    <?php
                    }
                    ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!---Container Fluid-->
        </div>
      </div>
      <!-- Footer -->
      <?php include "Includes/footer.php"; ?>
      <!-- Footer -->
    </div>
  </div>
  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- JQuery and JS links -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
</body>

</html>