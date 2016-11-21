<?php
/**********************************

        tools.php

        Created By: William Grove
        
**********************************/

session_start();

require ('template.inc');


 HTML_StartHead();

 AddTitle("Register");
 
 AddCSS( "all.css" );
 AddCSS( "jquery-ui.min.css");
 echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">";
 
 //Optional theme
 echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css\" integrity=\"sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r\" crossorigin=\"anonymous\">";
 AddCSS("jquery.bootgrid.min.css");
 
 Body_AddScript( "jquery-1.12.3.min.js" );
 
 Body_AddScript( "jquery-ui.min.js" );
  
 Body_AddScript("all.js");

 Body_AddScript("bootstrap.min.js");
 
 HTML_EndHead();

 HTML_StartBody();

 Body_CreateSideNav();

 Body_CreateHeader( "Register" );

 Body_CreateStickyNav();
?>

<script type="text/javascript">
$(document).ready (function(){
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
		  });
	}
}



var subbutton = document.getElementById("submitButton");

$(subbutton).click(function() {
    // Stop the browser from submitting the form.        
    
    var form = $('#registerform');
    var formData = $(form).serialize();
    
    $.ajax({
        type: 'POST',
        url: $(form).attr('action'),
        data: formData,
        cache: false,
        dataType: "text",
        success: function(result){
        	if(result === "success"){
        		//Redirect
        	} else {
        	}
        	
        	showMessage(result);
        }
    })
    
    
});

});



</script>

<form id="registerform" method="post" action="SCRIPTS/web_requests/enduser_request.php" name="registerform" class="form-horizontal">

<fieldset>

<!-- Form Name -->
<legend>Register</legend>

<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="user_username">School Email</label>
<div class="col-md-4">
<input id="user_username" name="user_username" maxlength="24" placeholder="Email" class="form-control input-md" required type="text">

</div>
</div>

<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="fname">First Name</label>
<div class="col-md-4">
<input id="fname" name="fname" placeholder="First Name" maxlength="35" class="form-control input-md" required type="text">

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
<input id="passwor" name="password" maxlength="80" class="form-control input-md" required type="text">

</div>
</div>

<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="confirm_password">Confirm Password</label>
<div class="col-md-4">
<input id="confirm_passwor" name="confirm_password" placeholder="" maxlength="80" class="form-control input-md" type="text">

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
<input type="hidden" name="opcode" value="3"/>
<input type="hidden" name="enduserupdaterequest" value="1"/>

<!-- Textarea -->
<div class="form-group">
<label class="col-md-4 control-label" for="error_area"></label>
<div class="col-md-4">
<span id="error_area"></span>
</div>
</div>

</form>



</body>
