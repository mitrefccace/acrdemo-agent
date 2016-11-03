<?php
session_start();
$config = parse_ini_file('config.ini');
$loggedin = $_SESSION["loggedin"];
$role = strtolower($_SESSION["role"]);
$eid = "";
$qid = "";
$seid = "";
$sqid = "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="mnje.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script>
            var rc = "0";
           //AJAX JQuery instead of page reloading
           $(document).ready(function(){

               //***************EDIT BUTTON****************
               $('#editprofile').click(function()
               {
                   // make form fields editable
                   //document.getElementById("username").removeAttribute("readonly");
                   document.getElementById("extension_id").removeAttribute("readonly");
                   document.getElementById("queue_id").removeAttribute("readonly");
                   document.getElementById("soft_extension_id").removeAttribute("readonly");
                   document.getElementById("soft_queue_id").removeAttribute("readonly");

                   // hide EDIT PROFILE button and show SAVE button
                   //$("#editprofile").text("Save");
                   document.getElementById("saveprofile").style.display = "block";
                   document.getElementById("editprofile").style.display = "none";
               });

               function validateForm() {
                   var x = $('#username').val();
                  if (x === null || x === "") {
                      $('#statusagentmsg').attr("class","errmsg").text("Username field is required.");
                      return false;
                  }
                  x = $('#extension_id').val();
                  if (x === null || x === "") {
                      $('#statusagentmsg').attr("class","errmsg").text("Extension field is required.");
                      return false;
                  }
                  x = $('#queue_id').val();
                  if (x === null || x === "") {
                      $('#statusagentmsg').attr("class","errmsg").text("queue field is required.");
                      return false;
                  }
                  x = $('#soft_extension_id').val();
                  if (x === null || x === "") {
                      $('#statusagentmsg').attr("class","errmsg").text("Soft extension field is required.");
                      return false;
                  }
                  x = $('#soft_queue_id').val();
                  if (x === null || x === "") {
                      $('#statusagentmsg').attr("class","errmsg").text("soft queue id field is required.");
                      return false;
                  }
               return true;
           };

           //**************SAVE BUTTON*****************
           $('#saveprofile').click(function()
           {
             rc = "0";
             //alert ("clicking save");
             if (!validateForm()) {
               $('#statusagentmsg').attr("class","succagentmsg").text(msg.text);
               $('#myProfileModal').modal('show');
               return;
            }

             //get data from form
             var username = document.getElementById('username').value;
             var extension_id = document.getElementById('extension_id').value;
             var queue_id = document.getElementById('queue_id').value;
             var soft_extension_id = document.getElementById('soft_extension_id').value;
             var soft_queue_id = document.getElementById('soft_queue_id').value;
          
             //make AJAX call
             $.ajax({
                 url: "profile_edit.php",
                 type:'POST',
                 data:
                 {
                     username: username,
                     extension_id: extension_id,
                     queue_id: queue_id,
                     soft_extension_id: soft_extension_id,
                     soft_queue_id: soft_queue_id
                     
                 },
                 dataType: "json" //expect a JSON response
               }).done(function(msg) {
                   //success
                 $('#statusagentmsg').attr("class","succagentmsg").text(msg.text);
                 //rc = "1";
                  rc = msg.rc; 

                  if(rc == "1"){
                     // make form fields editable
                     //document.getElementById("username").removeAttribute("readonly");
                     document.getElementById("extension_id").setAttribute("readonly", "true");
                     document.getElementById("queue_id").setAttribute("readonly", "true");
                     document.getElementById("soft_extension_id").setAttribute("readonly", "true");
                     document.getElementById("soft_queue_id").setAttribute("readonly", "true");

                     // hide SAVE PROFILE button and show HIDE button
                     document.getElementById("editprofile").style.display = "block";
                     document.getElementById("saveprofile").style.display = "none";
                  }

               }).fail(function(jqXHR, textStatus, errorThrown) {
                   //fail
                   s = "status: " + jqXHR.status + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown;
                   $('#statusagentmsg').attr("class","errmsg").text("error - "+s);
               }).complete(function(msg) {
                   //always executed
                   $('#myProfileModal').modal('show');
               });

               
           });
         });
    </script>
