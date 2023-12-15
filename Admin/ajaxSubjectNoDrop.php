<?php

include '../Includes/dbcon.php';

    $cid = intval($_GET['cid']);

    echo '<div class="form-group row mb-3">';
    for($i = 1; $i <= $cid ; $i++){
        echo '
        <div class="mb-3 col-xl-6">
            <label class="form-control-label">Subject '.$i.'<span class="text-danger ml-2">*</span></label>
            <input type="text" class="form-control" pattern="^[A-Za-z0-9 ]{1,100}$" title="Please enter a valid name" name="subject[]" placeholder="Enter Subject Name" required>
        </div>
       ';
    }
    echo '</div>';
?>