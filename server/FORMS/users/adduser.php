<?php 
session_start();

require_once "../../SCRIPTS/utilities/database_connection.inc";

$conn = DBConnect();

 if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][1] == 1 || $_SESSION["permissions"][2] == 1) == false){

	header("location: index.php");
	die();
}

?><body>

<script type="text/javascript">

function showMessage(result){
	 if(result === "success"){
		  $("#error_area").queue(function(){
		  $("#error_area").text("User Added.");
		  $("#error_area").css("color", "green");
		  $("#error_area").fadeIn(2000).delay( 6000 ).fadeOut(2000);
		 $(this).dequeue();
		  });
		 
		  } else {
		 var err = "Error: " + result;
		  $("#error_area").queue(function(){
		   $("#error_area").text("");
		  $("#error_area").text(err);
		  $("#error_area").css("color", "red");
		  $("#error_area").fadeIn(2000).delay( 6000 ).fadeOut(2000);
		 $(this).dequeue();
		  })
	}
}

$(document).ready (function(){

var subbutton = document.getElementById("submitButton");

$(subbutton).click(function() {
    // Stop the browser from submitting the form.

    if($("#password").text() == $("#password_confirm").text() && $("#password_confirm").text().length >= 6){
        
    
    var form = $('#users_form');
    var formData = $(form).serialize();
    
    $.ajax({
        type: 'POST',
        url: $(form).attr('action'),
        data: formData,
        cache: false,
        dataType: "text",
        success: function(result){
        	if(result === "success"){
        		$("#users_form").trigger("reset");
        	} else {
        	}
        	
        	showMessage(result);
        }
    })

    } else {

    	if($("#password_confirm").text().length < 6){

    		showMessage("Passwords must be at least 6 characters long.");
    	} else {
        
		showMessage("Passwords do not match.");

    	}
    }
    
    
});

});



</script>



<form id="users_form" method="post" action="SCRIPTS/web_requests/user_request.php" name="adduserform" class="form-horizontal">

<fieldset>

<!-- Form Name -->
<legend>Add Users</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_username">School Email</label>  
  <div class="col-md-4">
  <input id="user_username" name="user_username" maxlength="60" placeholder="Username" class="form-control input-md" required type="text">
 
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="fname">First Name</label>  
  <div class="col-md-4">
  <input id="fname" name="fname" placeholder="First Name" maxlength="20" class="form-control input-md" required type="text">
  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="lname">Last Name</label>  
  <div class="col-md-4">
  <input id="lname" name="lname" placeholder="Last Name" maxlength="35" class="form-control input-md" required type="text">
 
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password</label>  
  <div class="col-md-4">
  <input id="password" name="password" maxlength="50" class="form-control input-md" required type="text">

  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password_confirm">Confirm Password</label>  
  <div class="col-md-4">
  <input id="confirm_password" name="confirm_password" placeholder="" maxlength="50" class="form-control input-md" type="text">
  
  </div>
</div>



<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submitButton"></label>
  <div class="col-md-4">
    <button type="button" id="submitButton" name="submitButton" class="btn btn-primary">Submit</button>
  </div>
</div>


</fieldset>
<input type="hidden" name="opcode" value="1"/>
<input type="hidden" name="userupdaterequest" value="1"/>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="error_area"></label>
  <div class="col-md-4">                     
    <span id="error_area"></span>
  </div>
</div>

</form>


	
</body>
