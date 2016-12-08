<?php
/**********************************

        register.php

        Created By: William Grove
        
**********************************/


require_once 'SCRIPTS/accessors/end_user_confirm.inc';
require_once ('template.inc');
require_once 'SCRIPTS/utilities/database_connection.inc';

if(!isset($_GET['uhash']) && !isset($_GET['register'])){
	header ( "location: index.php" );
}

$conn = DBConnect();

$confirmation = false;

 if(isset($_GET['uhash'])){
 	$confirmation = true;
 }

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

<form id="infoform" class="form-horizontal">

<fieldset>

<!-- Form Name -->
<legend><?php 

if($confirmation == true){
	echo "Confirmation";
} else {
	echo "Please Confirm";
}

?></legend>

<p><?php 

if($confirmation == true){
	
	echo confirmEndUser($_GET["uhash"], $conn);
	
} else {
	echo "A confirmation email has been sent to the specified account.
        		\nOnce verified, you can add your device through the app.";
}

?></p>


</fieldset>


<!-- Textarea -->
<div class="form-group">
<label class="col-md-4 control-label" for="error_area"></label>
<div class="col-md-4">
<span id="error_area"></span>
</div>
</div>

</form>



</body>
