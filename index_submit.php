<?php
session_start();
$config = parse_ini_file('config.ini');
$_SESSION["loggedin"] = "";
$_SESSION["role"] = "";
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

$mysqli = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);

# check connection
if ($mysqli->connect_errno) {
  $arr = array("text" => "MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}", "rc" => "0");
  echo json_encode($arr);
  exit();
}

# authenticate and authorize
$sql = "SELECT * from agent_data WHERE username LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1";
$result = $mysqli->query($sql);
if (!$result->num_rows == 1) {
  $arr = array("text" => "Login failed", "rc" => "0");
  echo json_encode($arr);
} else {
  $_SESSION["loggedin"] = $username;
  $row = $result->fetch_assoc();
  $_SESSION["role"] = $row["role"];
  $arr = array("text" => "Login success", "role" => $row["role"], "rc" => "1");
  echo json_encode($arr);
}

$mysqli->close();
exit();
?>
<!DOCTYPE html>
<html><head><title></title></head><body></body></html>
