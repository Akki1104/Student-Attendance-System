<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$qury = "SELECT tblsubject.Id As Id, tblsubject.subjectName AS subjectName FROM tblsubject
INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
WHERE tblsubject.teacherId = '$_SESSION[userId]' AND tblsubject.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1'";
$result = $conn->query($qury);
$num = $result->num_rows;
if ($num > 0) {
    while ($rows = $result->fetch_assoc()) {
?>
        <table border="1">
            <thead>
                <tr>
                    <th colspan="11">Subject</th>
                </tr>
                <tr>
                    <th colspan="11"><?php echo $rows['subjectName'] ?></th>
                </tr>
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
        $filename = "Attendance list";
        $dateTaken = date("Y-m-d");
        $subjectId = $rows['Id'];
        $cnt = 1;
        $ret = mysqli_query($conn, "SELECT *
FROM tblstudents
INNER JOIN tblsessionterm ON tblsessionterm.branchId = '$_SESSION[branchId]'
INNER JOIN tblbranch ON tblbranch.Id = '$_SESSION[branchId]'
INNER JOIN tblyear ON tblyear.Id = tblsessionterm.yearId
INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId 
WHERE tblstudents.yearId = tblsessionterm.yearId AND tblsessionterm.isCtActive = '1' ORDER BY tblStudents.firstName ASC");

        if (mysqli_num_rows($ret) > 0) {
            while ($row = mysqli_fetch_array($ret)) {

                $que = mysqli_query($conn, "SELECT *
                FROM tblattendance
                INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                WHERE tblattendance.dateTimeTaken = '$dateTaken' AND tblattendance.rollNumber = '$row[rollNumber]' AND tblattendance.branchId = '$_SESSION[branchId]' AND tblattendance.yearId = tblsessionterm.yearId AND tblattendance.subjectId = '$subjectId' AND tblsessionterm.isCtActive = '1'");
                $r = $que->fetch_array();
                if ($r['status'] == '1') {
                    $status = "Present";
                    $colour = "#00FF00";
                } else {
                    $status = "Absent";
                    $colour = "#FF0000";
                }

                echo "
                    <tr>
                      <td>" . $cnt . "</td>
                      <td>" . $row['firstName'] . "</td>
                      <td>" . $row['lastName'] . "</td>
                      <td>" . $row['phoneNo'] . "</td>
                      <td>" . $row['rollNumber'] . "</td>
                      <td>" . $row['branchName'] . "</td>
                      <td>" . $row['yearName'] . "</td>
                      <td>" . $row['termName'] . "</td>
                      <td>" . $row['sessionName'] . "</td>
                      <td style='background-color:" . $colour . "'>" . $status . "</td>
                      <td>" . $dateTaken . "</td>
                    </tr>
                    ";
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header("Content-Disposition: attachment; filename=" . $filename . " - " . $dateTaken . " -report.xls");
                header('Cache-Control: max-age=0');
                $cnt++;
            }
        }
    }
}

    ?>
        </table>