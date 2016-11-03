<?php
  session_start();
  unset($_SESSION["loggedin"]);
  unset($_SESSION["role"]);
  header( 'Location: index.php' ) ;
  exit();
?>
<!DOCTYPE html>
<html><head><title></title></head><body></body></html>
