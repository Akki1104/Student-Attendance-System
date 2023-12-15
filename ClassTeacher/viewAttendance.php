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
  <title>AMS | Class Attendance</title>
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
            <h1 class="h3 mb-0 text-gray-800">View Class Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="takeAttendance.php">Take Atttendance</a></li>
              <li class="breadcrumb-item active" aria-current="page">Class Attendance</li>
              <li class="breadcrumb-item" aria-current="page"><a href="viewStudentAttendance.php">Student Attendence</a></li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">View Class Attendance</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post" action="viewAttendance.php">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Start Date<span class="text-danger ml-2">*</span></label>
                        <input type="date" max="<?php echo date("Y-m-d"); ?>" class="form-control" name="dateTaken1">
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Select End Date<span class="text-danger ml-2">*</span></label>
                        <input type="date" max="<?php echo date("Y-m-d"); ?>" class="form-control" name="dateTaken2">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
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
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>
              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Class Attendance</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr style="text-align: center;">
                            <th>#</th>
                            <th style='text-align: left;'>Name</th>
                            <th>Roll Number</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Present</th>
                            <th>Absent</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_POST['view'])) {

                            $fromDate =  $_POST['dateTaken1'];
                            $toDate =  $_POST['dateTaken2'];
                            $subjectId = $_POST['subjectId'];

                            $nums = mysqli_query($conn, "SELECT *
                                FROM tblattendance
                                WHERE tblattendance.dateTimeTaken BETWEEN '$fromDate' AND '$toDate' AND tblattendance.subjectId = '$subjectId'")->num_rows;
                            if ($nums > 0) {

                              $query = "SELECT tblstudents.firstName AS firstName, tblstudents.lastName AS lastName, tblstudents.rollNumber As rollNumber, tblbranch.branchName AS branchName, tblyear.yearName As yearName, tblterm.termName AS termName
                         FROM tblstudents
                         INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
                         INNER JOIN tblbranch ON tblbranch.Id = '$_SESSION[branchId]'
                         INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId
                         INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId 
                         WHERE tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1' ORDER BY tblstudents.firstName ASC";

                              $rs = $conn->query($query);
                              $num = $rs->num_rows;
                              $sn = 0;
                              if ($num > 0) {
                                while ($rows = $rs->fetch_assoc()) {
                                  $sn = $sn + 1;
                                  echo "
                              <tr style='text-align: center;'>
                                <td>" . $sn . "</td>
                                 <td style='text-align: left;'>" . $rows['firstName'] . " " . $rows['lastName'] . "</td>
                                <td>" . $rows['rollNumber'] . "</td>
                                <td>" . $rows['branchName'] . "</td>
                                <td>" . $rows['yearName'] . "</td>
                                <td>" . $rows['termName'] . "</td>
                                <td>" . mysqli_query($conn, "SELECT *
                                FROM tblattendance
                                INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                                where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$rows[rollNumber]' and tblattendance.subjectId = '$subjectId' and tblsessionterm.isCtActive = '1' and tblattendance.status = '1'")->num_rows . "</td>
                                <td>" . mysqli_query($conn, "SELECT *
                                FROM tblattendance
                                INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                                where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$rows[rollNumber]' and tblattendance.subjectId = '$subjectId' and tblsessionterm.isCtActive = '1' and tblattendance.status = '0'")->num_rows . "</td>
                              </tr>";
                                }
                              } else {
                                echo
                                "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
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
                      <?php
                      if (isset($_POST['view'])) {
                        if ($nums > 0) {
                          echo '
                    <form method="post" action="downloadClassRecord.php">
                            <input type="hidden" name="time1" value=' . $_POST['dateTaken1'] . ' class="form-control">
                            <input type="hidden" name="time2" value=' . $_POST['dateTaken2'] . ' class="form-control">
                            <input type="hidden" name="subjectId" value=' . $_POST['subjectId'] . ' class="form-control">
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