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

    //Function Call For ajaxTermDrop.php file
    function termDrop(str) {
      if (str == "") {
        document.getElementById("txtHint2").innerHTML = "";
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
            document.getElementById("txtHint2").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxTermDrop.php?cid=" + str, true);
        xmlhttp.send();
      }
    }

    //Function Call For ajaxSessionTermDrop.php file
    function sessionDrop(str) {
      if (str == "") {
        document.getElementById("txtHint3").innerHTML = "";
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
            document.getElementById("txtHint3").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxSessionTermDrop.php?cid=" + str, true);
        xmlhttp.send();
      }
    }

    //Function Call For ajaxSubjectDrop.php file
    function subjectDrop(str) {
      if (str == "") {
        document.getElementById("txtHint4").innerHTML = "";
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
            document.getElementById("txtHint4").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxSubjectDrop.php?cid=" + str, true);
        xmlhttp.send();
      }
    }

    //Function Call For ajaxSubjectDrop.php file
    function studentDrop(str) {
      if (str == "") {
        document.getElementById("txtHint5").innerHTML = "";
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
            document.getElementById("txtHint5").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxStudentDrop.php?cid=" + str, true);
        xmlhttp.send();
      }
    }

    //Function Call For ajaxCallTypes.php file
    function typeDropDown(str) {
      if (str == "") {
        document.getElementById("txtHint6").innerHTML = "";
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
            document.getElementById("txtHint6").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxCallTypes.php?tid=" + str, true);
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
                        <label class="form-control-label">Semester<span class="text-danger ml-2">*</span></label>
                        <?php
                        echo "<div id='txtHint2'></div>";
                        ?>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Session<span class="text-danger ml-2">*</span></label>
                        <?php

                        echo "<div id='txtHint3'></div>";
                        ?>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Subject<span class="text-danger ml-2">*</span></label>
                        <?php
                        echo "<div id='txtHint4'></div>";
                        ?>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Student<span class="text-danger ml-2">*</span></label>
                        <?php
                        echo "<div id='txtHint5'></div>";
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
                    echo "<div id='txtHint6'></div>";
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
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Roll Number</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Sesmester</th>
                            <th>Status</th>
                            <th>Date</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php

                          if (isset($_POST['view'])) {

                            $branchId = $_POST['branchId'];
                            $yearId = $_POST['yearId'];
                            $termId = $_POST['termId'];
                            $sessionTermId = $_POST['sessionTermId'];
                            $subjectId = $_POST['subjectId'];
                            $rollNumber =  $_POST['rollNumber'];
                            $type =  $_POST['type'];

                            if ($type == "1") { //All Attendance

                              $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.phoneNo,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$branchId' and tblattendance.yearId = '$yearId' and tblsessionterm.Id = '$sessionTermId' and tblattendance.subjectId = '$subjectId'";
                            }
                            if ($type == "2") { //Single Date Attendance

                              $singleDate =  $_POST['singleDate'];

                              $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.phoneNo,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.dateTimeTaken = '$singleDate' and tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$branchId' and tblattendance.yearId = '$yearId' and tblsessionterm.Id = '$sessionTermId' and tblattendance.subjectId = '$subjectId'";
                            }
                            if ($type == "3") { //Date Range Attendance

                              $fromDate =  $_POST['fromDate'];
                              $toDate =  $_POST['toDate'];

                              $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.phoneNo,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$branchId' and tblattendance.yearId = '$yearId' and tblsessionterm.Id = '$sessionTermId' and tblattendance.subjectId = '$subjectId'";
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
                              <tr>
                                <td>" . $sn . "</td>
                                 <td>" . $rows['firstName'] . " " . $rows['lastName'] . "</td>
                                <td>" . $rows['phoneNo'] . "</td>
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
                            <th>Total Present</th>
                            <th>Total Absent</th>
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
                    <form method="post" action="downloadAdminStudentRecord.php">
                            <input type="hidden" name="branchId" value=' . $_POST['branchId'] . ' class="form-control">
                            <input type="hidden" name="yearId" value=' . $_POST['yearId'] . ' class="form-control">
                            <input type="hidden" name="termId" value=' . $_POST['termId'] . ' class="form-control">
                            <input type="hidden" name="sessionTermId" value=' . $_POST['sessionTermId'] . ' class="form-control">
                            <input type="hidden" name="subjectId" value=' . $_POST['subjectId'] . ' class="form-control">
                            <input type="hidden" name="rollNumber" value=' . $_POST['rollNumber'] . ' class="form-control">
                            <input type="hidden" name="type" value=' . $_POST['type'] . ' class="form-control">';
                          if ($_POST['type'] == "2") {
                            echo '<input type="hidden" name="singleDate" value=' . $_POST['singleDate'] . ' class="form-control">';
                          } else if ($_POST['type'] == "3") {
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
                <!-- Input Group -->
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
  <!-- JQuery and JS Links -->
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