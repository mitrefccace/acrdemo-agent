<?php
$config = parse_ini_file('config.ini');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot username or password</title>
    <link rel="stylesheet" type="text/css" href="mnje.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap/3.3.6/css/bootstrap.min.css">
  	<script src="libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>
    function validateForm() {
        var x = $('#email').val();
       
        if (x === null || x === "") {
            $('#statusmsg').attr("class","errmsg").text("Email field is required.");
            return false;
        }
        
        return true;
    }

    $(document).ready(function(){
    $('#reset').click(function()
    {
        if (!validateForm()) {
            return;
        }
        
        //alert("validate ok");
        //get data from form
        var email = document.getElementById('email').value;
        
        //make AJAX call

        $.ajax({
            url: "reset_submit.php",
            type:'POST',
            data:
            {
                email: email
            },
            dataType: "json" //expect a JSON response
            }).done(function(msg) {
                //success
                //alert ("reset succeed");
                $('#statusmsg').attr("class","succmsg").text(msg.text);
               
            }).fail(function(jqXHR, textStatus, errorThrown) {
                //fail
                //alert ("reset failed");
                s = "status: " + jqXHR.status + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown;
                $('#statusmsg').attr("class","errmsg").text("error - "+s);
                
            }).complete(function(msg) {
                //always executed
            });
    });
    });



</script>
</head>

<body>

<h3 style="display:inline">Forgot username or password</h3>

<p>
After submitting the request, you will receive an email. Please follow the instructions in that email to reset your password.
</p>

<!-- The HTML registration form -->

<form class="form-horizontal" role="form">
    
    <div class="form-group">
        <label for="email" class="control-label col-sm-2" >Email</label>
        <div class="col-sm-4"><input type="text" class="form-control" id="email" name="email" placeholder="My email is: " ></div><div class="reqaster">*</div>
    </div>
</form>

<div class="btn-group-vertical btn-group-sm" role="group">
    <!-- <input type="submit" name="submit" class="btn btn-default" value="Register" style="margin-bottom:30px;margin-top:30px"/> -->
    <button id="reset" class="btn btn-primary">Reset Password</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<div class="errmsg" id="statusmsg"></div>
<br><br>

</body>
</html>
