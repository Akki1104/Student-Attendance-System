<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';

$query = "SELECT tblstudents.branchId AS branchId, tblstudents.yearId AS yearId, tblsessionterm.Id AS sessionTermId
FROM tblstudents
INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
INNER JOIN tblbranch ON tblbranch.Id = '$_SESSION[branchId]'
INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId
WHERE tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1' ORDER BY tblStudents.firstName ASC";
$rs = $conn->query($query);
$rows = $rs->fetch_assoc();

$dateTaken = date("Y-m-d");

//------------------------SAVE--------------------------------------------------
if (isset($_POST['save'])) {

  $subjectId = $_POST['subjectId'];

  $qurty = mysqli_query($conn, "select * from tblattendance  where branchId = '$rows[branchId]' and yearId = '$rows[yearId]' and dateTimeTaken='$dateTaken' and sessionTermId = '$rows[sessionTermId]' and subjectId = '$subjectId'");
  $count = mysqli_num_rows($qurty);

  if ($count == 0) { //if Record does not exsit, insert the new record
    $qus = mysqli_query($conn, "select * from tblstudents  where branchId = '$rows[branchId]' and yearId = '$rows[yearId]' and sessionTermId = '$rows[sessionTermId]'");
    while ($ros = $qus->fetch_assoc()) {
      $qquery = mysqli_query($conn, "insert into tblattendance(rollNumber,branchId,yearId,sessionTermId,subjectId,status,dateTimeTaken)
              value('$ros[rollNumber]','$rows[branchId]','$rows[yearId]','$rows[sessionTermId]','$subjectId','0','$dateTaken')");
    }
  }

  $rollNumber = $_POST['rollNumber'];
  $check = $_POST['check'];
  $N = count($rollNumber);

  //check if the attendance has not been taken i.e if no record has a status of 1
  $qurty = mysqli_query($conn, "select * from tblattendance  where branchId = '$rows[branchId]' and yearId = '$rows[yearId]' and dateTimeTaken='$dateTaken' and sessionTermId = '$rows[sessionTermId]' and subjectId = '$subjectId' and status = '1'");
  $count = mysqli_num_rows($qurty);

  if ($count > 0) {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Attendance has been taken for today!</div>";
  } else //update the status to 1 for the checkboxes checked
  {
    for ($i = 0; $i < $N; $i++) {
      $rollNumber[$i]; //roll Number

      if (isset($check[$i])) //the checked checkboxes
      {
        $qquery = mysqli_query($conn, "update tblattendance set status='1' where rollNumber = '$check[$i]' and sessionTermId = '$rows[sessionTermId]' and subjectId = '$subjectId' and dateTimeTaken = '$dateTaken'");
      }
    }
    if ($qquery) {
      $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Attendance Taken Successfully!</div>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//------------------------UPDATE--------------------------------------------------

if (isset($_POST['update'])) {

  $subjectId = $_POST['subjectId'];
  $rollNumber = $_POST['rollNumber'];
  $check = $_POST['check'];
  $N = count($rollNumber);

  //update the status to 1 for the checkboxes checked
  for ($i = 0; $i < $N; $i++) {
    $rollNumber[$i]; //roll Number

    if (isset($check[$i])) //the checked checkboxes
    {
      $qquery = mysqli_query($conn, "update tblattendance set status='1' where rollNumber = '$check[$i]' and sessionTermId = '$rows[sessionTermId]' and subjectId = '$subjectId' and dateTimeTaken = '$dateTaken'");

      if ($qquery) {

        $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Attendance Updated Successfully!</div>";
      } else {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
      }
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
  <title>AMS | Take Attendance</title>
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
            <h1 class="h3 mb-0 text-gray-800">Take Attendance (Today's Date : <?php echo $todaysDate = date("d-m-Y"); ?>)</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Take Attendance</li>
              <li class="breadcrumb-item" aria-current="page"><a href="viewAttendance.php">Class Attendance</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="viewStudentAttendance.php">Student Attendence</a></li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <!-- Form Basic -->
                <form method="post">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">All Student in Class</h6>
                    <h6 class="m-0 font-weight-bold text-danger">Note: <i>Click on the checkboxes besides each student to take attendance!</i></h6>
                  </div>
                  <div class="table-responsive p-3">
                    <div class="py-3 d-flex align-items-center justify-content-between">
                      <?php echo $statusMsg; ?>
                    </div>
                    <div class="col-xl-3">
                      <label class="form-control-label">Subject<span class="text-danger ml-2">*</span></label>
                      <?php
                      $qury = "SELECT tblsubject.Id As Id, tblsubject.subjectName AS subjectName from tblsubject
                                INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
                                WHERE tblsubject.teacherId = '$_SESSION[userId]' AND tblsubject.yearId = tblsessionterm.yearId AND tblsessionterm.termId = tblsubject.termId AND tblsessionterm.isCtActive = '1'";
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
                    <table class="table align-items-center table-flush table-hover">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Roll Number</th>
                          <th>Check</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT *
                        FROM tblstudents
                        INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
                        WHERE tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.Id = tblstudents.sessionTermId AND tblsessionterm.isCtActive = '1' ORDER BY tblStudents.rollNumber ASC";
                        $rs = $conn->query($query);
                        $num = $rs->num_rows;
                        $sn = 0;
                        $status = "";
                        if ($num > 0) {
                          while ($row = $rs->fetch_assoc()) {
                            $sn = $sn + 1;
                            echo "
                                 <tr>
                                   <td>" . $sn . "</td>
                                   <td>" . $row['firstName'] . ' ' . $row['lastName'] . "</td>
                                   <td>" . $row['rollNumber'] . "</td>
                                   <td><input name='check[]' type='checkbox' value=" . $row['rollNumber'] . " class='form-control'></td>
                                 </tr>";
                            echo "<input name='rollNumber[]' value=" . $row['rollNumber'] . " type='hidden' class='form-control'>";
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
                    <br>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <button type="submit" name="save" class="btn btn-primary">Take Attendance</button>
                      <button type="submit" name="update" class="btn btn-warning">Update Attendance</button>
                    </div>
                  </div>
                </form>
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