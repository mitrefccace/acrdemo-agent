<?php
session_start();
$config = parse_ini_file('config.ini');
$loggedin = $_SESSION["loggedin"];
$role = strtolower($_SESSION["role"]);
//$clickButton = $_SESSION["clickButton"];
unset($_SESSION["clickButton"]);
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
	//AJAX JQuery instead of page reloading
	$( document ).ready(function() {
		$('#signin').click(function() {

			//clear rolemsg
			$('#rolemsg').text('');

			//get data from form
			var username = document.getElementById('username').value;
			var password = document.getElementById('password').value;

			//make AJAX call
			$.ajax({
				url: "index_submit.php",
				type:'POST',
				data: {
						username: username,
						password: password
				},
				dataType: "json" //expect a JSON response
				}).done(function(msg) {
					//success; check app return code
					if (msg.rc === "1") {
							//login success
							$('#myModal').modal('hide');
							$('#rolemsg').text('Hello ' + msg.role + '.');
							//show any role-specific buttons?
							if (msg.role === 'manager') {
								$('#managementbutton').removeClass('hidden');
								$('#updatebutton').removeClass('hidden');
								$('#approvebutton').removeClass('hidden');
							} else {
								$('#managementbutton').addClass('hidden');
								$('#approvebutton').addClass('hidden');
							}
					} else {
							//login failed
							$('#statusmsg').attr("class","text-danger lead text-center").text("Login failed.").css('visibility', 'visible');
					}
				}).fail(function(jqXHR, textStatus, errorThrown) {
					//fail
					s = "status: " + jqXHR.status + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown;
					$('#statusmsg').attr("class","text-danger lead text-center").text("error - "+s).css('visibility', 'visible');
				}).complete(function(msg) {
					//always executed
				});
		});

});

	function signout() {
		$('#managementbutton').addClass('hidden'); //hide all role buttons
		$('#approvebutton').addClass('hidden'); //hide all role buttons
		$('#updatebutton').addClass('hidden'); //hide all role buttons
		$('#rolemsg').text(''); //clear role message
		window.location.replace('logout.php');
	}
	</script>
</head>
<body>

	<!-- Modal -->
	<div class="modal fade"  data-backdrop="static"  id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Sign In</h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="control-label col-sm-2" for="username">Username</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="username" name="username" placeholder="enter username">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="password">Password</label>
							<div class="col-sm-4">
								<input type="password" class="form-control" id="password" name="password" placeholder="enter password">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"></label>
							<div class="checkbox col-sm-4">
									<label><input type="checkbox" name="signedin" value="signedin">Keep me signed in</label>
							</div>
						</div>
					</form>
					<div class="form-group">
						<label class="control-label col-sm-2"></label>
						<div class="btn-group-vertical btn-group-sm" role="group">
							<button id="signin" class="btn btn-primary">Sign in</button>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2"></label>
						<div class="btn-group-vertical btn-group-sm" role="group">
							<button type="button" onclick="window.location.replace('reset.php');" class="btn btn-link" style="text-align:left">Can't access your account?</button>
							<button type="button" onclick="window.location.replace('register.php');" class="btn btn-link" style="text-align:left">Need an account?</button>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2"></label>
						<div class="btn-group-vertical btn-group-sm" role="group">

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="form-group">
						<div class="checkbox col-sm-4">
							<div class="text-danger lead text-center" id="statusmsg">&nbsp;</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="row">
	<div class="col-md-12">
		<div class="well">
			<h1 style="display:inline">&#9738;&nbsp;agent</h1><p style="display:inline;font-size: 24px;vertical-align:top;">&nbsp;&reg;</p><br>
			<p style="display:inline;margin-right:50px !important; ">Customer service made simple.</p><div style="display:inline !important;color:blue !important; margin-right:50px !important;" id="rolemsg"><?php
				if (isset($_SESSION["role"])) {
					echo "Hello ".$_SESSION["role"].".";
				}
			?></div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="well">
					<button type="button" onclick="$('#content').load('./welcome.php');" class="btn btn-link">Welcome</button><br>
					<button type="button" onclick="$('#content').load('./profile.php');" class="btn btn-link">Profile</button><br>
					<button type="button" onclick="signout();"  class="btn btn-link">Sign Out</button><br>
					<!-- role specific buttons -->
					<button style="color: blue !important;" type="button" id="managementbutton" onclick="$('#content').load('./management.php');" class="btn btn-link hidden">Management</button><br>
					<button style="color: blue !important;" type="button" id="updatebutton" onclick="$('#content').load('./updateAgent.php');" class="btn btn-link hidden">Agent Profile</button><br>
					<button style="color: blue !important;" type="button" id="approvebutton" onclick="$('#content').load('./approve.php');" class="btn btn-link hidden">Approve</button><br>
          <br/>
          <br/>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <div id="content">
						<p id="msg"></p><br/>
			            <br/>
			            <br/>
			            <br/>
						<br/>
						<br/>
				</div>
            </div>
        </div>
    </div>
</div>

<script>

<?php
if (isset($_SESSION["msg"])) {
    echo "document.getElementById('msg').innerHTML='".$_SESSION["msg"]."';";
}else{
    // Fallback behaviour goes here
    echo "document.getElementById('msg').innerHTML='';";
}

//show any role-specific buttons if the user is already logged in
if ($role === "manager") {
	echo "$('#managementbutton').removeClass('hidden');";
	echo "$('#updatebutton').removeClass('hidden');";
	echo "$('#approvebutton').removeClass('hidden');";
} else {
	echo "$('#managementbutton').addClass('hidden');";
	echo "$('#approvebutton').addClass('hidden');";
}

/*
if (strlen($clickButton) > 0) {
	echo "$('#".$clickButton."').click();";
}
*/
?>

$('#username').keypress(function(event) {
	$('#statusmsg').text("aaa").css('visibility', 'hidden');
});
$('#password').keypress(function(event) {
	$('#statusmsg').text("aaa").css('visibility', 'hidden');
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode === 13){
		$('#signin').click();
	}
});

<?php
if (strlen($loggedin) == 0) {
	echo "$('#myModal').modal('show');";
} else {
	echo "$('#myModal').modal('hide');";
}
?>

</script>



</body>
<?php
unset($_SESSION["msg"]); //do last
?>
</html>
