<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';
//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $dob = $_POST['dateOfBirth'];
  $phoneNo = $_POST['phoneNo'];
  $rollNumber = $_POST['rollNumber'];
  $branchId = $_POST['branchId'];
  $yearId = $_POST['yearId'];
  $sessionTermId = $_POST['sessionTermId'];
  $dateCreated = date("Y-m-d");

  $query1 = mysqli_query($conn, "select * from tblstudents where rollNumber ='$rollNumber' ");
  $ret = mysqli_fetch_array($query1);

  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' role='alert'>This Student's Details Already Exists!</div>";
  } else {

    $query2 = mysqli_query($conn, "insert into tblstudents(firstName,lastName,phoneNo,rollNumber,branchId,yearId,sessionTermId,dateOfBirth,dateCreated) 
    value('$firstName','$lastName','$phoneNo','$rollNumber','$branchId','$yearId','$sessionTermId','$dob','$dateCreated')");

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

  $query3 = mysqli_query($conn, "select * from tblstudents where Id ='$Id'");
  $row = mysqli_fetch_array($query3, MYSQLI_ASSOC);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dateOfBirth'];
    $phoneNo = $_POST['phoneNo'];
    $rollNumber = $_POST['rollNumber'];
    $branchId = $_POST['branchId'];
    $yearId = $_POST['yearId'];
    $sessionTermId = $_POST['sessionTermId'];
    $dateCreated = date("Y-m-d");

    $query4 = mysqli_query($conn, "update tblstudents set firstName='$firstName', lastName='$lastName',phoneNo='$phoneNo',rollNumber='$rollNumber', branchId='$branchId',yearId='$yearId',sessionTermId='$sessionTermId',dateOfBirth='$dob',dateCreated = '$dateCreated' where Id='$Id'");
    if ($query4) {
      $statusMsg = "<div class='alert alert-success' role='alert'>Updated Successfully!</div>";
      header("location: createStudents.php?message=$statusMsg");
    } else {
      $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
    }
  }
}

//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query5 = mysqli_query($conn, "DELETE FROM tblstudents WHERE Id='$Id'");

  if ($query5 == TRUE) {
    $statusMsg = "<div class='alert alert-danger' role='alert'>Deleted Successfully!</div>";
    header("location: createStudents.php?message=$statusMsg");
  } else {
    $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
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
  <title>AMS | Create Students</title>
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
    //Function Call For ajaxSessionTermDrop.php file
    function sessionDrop(str) {
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
        xmlhttp.open("GET", "ajaxSessionTermDrop.php?cid=" + str, true);
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
            <h1 class="h3 mb-0 text-gray-800">Create Students</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Students</li>
              <li class="breadcrumb-item" aria-current="page"><a href="viewStudents.php">View Students</a></li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Students</h6>
                  <?php if (isset($_GET['message']) && !empty($_GET['message'])) {
                    echo $_GET['message'];
                  }
                  echo $statusMsg;
                  ?>
                </div>
                <div class="card-body">
                  <form method="Post" action="createStudents.php">
                    <div class="form-row">
                      <div class="col-md-4 mb-3">
                        <label class="form-control-label">First Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="firstName" maxlength="32" pattern="^[A-Za-z]{1,32}$" title="Please enter a valid first name containing only letters" placeholder="Enter First Name" value="<?php echo $row['firstName'] ?>">
                      </div>
                      <div class="col-md-4 mb-3">
                        <label class="form-control-label">Last Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="lastName" maxlength="32" pattern="^[A-Za-z ]{1,32}$" title="Please enter a valid last name containing only letters" placeholder="Enter Last Name" value="<?php echo $row['lastName'] ?>">
                      </div>
                      <div class="col-md-4 mb-3">
                        <label class="form-control-label">Date Of Birth<span class="text-danger ml-2">*</span></label>
                        <input type="date" class="form-control" required name="dateOfBirth" max="<?php echo date("Y-m-d") ?>" value="<?php echo $row['dateOfBirth'] ?>">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Phone Number<span class="text-danger ml-2">*</span></label>
                        <input type="tel" pattern="[6789]{1}[0-9]{9}" title="Please enter valid phone number" maxlength="10" class="form-control" required name="phoneNo" placeholder="Enter Phone Number" value="<?php echo $row['phoneNo'] ?>">
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Roll Number<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" pattern="[0-9]{9,30}" title="Please enter a valid roll number" maxlength="30" required name="rollNumber" placeholder="Enter Roll Number" value="<?php echo $row['rollNumber'] ?>">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Branch<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qry = "SELECT * FROM tblbranch ORDER BY branchName ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;
                        if ($num > 0) {
                          echo ' <select required name="branchId" onchange="yearDrop(this.value)" class="form-control mb-3">';
                          echo '<option value="">--Select Branch--</option>';
                          while ($rowss = $result->fetch_assoc()) {
                            echo '<option value="' . $rowss['Id'] . '" >' . $rowss['branchName'] . '</option>';
                          }
                          echo '</select>';
                        }
                        ?>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Year<span class="text-danger ml-2">*</span></label>
                        <?php
                        echo "<div id='txtHint'></div>";
                        ?>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Semester<span class="text-danger ml-2">*</span></label>
                        <?php
                        echo "<div id='txtHint2'></div>";
                        ?>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Session<span class="text-danger ml-2">*</span></label>
                        <?php
                        echo "<div id='txtHint3'></div>";
                        ?>
                      </div>
                    </div>
                    <?php
                    if (isset($Id)) {
                    ?>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <button type="submit" name="cancel" onclick="javascript:window.location='createStudents.php'" class="btn btn-primary">Cancel</button>
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
                      <h6 class="m-0 font-weight-bold text-primary">All Student</h6>
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
                            <th>Date Created</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $query = "SELECT tblstudents.Id AS Id,tblbranch.branchName AS branchName,tblyear.yearName AS yearName,tblyear.Id AS yearId,tblstudents.firstName AS firstName,tblstudents.lastName AS lastName,tblstudents.phoneNo AS phoneNo,tblstudents.rollNumber AS rollNumber,tblstudents.dateCreated AS dateCreated FROM tblstudents 
                          INNER JOIN tblbranch ON tblbranch.Id = tblstudents.branchId 
                          INNER JOIN tblyear ON tblyear.Id = tblstudents.yearId 
                          INNER JOIN tblsessionTerm ON tblsessionTerm.Id = tblstudents.sessionTermId WHERE tblsessionterm.isAdActive = '1' ORDER BY tblstudents.firstName ASC";
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
                              echo '</td>  
                                <td>' . $rows['rollNumber'] . '</td>
                                <td>' . $rows['phoneNo'] . '</td>
                                <td>' . $rows['branchName'] . '</td>
                                <td>' . $rows['yearName'] . '</td>
                                 <td>' . $rows['dateCreated'] . '</td>
                                <td><a href="?action=edit&Id=' . $rows['Id'] . '"><i class="fas fa-fw fa-edit"></i></a></td>
                                <td><a href="?action=delete&Id=' . $rows['Id'] . '"><i class="fas fa-fw fa-trash"></i></a></td>
                              </tr>';
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
            <!-- Row -->
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