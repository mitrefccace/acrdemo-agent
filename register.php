<?php
$config = parse_ini_file('config.ini');
?>

<html>
<head>
    <title>Agent Registration</title>
    <link rel="stylesheet" type="text/css" href="mnje.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>
    var rc = "0";
    function validateForm() {
        var x = $('#username').val();
        if (x === null || x === "") {
            $('#statusmsg').attr("class","errmsg").text("Username field is required.");
            return false;
        }
        x = $('#password').val();
        if (x === null || x === "") {
            $('#statusmsg').attr("class","errmsg").text("Password field is required.");
            return false;
        }
        x = $('#first_name').val();
        if (x === null || x === "") {
            $('#statusmsg').attr("class","errmsg").text("First name field is required.");
            return false;
        }
        x = $('#last_name').val();
        if (x === null || x === "") {
            $('#statusmsg').attr("class","errmsg").text("Last name field is required.");
            return false;
        }

        // phone number, asterisk information are optional

        x = $('#email').val();
        if (x === null || x === "") {
            $('#statusmsg').attr("class","errmsg").text("Email address field is required.");
            return false;
        }

        x = $('#organization').val();
        if (x === null || x === "") {
            $('#statusmsg').attr("class","errmsg").text("Supporting organization field is required.");
            return false;
        }

        return true;
    }



    //AJAX JQuery instead of page reloading
    $(document).ready(function(){
    $('#register').click(function()
    {
        if (!validateForm()) {
            return;
        }

        //alert("validate ok");
        //get data from form
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var first_name = document.getElementById('first_name').value;
        var last_name = document.getElementById('last_name').value;
        var phone = document.getElementById ('phone').value;
        var email = document.getElementById('email').value;
        var organization = document.getElementById('organization').value;
        var asterisk_ext = document.getElementById('asterisk_ext').value;
        var asterisk_secret = document.getElementById('asterisk_secret').value;
        var asterisk_queue = document.getElementById('asterisk_queue').value;
        //make AJAX call
        $.ajax({
            url: "register_submit.php",
            type:'POST',
            data:
            {
                username: username,
                password: password,
                first_name: first_name,
                last_name: last_name,
                phone: phone,
                email: email,
                organization: organization,
                asterisk_ext: asterisk_ext,
                asterisk_secret: asterisk_secret,
                asterisk_queue: asterisk_queue
            },
            dataType: "json" //expect a JSON response
            }).done(function(msg) {
                //success
                //alert ("registration succeed");
                //$('#statusmsg').attr("class","succmsg").text(msg.text);
                $('#msgtext').text(msg.text);
                rc = msg.rc;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                //fail
                //alert ("registration failed");
                s = "status: " + jqXHR.status + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown;
                //$('#statusmsg').attr("class","errmsg").text("error - "+s);
                $('#msgtext').text("error - "+s);
            }).complete(function(msg) {
                //always executed
                $('#myModal').modal('show');
            });
    });
    });


</script>
</head>

<body>

<h3 style="display:inline">Agent Registration</h3>

<p>
Choose a unique username and email address for this new account.
</p>

<!-- The HTML registration form -->

<form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="username" class="control-label col-sm-2" >Username: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="username" name="username" placeholder="your username" ></div><div class="reqaster">*</div>
    </div>
    <div class="form-group">
        <label for="password" class="control-label col-sm-2" >Password: </label>
        <div class="col-sm-4"><input type="password" class="form-control" id="password" name="password" placeholder="your password" ></div><div class="reqaster">*</div>
    </div>
    <div class="form-group">
        <label for="first_name" class="control-label col-sm-2" >First Name: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="first_name" name="first_name" placeholder="your first name" ></div><div class="reqaster">*</div>
    </div>
    <div class="form-group">
        <label for="last_name" class="control-label col-sm-2" >Last Name: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="last_name" name="last_name" placeholder="your last name" ></div><div class="reqaster">*</div>
    </div>
    <div class="form-group">
        <label for="phone" class="control-label col-sm-2" >Phone number: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="phone" name="phone" placeholder="phone number" ></div>
    </div>
    <div class="form-group">
        <label for="email" class="control-label col-sm-2" >Email Address: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="email" name="email" placeholder="your email" ></div><div class="reqaster">*</div>
    </div>
    <div class="form-group">
        <label for="organization" class="control-label col-sm-2" >Supporting Organization: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="organization" name="organization" placeholder="Supporting Organization" ></div><div class="reqaster">*</div>
    </div>
    <div class="form-group">
        <label for="asterisk_ext" class="control-label col-sm-2" >Asterisk Extension: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="asterisk_ext" name="asterisk_ext" placeholder="Asterisk Extension" ></div>
    </div>
    <div class="form-group">
        <label for="asterisk_secret" class="control-label col-sm-2" >Asterisk Secret: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="asterisk_secret" name="asterisk_secret" placeholder="Asterisk Secret" ></div>
    </div>
    <div class="form-group">
        <label for="asterisk_queue" class="control-label col-sm-2" >Asterisk Queue: </label>
        <div class="col-sm-4"><input type="text" class="form-control" id="asterisk_queue" name="asterisk_queue" placeholder="Asterisk Queue" ></div>
    </div>
</form>

<div class="btn-group-vertical btn-group-sm" role="group">
    <button id="register" class="btn btn-primary">Register</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<div class="errmsg" id="statusmsg"></div>
<br><br>

<!-- Modal Message Dialog -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agent Registration</h4>
      </div>
      <div class="modal-body">
        <p id="msgtext"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
$('#myModal').modal('hide');
$('#myModal').on('hidden.bs.modal', function (e) {
  // do something...
  if (rc === "1") {
    window.location.href = "./index.php";
  }
})
</script>


</body>
</html>
