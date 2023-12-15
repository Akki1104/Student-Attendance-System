<?php
include '../Includes/dbcon.php';

    $cid = intval($_GET['cid']);
        $queryss=mysqli_query($conn,"select * from tblterm where yearId = ".$cid." order by Id ASC");

        echo '
        <select required name="termId" onChange="sessionDrop(this.value)" onClick="subjectDrop(this.value)" class="form-control mb-3">';
        echo'<option value="">--Select Semester--</option>';
        while ($rowws = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$rowws['Id'].'" >'.$rowws['termName'].'</option>';
        }
        echo '</select>';
?>