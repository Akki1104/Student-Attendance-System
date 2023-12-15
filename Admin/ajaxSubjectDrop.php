<?php
include '../Includes/dbcon.php';

    $cid = intval($_GET['cid']);//

        $queryss=mysqli_query($conn,"select * from tblsubject where termId = ".$cid." order by Id ASC");                        
 
        echo '
        <select required name="subjectId" class="form-control mb-3">';
        echo'<option value="">--Select Subject--</option>';
        while ($subrow = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$subrow['Id'].'" >'.$subrow['subjectName'].'</option>';
        }
        echo '</select>';
?>

