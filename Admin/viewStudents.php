<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';

//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query3 = mysqli_query($conn, "select * from tblstudents where Id ='$Id'");
  $row = mysqli_fetch_array($query3, MYSQLI_ASSOC);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dateOfBirth'];
    $phoneNo = $_POST['phoneNo'];
    $rollNumber = $_POST['rollNumber'];
    $branchId = $_POST['branchId'];
    $yearId = $_POST['yearId'];
    $sessionTermId = $_POST['sessionTermId'];
    $dateCreated = date("Y-m-d");

    $query4 = mysqli_query($conn, "update tblstudents set firstName='$firstName', lastName='$lastName',phoneNo='$phoneNo',rollNumber='$rollNumber', branchId='$branchId',yearId='$yearId',sessionTermId='$sessionTermId',dateOfBirth='$dob',dateCreated = '$dateCreated' where Id='$Id'");
    if ($query4) {
      $statusMsg = "<div class='alert alert-success' role='alert'>Updated Successfully!</div>";
      header("location: viewStudents.php?message=$statusMsg");
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
    }
  }
}

//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query5 = mysqli_query($conn, "DELETE FROM tblstudents WHERE Id='$Id'");

  if ($query5 == TRUE) {
    $statusMsg = "<div class='alert alert-danger' role='alert'>Deleted Successfully!</div>";
    header("location: viewStudents.php?message=$statusMsg");
  } else {
    $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
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
  <title>AMS | View Students</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/ruang-admin.css" rel="stylesheet">
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
        xmlhttp.open("GET", "ajaxYearDrop.php?cid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
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
            <h1 class="h3 mb-0 text-gray-800">All Student in Class</h1>
            <?php if (isset($_GET['message']) && !empty($_GET['message'])) {
              echo $_GET['message'];
            }
            echo $statusMsg;
            ?>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="createStudents.php">Create Students</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Students</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <?php
              if (isset($Id)) {
              ?>
                <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Create Students</h6>
                  </div>

                  <div class="card-body">
                    <form method="Post" action="viewStudents.php">
                      <div class="form-row">
                        <div class="col-md-4 mb-3">
                          <label class="form-control-label">First Name<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" required name="firstName" maxlength="32" pattern="^[A-Za-z]{1,32}$" title="Please enter a valid first name containing only letters" placeholder="Enter First Name" value="<?php echo $row['firstName'] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                          <label class="form-control-label">Last Name<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" required name="lastName" maxlength="32" pattern="^[A-Za-z ]{1,32}$" title="Please enter a valid last name containing only letters" placeholder="Enter Last Name" value="<?php echo $row['lastName'] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                          <label class="form-control-label">Date Of Birth<span class="text-danger ml-2">*</span></label>
                          <input type="date" class="form-control" name="dateOfBirth" max="<?php echo date("Y-m-d") ?>" value="<?php echo $row['dateOfBirth'] ?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label class="form-control-label">Phone Number<span class="text-danger ml-2">*</span></label>
                          <input type="tel" pattern="[6789]{1}[0-9]{9}" title="Please enter valid phone number" maxlength="10" class="form-control" name="phoneNo" placeholder="Enter Phone Number" value="<?php echo $row['phoneNo'] ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-control-label">Roll Number<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" pattern="[0-9]{9,30}" title="Please enter a valid roll number" maxlength="30" required name="rollNumber" placeholder="Enter Roll Number" value="<?php echo $row['rollNumber'] ?>">
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
                            while ($rowss = $result->fetch_assoc()) {
                              echo '<option value="' . $rowss['Id'] . '" >' . $rowss['branchName'] . '</option>';
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
                          <label class="form-control-label">Semester<span class="text-danger ml-2">*</span></label>
                          <?php
                          echo "<div id='txtHint2'></div>";
                          ?>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-control-label">Session<span class="text-danger ml-2">*</span></label>
                          <?php

                          echo "<div id='txtHint3'></div>";
                          ?>
                        </div>
                      </div>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <button type="submit" name="cancel" onclick="javascript:window.location='viewStudents.php'" class="btn btn-primary">Cancel</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </form>
                  </div>
                </div>
              <?php
              }
              ?>
              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="table-responsive p-3">
                      <form method="post">
                        <div class="form-group row mb-3">
                          <div class="col-xl-6">
                            <label class="form-control-label">Select Branch<span class="text-danger ml-2">*</span></label>
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
                          <div class="col-xl-6">
                            <label class="form-control-label">Year<span class="text-danger ml-2">*</span></label>
                            <?php
                            echo "<div id='txtHint'></div>";
                            ?>
                          </div>
                        </div>
                        <div class="form-group row mb-3">
                          <div class="col-xl-6">
                            <button type="submit" name="show" class="btn btn-primary">Show</button>
                          </div>
                        </div>
                      </form>
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Roll Number</th>
                            <th>Phone Number</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Date Created</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php
                          if (isset($_POST['show'])) {
                            $query = "SELECT tblstudents.Id,tblbranch.branchName,tblyear.yearName,tblyear.Id AS yearId,tblstudents.firstName,
                      tblstudents.lastName,tblstudents.phoneNo,tblstudents.rollNumber,tblstudents.dateCreated
                      FROM tblstudents
                      INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId
                      INNER JOIN tblbranch ON tblbranch.Id = tblstudents.branchId
                      INNER JOIN tblyear ON tblyear.Id = tblstudents.yearId
                      where tblstudents.branchId = '$_POST[branchId]' and tblstudents.yearId = '$_POST[yearId]' 
                      AND tblsessionterm.isAdActive = '1' ORDER BY tblStudents.FirstName ASC";
                            $rs = $conn->query($query);
                            $num = $rs->num_rows;
                            $sn = 0;
                            if ($num > 0) {
                              while ($rows = $rs->fetch_assoc()) {
                                $sn = $sn + 1;
                                $qrry = mysqli_query($conn, "SELECT * FROM tblstudentregister WHERE tblstudentregister.studentId = '$rows[Id]'");
                                $nn = $qrry->num_rows;
                                echo '
                                <tr>
                                  <td>' . $sn . '</td>
                                  <td>
                                  <a class="dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" style="cursor:pointer;">
                                    <span>' . ucwords(strtolower($rows['firstName'] . ' ' . $rows['lastName'])) . '</span>
                                  </a>';
                                if ($nn > 0) {
                                  $str = $qrry->fetch_assoc();
                                  echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <div class="table-responsive p-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Student Account Details</h6>
                                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                              <th>Phone Number</th>
                                              <th>Email</th>
                                              <th>Password</th>
                                              <th>Date Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              <tr>
                                                <td>' . $str['phoneNo'] . '</td>
                                                <td>' . $str['emailAddress'] . '</td>
                                                <td>' . $str['pass'] . '</td>
                                                <td>' . $str['dateCreated'] . '</td>
                                              </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>';
                                }
                                echo "</td>
                                <td>" . $rows['rollNumber'] . "</td>
                                <td>" . $rows['phoneNo'] . "</td>
                                <td>" . $rows['branchName'] . "</td>
                                <td>" . $rows['yearName'] . "</td>
                                <td>" . $rows['dateCreated'] . "</td>
                                <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i></a></td>
                                <td><a href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i></a></td>
                              </tr>";
                              }
                            } else {
                              echo
                              "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->
        </div>
        <!---Container Fluid-->
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
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>