<?php
include '../Includes/dbcon.php';

    $cid = intval($_GET['cid']);//
        $queryss=mysqli_query($conn,"select * from tblyear where branchId=".$cid." order by Id ASC");                        
        
        echo '
        <select required name="yearId" onChange="termDrop(this.value)" class="form-control mb-3">';
        echo'<option value="">--Select Year--</option>';
        while ($roww = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$roww['Id'].'" >'.$roww['yearName'].'</option>';
        }
        echo '</select>';
?>