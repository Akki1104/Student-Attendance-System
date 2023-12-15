<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = mysqli_query($conn, "SELECT * from tblstudents
INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
INNER JOIN tblbranch On tblbranch.Id = '$_SESSION[branchId]'
INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId
WHERE tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1'");
$rrw = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../img/logo/attnlg.jpg" rel="icon">
  <title>AMS | View Students</title>
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
            <h1 class="h3 mb-0 text-gray-800">All Student in (<?php echo $rrw['branchName'] . ' - ' . $rrw['yearName']; ?>) Class</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Student in Class</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->


              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">All Student In Class</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Roll Number</th>
                            <th>Phone Number</th>
                            <th>Branch</th>
                            <th>Year</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php
                          $query = "SELECT tblstudents.Id AS Id,tblbranch.branchName AS branchName,tblyear.yearName AS yearName,tblyear.Id AS yearId,tblstudents.firstName AS firstName,tblstudents.lastName AS lastName,tblstudents.phoneNo AS phoneNo,tblstudents.rollNumber AS rollNumber
                      FROM tblstudents
                      INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
                      INNER JOIN tblbranch ON tblbranch.Id = '$_SESSION[branchId]'
                      INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId 
                      WHERE tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1' AND tblstudents.sessionTermId = tblsessionTerm.Id ORDER BY tblStudents.firstName ASC";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          $status = "";
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