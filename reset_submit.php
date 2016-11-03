<?php
    //This is the submit (POST) PHP; register.php calls this
    //return 0 if fail, 1 if success

    session_start();
    $config = parse_ini_file('config.ini');
    $_SESSION["loggedin"] = "";
    $_SESSION["role"] = "";

    $email = filter_input(INPUT_POST, 'email');

   
    $mysqli = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);

    # check connection
    if ($mysqli->connect_errno) {
        $arr = array("text" => "MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}", "rc" => "0");

        echo json_encode($arr);
        exit();
    }
    
    $sql = "SELECT * FROM agent_data WHERE email='{$email}'";
    $result = $mysqli->query($sql);
    if ($result->num_rows === 1) {
        $arr = array("text" => "Reset password request received. Please check your email", "rc" => "0");
        echo json_encode($arr);
    }
    else {
	    // TO DO - check for email address
	    $arr = array("text" => "Email address not found. Please re-enter password", "rc" => "0");
	    //arr = array("text" => "{$email}", "rc" => "0");
	    echo json_encode($arr);
	}
    
    $mysqli->close();
    exit();
?>

<!DOCTYPE html>
<html><head><title></title></head><body></body></html>
