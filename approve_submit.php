<?php
session_start();
$config = parse_ini_file('config.ini');
$email = filter_input(INPUT_POST, 'email');
$mysqli = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);

# check connection
if ($mysqli->connect_errno) {
  $arr = array("text" => "MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}", "rc" => "0");
  echo json_encode($arr);
  $_SESSION["msg"] = "MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}";
  exit();
}

# approve
$sql = "UPDATE agent_data SET is_approved=1 WHERE email='{$email}'";
if ($mysqli->query($sql)) {
  $arr = array("text" => "Approved.", "rc" => "1");
  $_SESSION["msg"] = "Approved.";
  echo json_encode($arr);
  $mysqli->close();
  exit();
} else {
  $arr = array("text" => "Error", "rc" => "0");
  $_SESSION["msg"] = "Error.";
  echo json_encode($arr);
  $mysqli->close();
  exit();
}

?>
<!DOCTYPE html>
<html><head><title></title></head><body></body></html>
