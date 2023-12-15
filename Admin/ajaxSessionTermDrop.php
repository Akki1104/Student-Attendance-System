<?php
include '../Includes/dbcon.php';

    $cid = intval($_GET['cid']);//

        $queryss=mysqli_query($conn,"select * from tblsessionterm where termId=".$cid."");                        
 
        echo '
        <select required name="sessionTermId" onChange="studentDrop(this.value)" class="form-control mb-3">';
        echo'<option value="">--Select Sesssion--</option>';
        while ($sessrow = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$sessrow['Id'].'" >'.$sessrow['sessionName'].'</option>';
        }
        echo '</select>';
?>