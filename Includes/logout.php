<?php
  session_unset();
  unset($_SESSION['userId']);
  unset($_SESSION['emailAddress']);
  echo "<script>
  window.location = (\"../index.php\");
  </script>";
?>