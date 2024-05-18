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
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/logo/attnlg.jpg" rel="icon">
  <title>AMS | HOME</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
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
          <!-- Row -->
          <div class="row mb-3">
            <!-- Students Card -->
            <?php
            $query1 = mysqli_query($conn, "SELECT * FROM tblstudents 
            INNER JOIN tblsessionterm ON tblsessionterm.Id = tblstudents.sessionTermId
            WHERE tblsessionterm.isAdActive = '1'");
            $students = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="createStudents.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Students</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $students; ?></div>
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
            $query1 = mysqli_query($conn, "SELECT * FROM tblbranch");
            $branch = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="createBranch.php">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Branches</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $branch; ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-chalkboard fa-2x text-primary"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <?php
            $query3 = mysqli_query($conn, "SELECT * FROM tblyear 
            INNER JOIN tblsessionterm ON tblsessionterm.yearId = tblyear.Id WHERE tblsessionterm.isAdActive = '1'");
            $num = $query3->num_rows;
            ?>
            <!-- Year Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Years</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $num; ?></div>
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
            <!-- Session and Terms Card  -->
            <?php
            $query1 = mysqli_query($conn, "SELECT * FROM tblsessionterm WHERE tblsessionterm.isAdActive = '1'");
            $sessTerm = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="createSessionTerm.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Session & Terms</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sessTerm; ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-warning"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <!-- Terms Card  -->
            <?php
            $query1 = mysqli_query($conn, "SELECT * FROM tblterm INNER JOIN tblsessionterm ON tblsessionterm.termId = tblterm.Id WHERE tblsessionterm.isAdActive = '1'");
            $termonly = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="createSessionTerm.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Semesters</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $termonly; ?></div>
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
            <!-- Teachers Card  -->
            <?php
            $query1 = mysqli_query($conn, "SELECT * FROM tblclassteacher");
            $classTeacher = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="createClassTeacher.php">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Teachers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $classTeacher; ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-danger"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <!-- Subject Card -->
            <?php
            $queryy = mysqli_query($conn, "SELECT * FROM tblsubject INNER JOIN tblsessionterm ON tblsessionterm.termId = tblsubject.termId WHERE tblsessionterm.isAdActive = '1'");
            $subject = mysqli_num_rows($queryy);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a style="text-decoration: none; color:grey" href="createSubject.php">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Subjects</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $subject; ?></div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fa-solid fa-book fa-2x text-primary"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <!-- Attendance Card -->
            <?php
            $query1 = mysqli_query($conn, "SELECT * FROM tblattendance INNER JOIN tblsessionterm ON tblsessionterm.termId = tblattendance.sessionTermId WHERE tblsessionterm.isAdActive = '1' AND tblattendance.status = '1'");
            $totAttendance = mysqli_num_rows($query1);
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
          <!---Container Fluid-->
        </div>
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
  <!-- JQuery and JS links -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
</body>

</html>