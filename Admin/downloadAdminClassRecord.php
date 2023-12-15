<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
?>
<table border="1">
    <thead>
        <tr>
            <th colspan="13">Subject</th>
        </tr>
        <?php
        $filename = "Attendance list";
        $branchId = $_POST['branchId'];
        $yearId = $_POST['yearId'];
        $termId = $_POST['termId'];
        $sessionTermId = $_POST['sessionTermId'];
        $subjectId = $_POST['subjectId'];
        $fromDate =  $_POST['fromDate'];
        $toDate =  $_POST['toDate'];

        $cnt = 1;
        $query = "SELECT tblstudents.firstName AS firstName, tblstudents.lastName AS lastName, tblstudents.phoneNo AS phoneNo, tblstudents.rollNumber As rollNumber, tblbranch.branchName AS branchName, tblyear.yearName As yearName, tblterm.termName AS termName, tblsessionterm.sessionName AS sessionName
        FROM tblstudents
        INNER JOIN tblsessionterm ON tblsessionterm.Id = '$sessionTermId'
        INNER JOIN tblbranch ON tblbranch.Id = '$branchId'
        INNER JOIN tblyear ON tblyear.Id = '$yearId'
        INNER JOIN tblterm ON tblterm.Id = '$termId' 
        WHERE tblstudents.branchId = '$branchId' AND tblstudents.yearId = tblsessionterm.yearId ORDER BY tblStudents.firstName ASC";
        $ret = $conn->query($query);

        $rr = mysqli_query($conn, "SELECT subjectName FROM tblsubject WHERE tblsubject.Id = '$subjectId'")->fetch_assoc();

        echo '
            <tr>
            <th colspan="13">' . $rr['subjectName'] . '</th>
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
            <th>Present</th>
            <th>Absent</th>
            <th>From Date</th>
            <th>to Date</th>
        </tr>
    </thead>
    <?php
    if (mysqli_num_rows($ret) > 0) {
        while ($row = mysqli_fetch_array($ret)) {
            echo '  
                    <tr>  
                    <td>' . $cnt . '</td> 
                    <td>' . $row['firstName'] . '</td> 
                    <td>' . $row['lastName'] . '</td> 
                    <td>' . $row['phoneNo'] . '</td> 
                    <td>' . $row['rollNumber'] . '</td> 
                    <td>' . $row['branchName'] . '</td> 
                    <td>' . $row['yearName'] . '</td>	
                    <td>' . $row['termName'] . '</td>	
                    <td>' . $row['sessionName'] . '</td>	
                    <td>' . mysqli_query($conn, "SELECT *
                    FROM tblattendance
                    where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$row[rollNumber]' and tblattendance.sessionTermId = '$sessionTermId' and tblattendance.subjectId = '$subjectId' and tblattendance.status = '1'")->num_rows . '</td>
                    <td>' . mysqli_query($conn, "SELECT *
                    FROM tblattendance
                    where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$row[rollNumber]' and tblattendance.sessionTermId = '$sessionTermId' and tblattendance.subjectId = '$subjectId' and tblattendance.status = '0'")->num_rows . '</td>
                    <td>' . $fromDate . '</td>
                    <td>' . $toDate . '</td>				
                    </tr>  
                    ';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=" . $filename . " - ". $row['branchName'] . " - ".  $row['termName'] . " Semester " . " -report.xls");
            header('Cache-Control: max-age=0');
            $cnt++;
        }
    }
    ?>
</table>