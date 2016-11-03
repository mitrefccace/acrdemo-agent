<?php
session_start();
$loggedin = $_SESSION["loggedin"];
if (strlen($loggedin) == 0) {
	header('Location: index.php' ) ;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="mnje.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<h1 style="display:inline">Welcome.</h1>

</body>
</html>
