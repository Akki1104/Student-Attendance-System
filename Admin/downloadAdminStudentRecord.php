<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
?>
<table border="1">
    <thead>
        <tr>
            <th colspan="11">Subject</th>
        </tr>
        <?php
        $filename = "Attendance list";
        $branchId = $_POST['branchId'];
        $yearId = $_POST['yearId'];
        $termId = $_POST['termId'];
        $sessionTermId = $_POST['sessionTermId'];
        $subjectId = $_POST['subjectId'];
        $rollNumber =  $_POST['rollNumber'];
        $type =  $_POST['type'];

        if ($type == "1") { //All Attendance

            $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.phoneNo,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$branchId' and tblattendance.yearId = '$yearId' and tblsessionterm.Id = '$sessionTermId' and tblattendance.subjectId = '$subjectId'";
        }
        if ($type == "2") { //Single Date Attendance

            $singleDate =  $_POST['singleDate'];

            $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.phoneNo,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.dateTimeTaken = '$singleDate' and tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$branchId' and tblattendance.yearId = '$yearId' and tblsessionterm.Id = '$sessionTermId' and tblattendance.subjectId = '$subjectId'";
        }
        if ($type == "3") { //Date Range Attendance

            $fromDate =  $_POST['fromDate'];
            $toDate =  $_POST['toDate'];

            $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblbranch.branchName,
                        tblyear.yearName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.phoneNo,tblstudents.rollNumber
                        FROM tblattendance
                        INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
                        INNER JOIN tblyear ON tblyear.Id = tblattendance.yearId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.rollNumber = tblattendance.rollNumber
                        where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$rollNumber' and tblattendance.branchId = '$branchId' and tblattendance.yearId = '$yearId' and tblsessionterm.Id = '$sessionTermId' and tblattendance.subjectId = '$subjectId'";
        }

        $rr = mysqli_query($conn, "SELECT subjectName FROM tblsubject WHERE tblsubject.Id = '$subjectId'")->fetch_assoc();

            echo '<tr>
                    <th colspan="11">' . $rr['subjectName'] . '</th>
                </tr>';
        ?>
        <tr>
            <th>S.No.</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone Number</th>
            <th>Roll Number</th>
            <th>Branch</th>
            <th>Year</th>
            <th>Semester</th>
            <th>Session</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <?php

    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $sn = 0;
    $totalP = 0;
    $totalA = 0;
    $status = "";
    if ($num > 0) {
        while ($rows = $rs->fetch_assoc()) {
            if ($rows['status'] == '1') {
                $status = "Present";
                $colour = "#00FF00";
                $totalP = $totalP + 1;
            } else {
                $status = "Absent";
                $colour = "#FF0000";
                $totalA = $totalA + 1;
            }
            $sn = $sn + 1;
            echo "
                <tr>
                  <td>" . $sn . "</td>
                  <td>" . $rows['firstName'] . "<?td>
                  <td>" . $rows['lastName'] . "</td>
                  <td>" . $rows['phoneNo'] . "</td>
                  <td>" . $rows['rollNumber'] . "</td>
                  <td>" . $rows['branchName'] . "</td>
                  <td>" . $rows['yearName'] . "</td>
                  <td>" . $rows['termName'] . "</td>
                  <td>" . $rows['sessionName'] . "</td>
                  <td style='background-color:" . $colour . "'>" . $status . "</td>
                  <td>" . $rows['dateTimeTaken'] . "</td>
                </tr>";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=" . $filename . " - " . $rows['firstName'] . " - " . $rows['lastName'] . " - " . $rows['branchName']  . " -report.xls");
            header('Cache-Control: max-age=0');
        }
    ?>
        </tbody>
        <thead class="thead-light">
            <tr>
                <th>Total Present</th>
                <th>Total Absent</th>
            </tr>
        </thead>

        <tbody>
        <?php

        echo "
        <tr>
          <td>" . $totalA . "</td>
          <td>" . $totalB . "</td>
          </tr>";
    }
        ?>
</table>