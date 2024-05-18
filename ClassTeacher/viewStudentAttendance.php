<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../img/logo/attnlg.jpg" rel="icon">
  <title>AMS | View Students Attendance</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/ruang-admin.css" rel="stylesheet">

  <script>
    function typeDropDown(str) {
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
        xmlhttp.open("GET", "../Admin/ajaxCallTypes.php?tid=" + str, true);
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
            <h1 class="h3 mb-0 text-gray-800">View Student Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="takeAttendance.php">Take Atttendance</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="viewAttendance.php">Class Attendance</a></li>
              <li class="breadcrumb-item active" aria-current="page">Students Attendance</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">View Student Attendance</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Student<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qry = "SELECT *
                        FROM tblstudents
                        INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
                        WHERE tblstudents.yearId = tblsessionterm.yearId AND tblstudents.sessionTermId = tblsessionterm.Id 
                        AND tblsessionterm.isCtActive = '1' ORDER BY tblstudents.firstName ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;
                        if ($num > 0) {
                          echo ' <select required name="rollNumber" class="form-control mb-3">';
                          echo '<option value="">--Select Student--</option>';
                          while ($rows = $result->fetch_assoc()) {
                            echo '<option value="' . $rows['rollNumber'] . '" >' . $rows['firstName'] . ' ' . $rows['lastName'] . '</option>';
                          }
                          echo '</select>';
                        }
                        ?>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Subject<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qury = "SELECT tblsubject.Id As Id, tblsubject.subjectName AS subjectName from tblsubject
                                INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
                                WHERE tblsubject.teacherId = '$_SESSION[userId]' AND tblsubject.yearId = tblsessionterm.yearId AND tblsubject.termId = tblsessionterm.termId AND tblsessionterm.isCtActive = '1'";
                        $result = $conn->query($qury);
                        $num = $result->num_rows;
                        if ($num > 0) {
                          echo '<select required name="subjectId" class="form-control mb-3">';
                          echo '<option value="">--Select Subject--</option>';
                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['Id'] . '" >' . $row['subjectName'] . '</option>';
                          }
                          echo '</select>';
                        }
                        ?>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Type<span class="text-danger ml-2">*</span></label>
                        <select required name="type" onchange="typeDropDown(this.value)" class="form-control mb-3">
                          <option value="">--Select--</option>
                          <option value="1">All</option>
                          <option value="2">By Single Date</option>
                          <option value="3">By Date Range</option>
                        </select>
                      </div>
                    </div>
                    <?php
                    echo "<div id='txtHint'></div>";
                    ?>
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Students Attendance</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr style='text-align: center;'>
                            <th>#</th>
                            <th style='text-align: left;'>Name</th>
                            <th>Roll Number</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Date</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php

                          if (isset($_POST['view'])) {

                            $rollNumber =  $_POST['rollNumber'];
                            $type =  $_POST['type'];
                            $subjectId = $_POST['subjectId'];

                            if ($type == "1") { //All Attendance

                              $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$_SESSION[branchId]' and tblattendance.yearId = tblsessionterm.yearId and tblattendance.subjectId = '$subjectId' and tblsessionterm.isCtActive = '1'";
                            }
                            if ($type == "2") { //Single Date Attendance

                              $singleDate =  $_POST['singleDate'];
                              $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.dateTimeTaken = '$singleDate' and tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$_SESSION[branchId]' and tblattendance.yearId = tblsessionterm.yearId and tblattendance.subjectId = '$subjectId' and tblsessionterm.isCtActive = '1'";
                            }
                            if ($type == "3") { //Date Range Attendance

                              $fromDate =  $_POST['fromDate'];
                              $toDate =  $_POST['toDate'];

                              $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$_SESSION[branchId]' and tblattendance.yearId = tblsessionterm.yearId and tblattendance.subjectId = '$subjectId' and tblsessionterm.isCtActive = '1'";
                            }

                            $rs = $conn->query($query);
                            $num = $rs->num_rows;
                            $sn = 0;
                            $totalP = 0;
                            $totalA = 0;
                            $status = "";
                            if ($num > 0) {
                              while ($rows = $rs->fetch_assoc()) {
                                if ($rows['status'] == '1') {
                                  $status = "Present";
                                  $colour = "#00FF00";
                                  $totalP = $totalP + 1;
                                } else {
                                  $status = "Absent";
                                  $colour = "#FF0000";
                                  $totalA = $totalA + 1;
                                }
                                $sn = $sn + 1;
                                echo "
                              <tr style='text-align: center;'>
                                <td>" . $sn . "</td>
                                <td style='text-align: left;'>" . $rows['firstName'] . " " . $rows['lastName'] . "</td>
                                <td>" . $rows['rollNumber'] . "</td>
                                <td>" . $rows['branchName'] . "</td>
                                <td>" . $rows['yearName'] . "</td>
                                <td>" . $rows['termName'] . "</td>
                                <td style='background-color:" . $colour . "'>" . $status . "</td>
                                <td>" . $rows['dateTimeTaken'] . "</td>
                              </tr>";
                              }
                          ?>
                        </tbody>
                        <thead class="thead-light">
                          <tr>
                            <th>Present</th>
                            <th>Absent</th>
                          </tr>
                        </thead>

                        <tbody>
                      <?php
                              echo "
                          <tr>
                            <td>" . $totalP . "</td>
                            <td>" . $totalA . "</td>
                            </tr>";
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
                      <?php
                      if (isset($_POST['view'])) {
                        if ($num > 0) {
                          echo '
                    <form method="post" action="downloadStudentRecord.php">
                            <input type="hidden" name="rollNumber" value=' . $_POST['rollNumber'] . ' class="form-control">
                            <input type="hidden" name="type" value=' . $_POST['type'] . ' class="form-control">';
                          if ($type == "2") {
                            echo '<input type="hidden" name="singleDate" value=' . $_POST['singleDate'] . ' class="form-control">';
                          } else if ($type == "3") {
                            echo '<input type="hidden" name="fromDate" value=' . $_POST['fromDate'] . ' class="form-control">;
                                    <input type="hidden" name="toDate" value=' . $_POST['toDate'] . ' class="form-control">';
                          }
                          echo '<input type="hidden" name="subjectId" value=' . $_POST['subjectId'] . ' class="form-control">
                          <div class="d-sm-flex align-items-end justify-content-end">
                              <button type="submit" class="btn btn-primary">Download</button>
                          </div>
                  </form>
                  ';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Row-->
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