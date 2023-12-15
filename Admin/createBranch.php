<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $branchName = $_POST['branchName'];
  $year = $_POST['Year'];

  $query1 = mysqli_query($conn, "select * from tblbranch where branchName ='$branchName'");
  $ret = mysqli_fetch_array($query1);

  //check for any existing branch data
  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' role='alert'>This Branch Already Exists!</div>";
  }
  //for inserting Branch, Years and Terms
  else {

    $query2 = mysqli_query($conn, "insert into tblbranch(branchName) value('$branchName')");
    $rrt = mysqli_query($conn, "select * from tblbranch where branchName = '$branchName'")->fetch_assoc();
    if ($year == '1') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$rrt[Id]','First')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'First'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','First'),('$rrts[Id]','Second')");
    }
    if ($year == '2') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$rrt[Id]','First'),('$rrt[Id]','Second')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'First'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','First'),('$rrts[Id]','Second')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'Second'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','Third'),('$rrts[Id]','Fourth')");
    }
    if ($year == '3') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$rrt[Id]','First'),('$rrt[Id]','Second'),('$rrt[Id]','Third')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'First'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','First'),('$rrts[Id]','Second')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'Second'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','Third'),('$rrts[Id]','Fourth')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','Fifth'),('$rrts[Id]','Sixth')");
    }
    if ($year == '4') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$rrt[Id]','First'),('$rrt[Id]','Second'),('$rrt[Id]','Third'),('$rrt[Id]','Fourth')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'First'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','First'),('$rrts[Id]','Second')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'Second'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','Third'),('$rrts[Id]','Fourth')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','Fifth'),('$rrts[Id]','Sixth')");
      $rrts = mysqli_query($conn, "select * from tblyear where branchId = '$rrt[Id]' and yearName = 'Fourth'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrts[Id]','Seventh'),('$rrts[Id]','Eighth')");
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>Maximum Number Reached</div>";
    }

    if ($query2) {

      $statusMsg = "<div class='alert alert-success' role='alert'>Created Successfully!</div>";
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
    }
  }
}

//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query1 = mysqli_query($conn, "select * from tblbranch where Id ='$Id'");
  $row = mysqli_fetch_array($query1);
  $query2 = mysqli_query($conn, "select * from tblyear where tblyear.branchId='$Id'");
  $rr = $query2->num_rows;

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $branchName = $_POST['branchName'];
    $year = $_POST['Year'];
    $query3 = mysqli_query($conn, "update tblbranch set branchName='$branchName' where Id='$Id'");

    //for deleting Years and Terms when edit in the number of years
    if ($year == '1' && $rr >= '2') {
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Second'")->fetch_assoc();
      mysqli_query($conn, "DELETE FROM tblterm WHERE  yearId = '$rrs[Id]'");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "DELETE FROM tblterm WHERE yearId = '$rrs[Id]'");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Fourth'")->fetch_assoc();
      mysqli_query($conn, "DELETE FROM tblterm WHERE yearId = '$rrs[Id]'");
      mysqli_query($conn, "DELETE FROM tblyear WHERE branchId = '$Id' AND yearName IN ('Second', 'Third', 'Fourth')");
    } else if ($year == '2' && $rr >= '3') {
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "DELETE FROM tblterm WHERE yearId = '$rrs[Id]'");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Fourth'")->fetch_assoc();
      mysqli_query($conn, "DELETE FROM tblterm WHERE yearId = '$rrs[Id]'");
      mysqli_query($conn, "DELETE FROM tblyear WHERE branchId = '$Id' AND yearName IN ('Third', 'Fourth')");
    } else if ($year == '3' && $rr >= '4') {
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Fourth'")->fetch_assoc();
      mysqli_query($conn, "DELETE FROM tblterm WHERE yearId = '$rrs[Id]'");
      mysqli_query($conn, "DELETE FROM tblyear WHERE branchId = '$Id' AND yearName = 'Fourth'");
    }
    //for adding Years and Terms when edit in the number of years
    if ($year == '2' && $rr == '1') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$Id','Second')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Second'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Third'),('$rrs[Id]','Fourth')");
    } else if ($year == '3' && $rr == '1') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$Id','Second'),('$Id','Third')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Second'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Third'),('$rrs[Id]','Fourth')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Fifth'),('$rrs[Id]','Sixth')");
    } else if ($year == '3' && $rr == '2') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$Id','Third')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Fifth'),('$rrs[Id]','Sixth')");
    } else if ($year == '4' && $rr == '1') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$Id','Second'),('$Id','Third'),('$Id','Fourth')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Second'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Third'),('$rrs[Id]','Fourth')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Fifth'),('$rrs[Id]','Sixth')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Fourth'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Seventh'),('$rrs[Id]','Eigth')");
    } else if ($year == '4' && $rr == '2') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$Id','Third'),('$Id','Fourth')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Third'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Fifth'),('$rrs[Id]','Sixth')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Fourth'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Seventh'),('$rrs[Id]','Eigth')");
    } else if ($year == '4' && $rr == '3') {
      mysqli_query($conn, "insert into tblyear(branchId,yearName) values('$Id','Fourth')");
      $rrs = mysqli_query($conn, "select * from tblyear where branchId = '$Id' and yearName = 'Fourth'")->fetch_assoc();
      mysqli_query($conn, "insert into tblterm(yearId,termName) values('$rrs[Id]','Seventh'),('$rrs[Id]','Eigth')");
    }

    if ($query3) {

      echo "<script>
                window.location = (\"createBranch.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
    }
  }
}

//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "SELECT * FROM tblyear WHERE branchId = '$Id'");
  while ($rr = $query->fetch_assoc()) {
    mysqli_query($conn, "DELETE FROM tblterm WHERE yearId = '$rr[Id]'");
  }
  $query2 = mysqli_query($conn, "DELETE FROM tblyear WHERE branchId = '$Id'");
  $query1 = mysqli_query($conn, "DELETE FROM tblbranch WHERE Id='$Id'");

  if ($query1 == TRUE && $query2 == TRUE) {

    echo "<script>
                window.location = (\"createbranch.php\")
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
  <link href="../img/logo/attnlg.jpg" rel="icon">
  <title>AMS | Branch</title>
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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Branch</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Branch</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Branch</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Branch Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" pattern="^[A-Za-z0-9 ]{1,32}$" title="Please enter a valid name" name="branchName" value="<?php echo $row['branchName']; ?>" placeholder="Enter Branch Name" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Number Of Years<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" pattern="^[1234]{1}$" maxlength="1" title="Please enter upto 4 years" name="Year" value="<?php echo $rr; ?>" placeholder="Enter Number Of Years" required>
                      </div>
                    </div>
                    <?php
                    if (isset($Id)) {
                    ?>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <button type="submit" name="cancel" onclick="javascript:window.location='createbranch.php'" class="btn btn-primary">Cancel</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    } else {
                    ?>
                      <button type="submit" name="save" class="btn btn-primary">Save</button>
                    <?php
                    }
                    ?>
                  </form>
                </div>
              </div>
              <!-- Input Group -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">All Branches</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Branch Name</th>
                            <th>Years</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $query = "SELECT * FROM tblbranch ORDER BY branchName ASC";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          if ($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              $sn = $sn + 1;
                              echo "
                              <tr>
                                <td>" . $sn . "</td>
                                <td>" . $rows['branchName'] . "</td>
                                <td>" . mysqli_query($conn, "SELECT * FROM tblyear WHERE branchId='$rows[Id]'")->num_rows . "</td>
                                <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                                <td><a href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i>Delete</a></td>
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