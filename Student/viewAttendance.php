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
              <li class="breadcrumb-item active" aria-current="page">View Attendance</li>
            </ol>
          </div>
          <!-- Row -->
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
                        <label class="form-control-label">Subject<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qury = "SELECT tblsubject.Id AS Id, tblsubject.subjectName AS subjectName FROM tblsubject
                        LEFT JOIN tblsessionterm ON tblsessionterm.termId = tblsubject.termId
                        WHERE tblsessionterm.branchId = tblsubject.branchId 
                        AND tblsessionterm.yearId = tblsubject.yearId AND tblsessionterm.isAdActive = '1'";
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
              <!-- Form Basic -->
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
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Status</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php

                          if (isset($_POST['view'])) {

                            $type =  $_POST['type'];
                            $subjectId = $_POST['subjectId'];

                            if ($type == "1") { //All Attendance

                              $query = "SELECT tblsubject.subjectName AS subjectName, tblattendance.status AS statuss, tblattendance.dateTimeTaken
                        FROM tblattendance
                        INNER JOIN tblstudents ON tblstudents.Id = '$_SESSION[userId]'
                        INNER JOIN tblsubject ON tblsubject.Id = tblattendance.subjectId
                        WHERE tblattendance.rollNumber = tblstudents.rollNumber AND tblattendance.subjectId = '$subjectId' ORDER BY tblattendance.dateTimeTaken ASC";
                            }
                            if ($type == "2") { //Single Date Attendance

                              $singleDate =  $_POST['singleDate'];
                              $query = "SELECT tblsubject.subjectName AS subjectName, tblattendance.status AS statuss, tblattendance.dateTimeTaken
                        FROM tblattendance
                        INNER JOIN tblstudents ON tblstudents.Id = '$_SESSION[userId]'
                        INNER JOIN tblsubject ON tblsubject.Id = tblattendance.subjectId
                        WHERE tblattendance.rollNumber = tblstudents.rollNumber AND tblattendance.subjectId = '$subjectId' AND tblattendance.dateTimeTaken = '$singleDate'";
                            }
                            if ($type == "3") { //Date Range Attendance

                              $fromDate =  $_POST['fromDate'];
                              $toDate =  $_POST['toDate'];

                              $query = "SELECT tblsubject.subjectName AS subjectName, tblattendance.status AS statuss, tblattendance.dateTimeTaken
                              FROM tblattendance
                              INNER JOIN tblstudents ON tblstudents.Id = '$_SESSION[userId]'
                              INNER JOIN tblsubject ON tblsubject.Id = tblattendance.subjectId
                              WHERE tblattendance.rollNumber = tblstudents.rollNumber AND tblattendance.subjectId = '$subjectId' AND tblattendance.dateTimeTaken between '$fromDate' and '$toDate'";
                            }

                            $rs = $conn->query($query);
                            $num = $rs->num_rows;
                            $sn = 0;
                            $totalP = 0;
                            $totalA = 0;
                            $status = "";
                            if ($num > 0) {
                              while ($rows = $rs->fetch_assoc()) {
                                if ($rows['statuss'] == '1') {
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
                              <tr>
                              <td>" . $sn . "</td>
                              <td>" . $rows['dateTimeTaken'] . "</td>
                              <td>" . $rows['subjectName'] . "</td>
                              <td style='background-color:" . $colour . "'>" . $status . "</td>
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