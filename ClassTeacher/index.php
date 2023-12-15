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
          <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
          <!-- Row -->
          <div class="row mb-3">
            <!-- Students Card -->
            <?php
            $query1 = mysqli_query($conn, "SELECT * from tblstudents
            INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId
            WHERE tblsessionterm.branchId = '$_SESSION[branchId]' 
            AND tblsessionterm.yearId = tblstudents.yearId AND tblstudents.sessionTermId = tblsessionterm.Id AND tblsessionterm.isCtActive = '1'");
            $students = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="viewStudents.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Students</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php
                                                                                  if ($students < 0) {
                                                                                    echo ' ';
                                                                                  } else {
                                                                                    echo $students;
                                                                                  } ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-info"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <!-- Branch Card -->
            <?php
            $query2 = mysqli_query($conn, "SELECT tblbranch.branchName
FROM tblclassteacher
INNER JOIN tblbranch ON tblbranch.Id = tblclassteacher.branchId
WHERE tblclassteacher.Id = '$_SESSION[userId]'");
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
            $query3 = mysqli_query($conn, "SELECT * from tblstudents
INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId
INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId
WHERE tblsessionterm.branchId = '$_SESSION[branchId]' 
AND tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1'");
            $year = $query3->fetch_assoc();
            $num = $query3->num_rows;
            ?>
            <!-- Year Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Year</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($num > 0) {
                                                                            echo $year['yearName'];
                                                                          } else {
                                                                            echo " ";
                                                                          } ?></div>
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
            $query4 = mysqli_query($conn, "SELECT * from tblstudents
INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId
INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
WHERE tblsessionterm.branchId = '$_SESSION[branchId]' 
AND tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1'");
            $sem = $query4->fetch_assoc();
            $num = $query3->num_rows;
            ?>
            <!-- Semester Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="viewSessionTerm.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Semester</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($num > 0) {

                                                                              echo $sem['termName'];
                                                                            } else {
                                                                              echo " ";
                                                                            } ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-code fa-2x text-info"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <?php
            $query4 = mysqli_query($conn, "SELECT * from tblsubject
INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
WHERE tblsubject.teacherId = '$_SESSION[userId]' AND tblsubject.yearId = tblsessionterm.yearId 
AND tblsubject.termId = tblsessionTerm.termId AND tblsessionterm.isCtActive = '1'");
            $subject = mysqli_num_rows($query4);
            ?>
            <!-- Subjects Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Subject</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $subject; ?></div>
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
            $query5 = mysqli_query($conn, "SELECT *
FROM tblattendance
INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
INNER JOIN tblsubject ON tblsubject.teacherId = '$_SESSION[userId]'
WHERE tblattendance.branchId = tblsessionterm.branchId and tblattendance.yearId = tblsessionterm.yearId AND tblattendance.subjectId = tblsubject.Id AND tblsessionterm.isCtActive = '1' AND tblattendance.status = '1'");
            $totAttendance = mysqli_num_rows($query5);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="viewAttendance.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Student Attendance</div>
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

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
</body>

</html>