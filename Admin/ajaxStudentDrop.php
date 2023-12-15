<?php

include '../Includes/dbcon.php';

    $cid = intval($_GET['cid']); //

        $queryss = mysqli_query($conn, "SELECT * FROM tblstudents WHERE sessionTermId = ".$cid." ORDER BY firstName ASC");

        echo ' 
        <select required name="rollNumber" class="form-control mb-3">';
        echo '<option value="">--Select Student--</option>';
        while ($sturow = mysqli_fetch_array($queryss)) {
        echo '<option value="' . $sturow['rollNumber'] . '" >' . $sturow['firstName'] . ' ' . $sturow['lastName'] . '</option>';
        }
        echo '</select>';
?>
