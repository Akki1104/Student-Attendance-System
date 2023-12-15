<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
include '../Includes/postDataUnset.php';
//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $emailAddress = $_POST['emailAddress'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];
  $phoneNo = $_POST['phoneNo'];
  $branchId = $_POST['branchId'];
  $yearId = $_POST['yearId'];
  $dateCreated = date("Y-m-d");

  $query1 = mysqli_query($conn, "select * from tblclassteacher where emailAddress ='$emailAddress' or phoneNo = '$phoneNo'");
  $ret = mysqli_fetch_array($query1);

  if ($ret > 0) {
    $statusMsg =  "<div class='alert alert-danger' role='alert'>This Email Address/Phone Number Already Exists!</div>";
  } else {
    $arr = explode('@', $emailAddress);
    if (($password == $cpassword) && ($arr[1] == "gmail.com" || $arr[1] == "yahoo.com" || $arr[1] == "hotmail.com" || $arr[1] == "outlook.com")) {

      $query2 = mysqli_query($conn, "INSERT INTO tblclassteacher(firstName,lastName,emailAddress,pass,phoneNo,branchId,yearId,dateCreated) 
    VALUE('$firstName','$lastName','$emailAddress','$password','$phoneNo','$branchId','$yearId','$dateCreated')");

      if ($query2) {
        $statusMsg = "<div class='alert alert-success'  alert='alert'>Created Successfully!</div>";
      } else {
        $statusMsg = "<div class='alert alert-danger' alert='alert'>An error Occurred!</div>";
      }
    } else if ($password != $cpassword) {
      $statusMsg = "<div class='alert alert-danger' role='alert'>
                        Password must be same!
                    </div>";
    } else if ($arr[1] != "gmail.com" || $arr[1] != "yahoo.com" || $arr[1] != "hotmail.com" || $arr[1] != "outlook.com") {
      $statusMsg = "<div class='alert alert-danger' role='alert'>
                      E-mail is not correct!
                    </div>";
    }
  }
}
//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query3 = mysqli_query($conn, "select * from tblclassteacher where Id ='$Id'");
  $row = mysqli_fetch_array($query3, MYSQLI_ASSOC);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $phoneNo = $_POST['phoneNo'];
    $branchId = $_POST['branchId'];
    $yearId = $_POST['yearId'];
    $dateCreated = date("Y-m-d");

    $arr = explode('@', $emailAddress);
    if (($password == $cpassword) && ($arr[1] == "gmail.com" || $arr[1] == "yahoo.com" || $arr[1] == "hotmail.com" || $arr[1] == "outlook.com")) {
      $query4 = mysqli_query($conn, "update tblclassteacher set firstName='$firstName', lastName='$lastName',emailAddress='$emailAddress', pass='$password',phoneNo='$phoneNo', branchId='$branchId', yearId='$yearId', dateCreated ='$dateCreated' where Id='$Id'");
      if ($query4) {
        $statusMsg = "<div class='alert alert-success' role='alert'>Updated Successfully!</div>";
        header("location: createStudents.php?message=$statusMsg");
      } else {
        $statusMsg = "<div class='alert alert-danger' role='alert'>An error Occurred!</div>";
      }
    } else if (!($password == $cpassword)) {
      $statusMsg =  "<div class='alert alert-danger' role='alert'>
  Password must be same!
</div>";
    } else if ($arr[1] != "gmail.com" || $arr[1] != "yahoo.com" || $arr[1] != "hotmail.com" || $arr[1] != "outlook.com") {
      $statusMsg = "<div class='alert alert-danger' role='alert'>
  E-mail is not correct!
</div>";
    }
  }
}

