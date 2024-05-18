<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';

//------------------------SAVE--------------------------------------------------
if (isset($_POST['save'])) {
  $branchId = $_POST['branchId'];
  $yearId = $_POST['yearId'];
  $termId = $_POST['termId'];
  $NS = $_POST['noSubject'];
  $subjects = $_POST['subject'];
  $count = 0;

  for ($i = 0; $i < $NS; $i++) {
    $qurty = mysqli_query($conn, "select * from tblsubject where branchId = '$branchId' and yearId = '$yearId' and termId = '$termId' and subjectName = '$subjects[$i]'");
    if (mysqli_num_rows($qurty) > 0) {
      $count = $count + 1;
    }
  }

  //Checking for already existing subject in particular branch, year and term
  if ($count > 0) {
    $statusMsg = "<div class='alert alert-danger' role='alert'>" . $count . " Subject Already Exists!</div>";
  } else {
    for ($i = 0; $i < $NS; $i++) {
      if (isset($subjects[$i])) {
        $query = mysqli_query($conn, "insert into tblsubject(branchId,yearId,termId,subjectName) values('$branchId','$yearId','$termId','$subjects[$i]')");

        if ($query) {

          $statusMsg = "<div class='alert alert-success' role='alert'>Created Successfully!</div>";
        } else {
          $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
        }
      }
    }
  }
}

//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query1 = mysqli_query($conn, "select * from tblsubject where Id ='$Id'");
  $row = mysqli_fetch_array($query1);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $branchId = $_POST['branchId'];
    $yearId = $_POST['yearId'];
    $termId = $_POST['termId'];
    $subject = $_POST['subject'];

    $queryy = mysqli_query($conn, "update tblsubject set branchId = '$branchId', yearId = '$yearId', termId = '$termId', subjectName = '$subject' where Id = '$Id'");

    if ($queryy) {

      echo "<script>
              window.location = (\"createSubject.php\")
              </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
    }
  }
}


//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query2 = mysqli_query($conn, "DELETE FROM tblsubject WHERE Id = '$Id'");

  if ($query2 == TRUE) {

    echo "<script>
              window.location = (\"createSubject.php\")
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
  <title>AMS | Subject</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
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
    //Function Call For ajaxSubjectNoDrop.php file
    function subjectNoDrop(str) {
      if (str == "") {
        document.getElementById("txtHint3").innerHTML = "";
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
            document.getElementById("txtHint3").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxSubjectNoDrop.php?cid=" + str, true);
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
            <h1 class="h3 mb-0 text-gray-800">Create Subject</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Subject</li>
              <li class="breadcrumb-item" aria-current="page"><a href="allocateSubject.php">Allocate Subject</a></li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Subject</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Branch<span class="text-danger ml-2">*</span></label>
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
                      <?php
                      if (isset($Id)) {
                      ?>
                        <div class="mb-3 col-xl-6">
                          <label class="form-control-label">Subject<span class="text-danger ml-2">*</span></label>
                          <input type="text" class="form-control" pattern="^[A-Za-z0-9 ]{1,100}$" title="Please enter a valid name" name="subject" value="<?php echo $row['subjectName']; ?>" placeholder="Enter Subject Name">
                        </div>
                    </div>
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" name="cancel" onclick="javascript:window.location='createSubject.php'" class="btn btn-primary">Cancel</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                      } else {
                  ?>
                    <div class="col-xl-6">
                      <label class="form-control-label">Number Of Subjects<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" pattern="[0-9]{1,20}" onkeyup="subjectNoDrop(this.value)" name="noSubject" placeholder="Number Of Subjects" required>
                    </div>
                </div>
                <?php
                        echo "<div id='txtHint3'></div>";
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
                    <h6 class="m-0 font-weight-bold text-primary">All Subjects</h6>
                  </div>
                  <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th>
                          <th>Subject</th>
                          <th>Branch</th>
                          <th>Year</th>
                          <th>Semester</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>

                      <tbody>

                        <?php
                        $query = "SELECT tblsubject.Id AS Id, tblsubject.subjectName AS subjectName, tblbranch.branchName AS branchName, tblyear.yearName AS yearName, tblterm.termName AS termName 
                      FROM tblsubject 
                      INNER JOIN tblbranch ON tblbranch.Id = tblsubject.branchId
                      INNER JOIN tblyear ON tblyear.Id = tblsubject.yearId
                      INNER JOIN tblterm ON tblterm.Id = tblsubject.termId 
                      ORDER BY tblsubject.termId ASC";
                        $rs = $conn->query($query);
                        $num = $rs->num_rows;
                        $sn = 0;
                        if ($num > 0) {
                          while ($rows = $rs->fetch_assoc()) {
                            $sn = $sn + 1;
                            echo "
                              <tr>
                                <td>" . $sn . "</td>
                                <td>" . $rows['subjectName'] . "</td>
                                <td>" . $rows['branchName'] . "</td>
                                <td>" . $rows['yearName'] . "</td>
                                <td>" . $rows['termName'] . "</td>
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