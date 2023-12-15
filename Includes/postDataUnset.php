<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $_SESSION['postdata'] = $_POST;
  unset($_POST);
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}
if (@$_SESSION['postdata']) {
  $_POST = $_SESSION['postdata'];
  unset($_SESSION['postdata']);
}
?>