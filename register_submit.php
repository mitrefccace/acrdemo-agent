<?php
    //This is the submit (POST) PHP; register.php calls this
    //return 0 if fail, 1 if success
    session_start();
    $config = parse_ini_file('config.ini');
    $_SESSION["loggedin"] = "";
    $_SESSION["role"] = "";

    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');
    $organization = filter_input(INPUT_POST, 'organization');
    $asterisk_ext = filter_input(INPUT_POST, 'asterisk_ext');
    $asterisk_secret = filter_input(INPUT_POST, 'asterisk_secret');
    $asterisk_queue = filter_input(INPUT_POST, 'asterisk_queue');
    $ast_ext_insert_sql = "INSERT INTO asterisk_extensions (id, extension, extension_secret) VALUES (null, '{$asterisk_ext}', '{$asterisk_secret}')";
    $ast_queue_insert_sql = $sql = "INSERT INTO asterisk_queues (id, queue_name) VALUES (null, '{$asterisk_queue}')";
    $ast_ext_query_sql = "SELECT * FROM asterisk_extensions WHERE extension='{$asterisk_ext}'";
    $ast_queue_query_sql = "SELECT * FROM asterisk_queues WHERE queue_name='{$asterisk_queue}'";

    $mysqli = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);

    //alert ("database connection");
    # check connection
    if ($mysqli->connect_errno) {
        $arr = array("text" => "MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}", "rc" => "0");
        echo json_encode($arr);
        exit();
    }

    # Add a check to make sure that the username/email address are not already registered
    $sql = "SELECT * FROM agent_data WHERE username LIKE '{$username}' OR email LIKE '{$email}' LIMIT 1";
    $result = $mysqli->query($sql);
    if ($result->num_rows === 1) {
        $arr = array("text" => "Registration failed - username or email address already registered", "rc" => "0");
        echo json_encode($arr);

    }
    else {
        # Do the MySQL INSERT here
        /* @var $sql type */

       //$sql = "INSERT INTO asterisk_extensions (id, extension, extension_secret) VALUES (null, '{$asterisk_ext}', '{$asterisk_secret}')";

       if ($mysqli->query($ast_ext_insert_sql) === TRUE) {
            # added successfully rc => 1
                // ok - $arr = array("text" => "insert asterisk extension - ok", "rc" => "1");
                 //$sql = "INSERT INTO asterisk_queues (id, queue_name) VALUES (null, '{$asterisk_queue}')";
                 $result = $mysqli->query($ast_ext_query_sql);
                 $row = $result->fetch_assoc();
                 $agent_id =  $row['id'];
                 if ($mysqli->query($ast_queue_insert_sql) === TRUE) {
                    // ok - $arr = array("text" => "insert asterisk queue - ok", "rc" => "1");
                    $result = $mysqli->query($ast_queue_query_sql);
                    $row = $result->fetch_assoc();
                    $queue_id =  $row['id'];
                    // ok $arr = array("text" => "{$queue_id}", "rc" => "1");
                    $agent_insert_sql = "INSERT INTO agent_data (agent_id, username, password, first_name, last_name, role, phone, email, organization, is_approved, is_active, extension_id, queue_id) VALUES (null, '{$username}', '{$password}', '{$first_name}', '{$last_name}', 'agent', '{$phone}','{$email}','{$organization}', '0', '1', '{$agent_id}',
                        '{$queue_id}')";
                    if ($mysqli->query($agent_insert_sql) === TRUE) {
                        $arr = array("text" => "Insert agent record completed", "rc" => "1");
                    }
                    else {
                        $arr = array("text" => "Insert agent record failed", "rc" => "1");
                    }
                  }

                echo json_encode($arr);

        }
        else  {
            # not added rc => 0
            //$arr = array("text" => "Agent - Registration failed", "rc" => "0");
            $error = $mysql->error;
            $arr = array("text" => "{$error}", "rc" => "0");
            echo json_encode($arr);
        }
    }


    $mysqli->close();
    exit();
?>
