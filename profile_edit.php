<?php

    session_start();
    $config = parse_ini_file('config.ini');

    //if the user is not logged in, redirect to the login page
    $loggedin = $_SESSION["loggedin"];
    if (strlen($loggedin) == 0) {
        header('Location: index.php' ) ;
    }

    $username = filter_input(INPUT_POST, 'username');
    $extension_id = filter_input(INPUT_POST, 'extension_id');
    $queue_id = filter_input(INPUT_POST, 'queue_id');
    $soft_extension_id = filter_input(INPUT_POST, 'soft_extension_id');
    $soft_queue_id = filter_input(INPUT_POST, 'soft_queue_id');


    $mysqli = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);

    # check connection
    if ($mysqli->connect_errno) {
        $arr = array("text" => "MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}", "rc" => "0");
        echo json_encode($arr);
        exit();
    }
     else {

        //$sql = "UPDATE agent_data SET username=extension_id='$extension_id', queue_id='$queue_id', soft_extension_id='$soft_extension_id', soft_queue_id='$soft_queue_id'";
        $sql1 = "UPDATE agent_data ad, asterisk_extensions ae
                    SET
                        ae.extension = '$extension_id'
                    WHERE 
                        ad.extension_id = ae.id AND
                        ad.username = '$loggedin'";
        $sql2 = "UPDATE agent_data ad, asterisk_queues aq
                    SET
                        aq.queue_name = '$queue_id'
                    WHERE 
                        ad.queue_id = aq.id AND
                        ad.username = '$loggedin'";
        $sql3 = "UPDATE agent_data ad, soft_extensions se
                    SET
                        se.extension = '$soft_extension_id'
                    WHERE 
                        ad.soft_extension_id = se.id AND
                        ad.username = '$loggedin'";
        $sql4 = "UPDATE agent_data ad, soft_queues sq
                    SET
                        sq.queue_name = '$soft_queue_id'
                    WHERE 
                        ad.soft_queue_id = sq.id AND
                        ad.username = '$loggedin'";
        $_SESSION["loggedin"] = $username;   // update loggedin username to reflect change

        $temp = ""; 

        if (!($mysqli->query($sql1) === TRUE)) {
            $temp  = "Update failed: " ; 
            
            $temp = $temp . "   That Asterisk Extension already exsists";
        }
        if (!($mysqli->query($sql2) === TRUE)) {
            if ($temp == ""){
                $temp  = "Update failed: "
; 
            }else{
                $temp = $temp.". ";
            }
            $temp = $temp . "   That Asterisk Queue already exsists";
        }
        if (!($mysqli->query($sql3) === TRUE)) {
            if ($temp == ""){
                $temp  = "Update failed: "
; 
            }else{
                $temp = $temp.". ";
            }
            $temp = $temp . "   That Soft Extension already exsists";
        }
        if (!($mysqli->query($sql4) === TRUE)) {
            if ($temp == ""){
                $temp  = "Update failed: "
; 
            }else{
                $temp = $temp.". ";
            }
            $temp = $temp . "   That Soft Queue already exsists.";
        }

        //$arr = array("text" => $temp, "rc" => "1");
        //echo json_encode($arr);
        //exit(); 

        if($temp == ""){
            $arr = array("text" => "Profile updated.", "rc" => "1");
        }
        else{
            $error = $mysqli->error;
            $arr = array("text" => $temp, "rc" => "0");
        }

        echo json_encode($arr);
    }
    $mysqli->close();
    exit();
?>

