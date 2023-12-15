<?php
session_start(); 

if (!isset($_SESSION['userId']))
{
    session_unset();
    session_destroy();
    echo "<script>
          window.location = (\"../index.php\");
          </script>";
}
$_SESSION['LAST'] = time();
$expiry = 1800 ;//session expiry required after 30 mins
if (isset($_SESSION['LAST']) && (time() - $_SESSION['LAST'] > $expiry)) {
    session_unset();
    session_destroy();
    echo "<script>
          window.location = (\"../index.php\");
          </script>";
}   
?>