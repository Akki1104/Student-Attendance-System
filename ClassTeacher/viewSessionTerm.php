<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//--------------------------------ACTIVATE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "activate") {
  $Id = $_GET['Id'];
  $que = mysqli_query($conn, "update tblsessionterm set isCtActive='1' where Id='$Id'");

  if ($que) {
    echo "<script>
              window.location = (\"viewSessionTerm.php\")
            </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
  }
}

//--------------------------------DEACTIVATE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "deactivate") {
  $Id = $_GET['Id'];
  $query = mysqli_query($conn, "update tblsessionterm set isCtActive='0' where Id='$Id'");

  if ($query) {
    echo "<script>
              window.location = (\"viewSessionTerm.php\")
              </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
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
  <title>AMS | Session & Semester</title>
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
            <h1 class="h3 mb-0 text-gray-800">Session and Sesmester</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Session and Semester</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">All Session and Semester</h6>
                      <h6 class="m-0 font-weight-bold text-danger">Note: <i>Click on the check symbol besides each to make session and smester active!</i></h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr style='text-align: center;'>
                            <th>#</th>
                            <th>Session</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Activate</th>
                            <th>Deactivate</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php
                          $querys = "SELECT tblsessionterm.Id,tblsessionterm.sessionName,tblsessionterm.isCtActive,tblsessionterm.dateCreated,
                      tblterm.termName,tblyear.yearName
                      FROM tblsessionterm
                      INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                      INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId
                      WHERE tblsessionterm.branchId = '$_SESSION[branchId]' ORDER BY tblterm.Id";
                          $rs = $conn->query($querys);
                          $num = $rs->num_rows;
                          $sn = 0;
                          if ($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              if ($rows['isCtActive'] == '1') {
                                $status = "Active";
                                $colour = "#00FF00";
                              } else {
                                $status = "InActive";
                                $colour = "#FF0000";
                              }
                              $sn = $sn + 1;
                              echo "
                              <tr style='text-align: center;'>
                                <td>" . $sn . "</td>
                                <td>" . $rows['sessionName'] . "</td>
                                <td>" . $rows['yearName'] . "<td
                                <td>" . $rows['termName'] . "</td>
                                <td style='background-color:" . $colour . "'>" . $status . "</td>
                                <td>" . $rows['dateCreated'] . "</td>
                                 <td><a href='?action=activate&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-check'></i></a></td>
                                 <td><a href='?action=deactivate&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-x'></i></a></td>
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