</head>
<body>
	

    <?php
        $mysqli = new mysqli($config["hostname"], $config["dbuser"], $config["dbpass"], $config["dbname"]);

        # check connection
        if ($mysqli->connect_errno) {
            $arr = array("text" => "MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}", "rc" => "0");

            echo json_encode($arr);
            //exit();
        }
    ?>

    <form class="form-horizontal" role="form">
    <?php
        $sql = "SELECT * FROM agent_data WHERE username='$loggedin'";
       
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
       
            // output data of the first row. It should only have one exact match
          while($row = $result->fetch_assoc()) {
           
            echo '<div class="form-group"><label for="username" class="control-label col-sm-2" >Username</label><div class="col-sm-4"><input type="text" class="form-control" id="username" name="username" value="'.$row["username"].'"readonly></div></div>';
          
            //echo '<div class="form-group"><label for="extension_id" class="control-label col-sm-2" >Extension Id</label><div class="col-sm-4"><input type="text" class="form-control" id="extension_id" name="extension_id" value="'.$row["extension_id"].'"readonly></div></div>';
            $eid = $row['extension_id'];
            $qid = $row['queue_id'];
            $seid = $row['soft_extension_id'];
            $sqid = $row['soft_queue_id'];
            
            $extension_query_sql = "SELECT * FROM asterisk_extensions WHERE id='$eid'";
            $result1 = $mysqli->query($extension_query_sql);
            $row1 = $result1->fetch_assoc();
            echo '<div class="form-group"><label for="extension_id" class="control-label col-sm-2" >Asterisk Extension</label><div class="col-sm-4"><input type="text" class="form-control" id="extension_id" name="extension_id" value="'.$row1["extension"].'"readonly></div></div>';

            $queue_query_sql = "SELECT * FROM asterisk_queues WHERE id='$qid'";
            $result1 = $mysqli->query($queue_query_sql);
            $row1 = $result1->fetch_assoc();
           
            echo '<div class="form-group"><label for="queue_id" class="control-label col-sm-2" >Asterisk Queue</label><div class="col-sm-4"><input type="text" class="form-control" id="queue_id" name="queue_id" value="'.$row1["queue_name"].'"readonly></div></div>';

            $soft_extension_query_sql = "SELECT * FROM soft_extensions WHERE id='$seid'";
            $result1 = $mysqli->query($soft_extension_query_sql);
            $row1 = $result1->fetch_assoc();
            echo '<div class="form-group"><label for="soft_extension_id" class="control-label col-sm-2" >Soft Extension</label><div class="col-sm-4"><input type="text" class="form-control" id="soft_extension_id" name="soft_extension_id" value="'.$row1["extension"].'"readonly></div></div>';
            
            $soft_queue_query_sql = "SELECT * FROM soft_queues WHERE id='$sqid'";
            $result1 = $mysqli->query($soft_queue_query_sql);
            $row1 = $result1->fetch_assoc();
            echo '<div class="form-group"><label for="soft_queue_id" class="control-label col-sm-2" >Soft Queue</label><div class="col-sm-4"><input type="text" class="form-control" id="soft_queue_id" name="soft_queue_id" value="'.$row1["queue_name"].'"readonly></div></div>';
          }  
        } else {
            echo "0 results";
        }
      
    ?>
    </form>

     <!-- EDIT and SAVE buttons  ***  hide SAVE button -->
    <div class="btn-group-vertical btn-group-sm" role="group">
        <div class="form-group">
            <label class="control-label col-sm-2" ></label>
            <div class="col-sm-4">
                <button id="editprofile" class="btn btn-primary">Edit Profile...</button>
                <button id="saveprofile" class="btn btn-primary" style="display:none;">Save</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myProfileModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">User Profile</h4>
          </div>
          <div class="modal-body">
            <div class="succagentmsg" id="statusagentmsg"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <script>
    $('#myProfileModal').modal('hide');
    $('#myProfileModal').on('hidden.bs.modal', function (e) {
      // do something...
      //if (rc === "1") {
        //window.location.href = "./index.php";
      //}
    })
    </script>

</body>
</html>
