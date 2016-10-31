<?php
session_start();
$config = parse_ini_file('config.ini');
$loggedin = $_SESSION["loggedin"];
$role = strtolower($_SESSION["role"]);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Agent Management Console</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="mnje.css">
		<link rel="stylesheet" href="css/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/admin.js"></script>
		<script type="text/javascript" src="libs/jquery/jquery-latest.js"></script>
		<script type="text/javascript" src="libs/jquery/jquery.tablesorter.js"></script>
    <link rel="stylesheet" href="js/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />




     <script type="text/javascript">
        $(document).ready(function() {
         $("#test").tablesorter();
         });
     </script>
    </head>
<body>



<?php

## connect mysql server
	$mysqli = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);
	# check connection
	if ($mysqli->connect_errno) {
		echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
		exit();
	}
	# query database for all registration data
	//$result = $mysqli->query('SELECT * from agent_data');
	# query for details view.
	$q2Result = $mysqli->query('SELECT * from agent_data');

if (!(filter_input(INPUT_POST, 'submit')) ) {
?>
	<!-- The HTML Admin Update form -->
 <form class="form-horizontal" role="form" id="frm1" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
    <br>

   
	
    <input style="visibility:hidden" type="type" id="agent_id" name="agent_id" value="<?php echo $row['agent_id']?>" />


	
	<!--<input type="submit" name="submit" id="submit" value="Update" disabled   class="btn btn-primary"  />-->
    <br></br>


<table  id="test" class="tablesorter" border="2">
        <thead>
            <tr>
                <th class="header">USERNAME</th>
                <th class="header">Asterisk Extension</th>
				<th class="header">Asterisk Queue</th>
				<th class="header">Soft Extension</th>
				<th class="header">Soft Queue</th>
            </tr>
        </thead>
        <tbody>
        <?php
            //while($row = mysql_fetch_array($result)) {
			while($q2Row = $q2Result->fetch_assoc()){
            ?>
                <tr id="agent_<?php echo $q2Row['agent_id']?>" onClick="copyData('<?php echo $q2Row['agent_id']?>')">
                    <td id="username_id_<?php echo $q2Row['agent_id']?>"><?php echo $q2Row['username']?></td>
                <?php
                    $eid = $q2Row['extension_id'];
                    $extension_query_sql = "SELECT * FROM asterisk_extensions WHERE id='$eid'";
                    //$result1 = $mysqli->query($extension_query_sql);
                    $result1 = $mysqli->query($extension_query_sql);
                    $row1 = $result1->fetch_assoc();
                ?>
                    <td id="extension_id_<?php echo $q2Row['agent_id']?>"><?php echo $row1['extension']?></td>
                <?php
                    $qid = $q2Row['queue_id'];
                    $queue_query_sql = "SELECT * FROM asterisk_queues WHERE id='$qid'";
                    $result1 = $mysqli->query($queue_query_sql);
                    $row1 = $result1->fetch_assoc();
                ?>
					<td id="queue_id_<?php echo $q2Row['agent_id']?>"><?php echo $row1['queue_name']?></td>
                <?php
                    $seid = $q2Row['soft_extension_id'];
                    $soft_extension_query_sql = "SELECT * FROM soft_extensions WHERE id='$seid'";
                    $result1 = $mysqli->query($soft_extension_query_sql);
                    $row1 = $result1->fetch_assoc();
                ?>
					<td id="soft_extension_id_<?php echo $q2Row['agent_id']?>"><?php echo $row1['extension']?></td>
                <?php
                    $sqid = $q2Row['soft_queue_id'];
                    $soft_queue_query_sql = "SELECT * FROM soft_queues WHERE id='$sqid'";
                    $result1 = $mysqli->query($soft_queue_query_sql);
                    $row1 = $result1->fetch_assoc();
				?>
                	<td id="soft_queue_id_<?php echo $q2Row['agent_id']?>"><?php echo $row1['queue_name']?></td>

				</tr>

            <?php

            }
            ?>
            </tbody>
            </table>
      </form>
<?php
} //end opening if
else
{

	# prepare data for update to database
  $agent_id			= filter_input(INPUT_POST, 'agent_id');
	$username_id	= filter_input(INPUT_POST, 'username_id');
	$extension_id	= filter_input(INPUT_POST, 'extension_id');
	$queue_id	= filter_input(INPUT_POST, 'queue_id');
	$soft_extension_id	= filter_input(INPUT_POST, 'soft_extension_id');
	$soft_queue_id	= filter_input(INPUT_POST, 'soft_queue_id');


	# update existing record in mysql database
		$sql = "UPDATE agent_data SET username='{$username_id}',extension_id='{$extension_id}',queue_id='{$queue_id}',soft_extension_id='{$soft_extension_id}', soft_queue_id='{$soft_queue_id}' WHERE agent_id='{$agent_id}'";
//		echo $sql;
	if ($mysqli->query($sql)) {
			//echo "<p>Updated successfully!</p>";
            $_SESSION["msg"] = "Updated successfully!";
		} else {
			//echo "<p>MySQL error no {$mysqli->errno} : {$mysqli->error}</p>";
            $_SESSION["msg"] = "MySQL error no ".$mysqli->errno." : ".$mysqli->error;
		}

    header("Location: "."./home.php"); /* Redirect browser */
    exit();
}
?>

</body>
</html>
