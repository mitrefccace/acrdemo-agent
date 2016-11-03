<?php
session_start();
$config = parse_ini_file('config.ini');
$loggedin = $_SESSION["loggedin"];
$role = strtolower($_SESSION["role"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Agent Portal</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<script>
	var numChecked = 0;
	function handleChange(cb) {
	  if(cb.checked == true){
	   numChecked++;
	  }else{
	   numChecked--;
	  }

		if (numChecked > 0) {
				$('#approve').removeClass('disabled');
		} else {
			$('#approve').addClass('disabled');
		}
	}

	//AJAX JQuery instead of page reloading
	$(document).ready(function() {
		$('#approve').click(function() {

      var i = 0;
			$("tr.item").each(function() {
			  $this = $(this)
			  var email = $this.find("input.email").val();
				var chk = $('#ck'+i).prop('checked');
				i++;
				if (chk === true) {
					//approve this email
					//make AJAX call
					$.ajax({
						url: "approve_submit.php",
						type:'POST',
						data: {
								email: email
						},
						dataType: "json" //expect a JSON response
						}).done(function(msg) {
						}).fail(function(jqXHR, textStatus, errorThrown) {
						}).complete(function(msg) {
							$('#content').load('./approve.php');
						});
				};
		});
	});
});
	</script>

</head>
<body>

	<div class="container">
	  <h2>Users Awaiting Approval</h2>
	  <p>Select users below and click Approve:</p>
	  <table class="table">
	    <thead>
	      <tr>
	        <th>First Name</th>
	        <th>Last Name</th>
	        <th>Role</th>
					<th>Phone</th>
	        <th>Email</th>
	        <th>Organization</th>
					<th>Approve?</th>
	      </tr>
	    </thead>
	    <tbody>

				<?php
				$conn = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);
				// Check connection
				if ($conn->connect_error) {
				    echo "Unable to connect to database.";
				    die("Connection failed: " . $conn->connect_error);
				}

				$sql = "SELECT * FROM agent_data WHERE is_approved = 0";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
						$idx = 0;
				    while($row = $result->fetch_assoc()) {
							echo "<tr class=\"item\">";
				      echo "<td>".$row["first_name"]."</td><td>". $row["last_name"]."</td><td>". $row["role"]."</td><td>". $row["phone"]."</td><td>". $row["email"]."</td>"."<input class=\"email\" type=\"hidden\" value=\"".$row["email"]."\"><td>".$row["organization"]."</td><td><input id=\"ck".$idx."\" onchange=\"handleChange(this);\" type=\"checkbox\" value=\"\"></td>";
							echo "</tr>";
							$idx++;
				    }
				} else {
				    echo "0 results";
				}
				$conn->close();
				?>

	    </tbody>
	  </table>
		<button id="approve" class="btn btn-primary disabled">Approve</button><br><br>
		<div  id="statusmsg"><?php echo $_SESSION["msg"]; ?></div>

	</div>

</body>
<?php
unset($_SESSION["msg"]); //do last
?>
</html>