//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $querys = mysqli_query($conn, "DELETE FROM tblclassteacher WHERE Id='$Id'");

  if ($querys == TRUE) {
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
  <title>AMS | Teacher</title>
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
            <h1 class="h3 mb-0 text-gray-800">Create Teachers</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Teachers</li>
              <li class="breadcrumb-item" aria-current="page"><a href="viewTeachers.php">View Teachers</a></li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Teachers</h6>
                  <?php if (isset($_GET['message']) && !empty($_GET['message'])) {
                                echo $_GET['message'];
                            }
                              echo $statusMsg;
                  ?>
                </div>
                <div class="card-body">
                  <form method="post" action="createClassTeacher.php">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">First Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="firstName" maxlength="32" pattern="^[A-Za-z ]{1,32}$" title="Please enter a valid first name containing only letters" value="<?php echo $row['firstName']; ?>" placeholder="Enter First Name">
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Last Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="lastName" maxlength="32" pattern="^[A-Za-z ]{1,32}$" title="Please enter a valid last name containing only letters" value="<?php echo $row['lastName']; ?>" placeholder="Enter Last Name">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Email<span class="text-danger ml-2">*</span></label>
                        <input type="email" class="form-control" pattern="^[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required name="emailAddress" value="<?php echo $row['emailAddress']; ?>" placeholder="Enter Email Address">
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Phone Number<span class="text-danger ml-2">*</span></label>
                        <input type="tel" class="form-control" pattern="[6789]{1}[0-9]{9}" title="Please enter valid phone number" maxlength="10" required name="phoneNo" value="<?php echo $row['phoneNo']; ?>" placeholder="Enter Phone Number">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Password<span class="text-danger ml-2">*</span></label>
                        <input type="text" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.,;!@#$%^&*])[a-zA-Z0-9.,;!@#$%^&*]{7,20}$" minlength="6" maxlength="20" title="Please enter 7 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character" class=" form-control" name="password" value="<?php echo $row['pass']; ?>" placeholder="Enter Password" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Confirm Password<span class="text-danger ml-2">*</span></label>
                        <input type="text" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.,;!@#$%^&*])[a-zA-Z0-9.,;!@#$%^&*]{7,20}$" minlength="6" maxlength="20" title="Please enter same password" class=" form-control" name="cpassword" placeholder="Reenter Password" required>
                      </div>
                    </div>
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
                    <?php
                    if (isset($Id)) {
                    ?>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <button type="submit" name="cancel" onclick="javascript:window.location='createClassTeacher.php'" class="btn btn-primary">Cancel</button>
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
                      <h6 class="m-0 font-weight-bold text-primary">All Teachers</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Date Created</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $query = "SELECT tblclassteacher.Id AS Id,tblbranch.branchName AS branchName,tblyear.yearName AS yearName,tblclassteacher.firstName AS firstName,tblclassteacher.lastName AS lastName,tblclassteacher.emailAddress AS emailAddress,tblclassteacher.phoneNo AS phoneNo,tblclassteacher.pass AS pass,tblclassteacher.dateCreated AS dateCreated
                          FROM tblclassteacher
                          INNER JOIN tblbranch ON tblbranch.Id = tblclassteacher.branchId
                          INNER JOIN tblyear ON tblyear.Id = tblclassteacher.yearId ORDER BY tblclassteacher.dateCreated DESC";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          $status = "";
                          if ($num > 0) {
                            while ($rowss = $rs->fetch_assoc()) {
                              $sn = $sn + 1;
                              echo '
                              <tr>
                                <td>' . $sn . '</td>
                                <td>
                                <a class="dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="false" style="cursor:pointer;">
                                  <span>' . $rowss['firstName'] . ' ' . $rowss['lastName'] . '</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                  <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                      <thead class="thead-light">
                                          <tr>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                            <tr>
                                              <td>'.$rowss['phoneNo'].'</td>
                                              <td>'.$rowss['emailAddress'].'</td>
                                              <td>'.$rowss['pass'].'</td>
                                            </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                </td>
                                <td>' . $rowss['branchName'] . '</td>
                                <td>' . $rowss['yearName'] . '</td>
                                <td>' . $rowss['dateCreated'] . '</td>
                                <td><a href="?action=edit&Id=' . $rowss['Id'] . '"><i class="fas fa-fw fa-edit"></i></a></td>
                                <td><a href="?action=delete&Id=' . $rowss['Id'] . '"><i class="fas fa-fw fa-trash"></i></a></td>
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