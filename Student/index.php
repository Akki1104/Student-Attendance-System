<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../img/logo/attnlg.jpg" rel="icon">
  <title>AMS | Home</title>
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
          <div class="row mb-3">
            <!-- Branch Card -->
            <?php
            $query2 = mysqli_query($conn, "SELECT * FROM tblbranch WHERE Id = '$_SESSION[branchId]'");
            $rrw = $query2->fetch_assoc();
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Branch</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rrw['branchName']; ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $query3 = mysqli_query($conn, "SELECT * FROM tblyear WHERE Id = '$_SESSION[yearId]'");
            $rr = mysqli_fetch_assoc($query3);
            ?>
            <!-- Year Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Year</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rr['yearName']; ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-code-branch fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $query4 = mysqli_query($conn, "SELECT tblterm.Id AS Id, tblterm.termName AS termName FROM tblterm LEFT JOIN tblsessionterm ON tblsessionterm.yearId = '$rr[Id]' WHERE tblsessionterm.termId = tblterm.Id AND tblsessionterm.isAdActive =  '1'");
            $sem = mysqli_fetch_assoc($query4);
            ?>
            <!-- Semester Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Semester</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($sem){
                        echo $sem['termName'];
                        }
                        else {
                          echo '';
                        } ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-code fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
             if($sem){
            $query4 = mysqli_query($conn, "SELECT * FROM tblsubject
            WHERE branchId = '$rrw[Id]' AND yearId = '$rr[Id]' AND termId = '$sem[Id]'");
             }
            $subject = mysqli_num_rows($query4);
            ?>
            <!-- Subject Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Subject</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php 
                        echo $subject; ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa-solid fa-book fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Attendance Card -->
            <?php
            $query5 = mysqli_query($conn, "SELECT * FROM tblattendance 
            INNER JOIN tblstudents ON tblstudents.Id = '$_SESSION[userId]' 
            INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId
            WHERE tblattendance.rollNumber = tblstudents.rollNumber AND tblsessionterm.isAdActive = '1'");
            $totAttendance = mysqli_num_rows($query5);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color: grey" href="viewAttendance.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Attendance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totAttendance; ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fa-solid fa-clipboard-user fa-2x text-secondary"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <!--Row-->
          </div>
          <!-- Attendance Summary -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr style='text-align: center;'>
                        <th>#</th>
                        <th style='text-align: left;'>Subject</th>
                        <th>Total Lecture</th>
                        <th>Total Present</th>
                        <th>Total Absent</th>
                        <th>Percentage %</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php

                      $sn = 0;
                      if ($subject > 0) {
                        while ($rows = $query4->fetch_assoc()) {

                          $num = mysqli_query($conn, "SELECT tblattendance.subjectId FROM tblattendance LEFT JOIN tblstudents ON tblstudents.Id = '$_SESSION[userId]' WHERE tblattendance.rollNumber = tblstudents.rollNumber AND tblattendance.subjectId = '$rows[Id]'")->num_rows;
                          $totalP = mysqli_query($conn, "SELECT tblattendance.status FROM tblattendance LEFT JOIN tblstudents ON tblstudents.Id = '$_SESSION[userId]' WHERE tblattendance.rollNumber = tblstudents.rollNumber AND tblattendance.subjectId = '$rows[Id]' AND tblattendance.status = '1'")->num_rows;
                          $totalA = mysqli_query($conn, "SELECT tblattendance.status FROM tblattendance LEFT JOIN tblstudents ON tblstudents.Id = '$_SESSION[userId]' WHERE tblattendance.rollNumber = tblstudents.rollNumber AND tblattendance.subjectId = '$rows[Id]' AND tblattendance.status = '0'")->num_rows;
                          if (($totalP + $totalA) == 0) {
                            $per = 0;
                          } else {
                            $per = round(($totalP / ($totalP + $totalA)) * 100,2);
                          }

                          if ($per > 60) {
                            $colour = "#00FF00";
                          } else if ($per > 30 && $per <= 60) {
                            $colour = " #FFA500";
                          } else if ($per <= 30) {
                            $colour = "#FF0000";
                          }
                          $sn = $sn + 1;
                          echo "
                              <tr style='text-align: center;'>
                                <td>" . $sn . "</td>
                                <td style='text-align: left;'>" . $rows['subjectName'] . "</td>
                                <td>" . $num . "</td>
                                <td>" . $totalP . "</td>
                                <td>" . $totalA . "</td>
                                <td><div class='d-flex align-items-center justify-content-center' style='background-color:" . $colour . "; height: 2.3rem; clip-path: circle(); font-size: 0.6rem; color: white; font-weight: bold;'>" . $per . "% " . "</div></td>
                              </tr>";
                        }
                      } else {
                        echo
                        "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Attendance Summary -->
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <?php include 'includes/footer.php'; ?>
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

</body>

</html>