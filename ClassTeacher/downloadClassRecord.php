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
    $fromDate =  $_POST['time1'];
    $toDate =  $_POST['time2'];
    $subjectId = $_POST['subjectId'];

    $cnt = 1;
    $ret = mysqli_query($conn, "SELECT tblstudents.firstName AS firstName, tblstudents.lastName AS lastName, tblstudents.phoneNo AS phoneNo, tblstudents.rollNumber As rollNumber, tblbranch.branchName AS branchName, tblyear.yearName As yearName, tblterm.termName AS termName, tblsessionterm.sessionName AS sessionName
FROM tblstudents
INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
INNER JOIN tblbranch ON tblbranch.Id = '$_SESSION[branchId]'
INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId
INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId 
WHERE tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1' ORDER BY tblStudents.firstName ASC");

$rr = mysqli_query($conn,"SELECT subjectName FROM tblsubject WHERE tblsubject.Id = '$subjectId'")->fetch_assoc();

echo '
<tr>
<th colspan="13">'. $rr['subjectName'] . '</th>
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
                    INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                    where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$row[rollNumber]' and tblattendance.subjectId = '$subjectId' and tblsessionterm.isCtActive = '1' and tblattendance.status = '1'")->num_rows . '</td>
                    <td>' . mysqli_query($conn, "SELECT *
                    FROM tblattendance
                    INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                    where tblattendance.dateTimeTaken between '$fromDate' and '$toDate' and tblattendance.rollNumber = '$row[rollNumber]' and tblattendance.subjectId = '$subjectId' and tblsessionterm.isCtActive = '1' and tblattendance.status = '0'")->num_rows . '</td>
                    <td>' . $fromDate . '</td>
                    <td>' . $toDate . '</td>				
                    </tr>  
                    ';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=" . $filename . " - ". $row['branchName'] . " - ".  $row['termName'] . " Semester " ." -report.xls");
            header('Cache-Control: max-age=0');
            $cnt++;
        }
    }
    ?>
</table>