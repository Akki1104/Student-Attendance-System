<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';

//------------------------SAVE--------------------------------------------------
  
if (isset($_POST['save'])) {

  $branchId = $_POST['branchId'];
  $yearId = $_POST['yearId'];
  $sessionName = $_POST['sessionName'];
  $termId = $_POST['termId'];
  $dateCreated = date("Y-m-d");

  $query = mysqli_query($conn, "select * from tblsessionterm where sessionName ='$sessionName' and termId = '$termId' and branchId = '$branchId' and yearId = '$yearId'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' role='alert'>This Session and Term Already Exists!</div>";
  } else {

    $query = mysqli_query($conn, "insert into tblsessionterm(sessionName,termId,branchId,yearId,isAdActive,isCtActive,dateCreated) value('$sessionName','$termId','$branchId','$yearId','0','0','$dateCreated')");

    if ($query) {

      $statusMsg = "<div class='alert alert-success' role='alert'>Created Successfully!</div>";
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
    }
  }
}

//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "select * from tblsessionterm where Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $branchId = $_POST['branchId'];
    $yearId = $_POST['yearId'];
    $sessionName = $_POST['sessionName'];
    $termId = $_POST['termId'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn, "update tblsessionterm set sessionName='$sessionName',termId='$termId',branchId='$branchId',yearId='$yearId',isAdActive='0',isCtActive='0' where Id='$Id'");

    if ($query) {

      echo "<script>
                window.location = (\"createSessionTerm.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
    }
  }
}


//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "DELETE FROM tblsessionterm WHERE Id='$Id'");

  if ($query == TRUE) {

    echo "<script>
                window.location = (\"createSessionTerm.php\")
                </script>";
  } else {

    $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
  }
}

//--------------------------------ACTIVATE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "activate") {
  $Id = $_GET['Id'];
  $que = mysqli_query($conn, "update tblsessionterm set isAdActive='1' where Id='$Id'");

  if ($que) {
    echo "<script>
              window.location = (\"createSessionTerm.php\")
            </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
  }
}

//--------------------------------DEACTIVATE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "deactivate") {
  $Id = $_GET['Id'];
  $query = mysqli_query($conn, "update tblsessionterm set isAdActive='0' where Id='$Id'");

  if ($query) {
    echo "<script>
              window.location = (\"createSessionTerm.php\")
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
            <h1 class="h3 mb-0 text-gray-800">Create Session and Sesmester</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Session and Semester</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Session and Semester</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Branch<span class="text-danger ml-2">*</span></label>
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
                        <label class="form-control-label">Session Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" minlength="6"  maxlength="20" name="sessionName" value="<?php echo $row['sessionName']; ?>" placeholder="Enter Session Name">
                      </div>
                    </div>
                    <?php
                    if (isset($Id)) {
                    ?>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <button type="submit" name="cancel" onclick="javascript:window.location='createSessionTerm.php'" class="btn btn-primary">Cancel</button>
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
                      <h6 class="m-0 font-weight-bold text-primary">All Session and Semester</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Session</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Activate</th>
                            <th>Deactivate</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>

                        <tbody>

                          <?php
                          $query = "SELECT tblsessionterm.Id,tblsessionterm.sessionName,tblsessionterm.isAdActive,tblsessionterm.dateCreated,
                      tblterm.termName,tblbranch.branchName,tblyear.yearName
                      FROM tblsessionterm
                      INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                      INNER JOIN tblbranch ON tblbranch.Id = tblsessionterm.branchId
                      INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId ORDER BY tblsessionTerm.dateCreated DESC";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          if ($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              if ($rows['isAdActive'] == '1') {
                                $status = "Active";
                                $colour = "#00FF00";
                              } else {
                                $status = "InActive";
                                $colour = "#FF0000";
                              }
                              $sn = $sn + 1;
                              echo "
                              <tr aria-haspopup='true' aria-expanded='false'>
                                <td>" . $sn . "</td>
                                <td>" . $rows['sessionName'] . "</td>
                                <td>" . $rows['branchName'] . "</td>
                                <td>" . $rows['yearName'] . "</td>
                                <td>" . $rows['termName'] . "</td>
                                <td style='background-color:" . $colour . "'>" . $status . "</td>
                                <td>" . $rows['dateCreated'] . "</td>
                                <td><a href='?action=activate&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-check'></i></a></td>
                                <td><a href='?action=deactivate&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-x'></i></a></td>
                                <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i></a></td>
                                <td><a href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i></a></td>
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