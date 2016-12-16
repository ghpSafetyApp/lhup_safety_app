<?php
/**********************************

        tools.php

        Created By: William Grove
        
**********************************/

session_start();

require ('template.inc');
require_once "SCRIPTS/utilities/get_permissions.inc";
require_once 'SCRIPTS/utilities/database_connection.inc';

$conn = DBConnect();
getPermissions($conn);


if(!isset($_SESSION["userid"])){
header("location: index.php");
}

 HTML_StartHead();

 AddTitle("Tools");
 
 AddCSS( "all.css" );
 AddCSS( "jquery-ui.min.css");
 AddCSS("tools.css");
 echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">";
 
 //Optional theme
 echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css\" integrity=\"sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r\" crossorigin=\"anonymous\">";
 AddCSS("jquery.bootgrid.min.css");

 AddCSS("jquery-ui-timepicker-addon.css");
 
 Body_AddScript( "jquery-1.12.3.min.js" );
 
 Body_AddScript( "jquery-ui.min.js" );
  
 Body_AddScript("all.js");

 Body_AddScript("bootstrap.min.js");
 
 Body_AddScript("jquery.bootgrid.min.js");
 
 Body_AddScript("moment-with-locales.min.js");
 
 Body_AddScript("jquery-ui-timepicker-addon.js");
 
 echo "<script src=\"https://use.fontawesome.com/ac70f8b488.js\"></script>";
 
 
 HTML_EndHead();

 HTML_StartBody();

 Body_CreateSideNav();

 Body_CreateHeader( "Tools" );

 Body_CreateStickyNav();
 ?>
 
 <script type="text/javascript">
 
 $(document).ready(function() {
    var menu = $("ul.droopin").menu();
  		$(function() {
 	$( "#menu" ).menu();
 });
    $(menu).mouseleave(function () {
        menu.menu('collapseAll');
  	 });	
  		
        $("li[data-linkhtml]").click(function() {
        var pagename = $(this).attr("data-linkhtml");
        $('#right').load('FORMS/' + pagename);
    });

});	

</script>
 
 <?php 

 
 //Create the nav menu
 
 echo "<div class=\"content_div_in_tools\">\n";
 echo "<div class=\"left\">\n";
 echo "<ul id=\"menu\" class=\"droopin\">\n";
 
 if($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][6] == 1){
 	
 	echo "<li data-linkhtml = \"audit/view_audit.php\">Audit</li>\n";
 	
 }
 
 if($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][3] == 1){
 
 	echo "<li data-linkhtml = \"calls/update_calls.php\">Calls</li>\n";
 
 }
 
 if($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][5] == 1){
 
 	echo "<li data-linkhtml = \"devices/update_devices.php\">Devices</li>\n";
 	
 
 }
 
 if ($_SESSION ["permissions"] [0] == 1 || $_SESSION["permissions"][4] == 1) {
 
 	echo "<li data-linkhtml = \"messages/update_messages.php\">Messages</li>\n";
 	
 
 }
 
 
 if($_SESSION["permissions"][0] == 1){
 	echo "<li data-linkhtml = \"permissions/update_permissions.php\">Permissions</li>\n";
 }
 
 if($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][2] == 1){
 
 	echo "<li data-linkhtml = \"students/update_students.php\">Students</li>\n";
 	
 }
 
 if($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][1] == 1){
 
 	echo " <li>Users\n";
 	echo "    <ul>\n";
 	echo " 		<li data-linkhtml = \"users/adduser.php\">Add User</li>\n";
 	echo "      <li data-linkhtml = \"users/deleteuser.php\">Delete User</li>\n";
 	echo "      <li data-linkhtml = \"users/updateuser.php\">Update User</li>\n";
 	echo "    </ul>\n";
 	echo " </li>\n";
 }
 

	echo " <li>Password\n";
	echo " 		<ul>\n";
	echo "			<li data-linkhtml = \"password/password_change.php\">Change Password</li>\n";
	echo "		</ul>\n";
	echo " </li>\n";
 
 echo "</ul>\n";
 echo "</div>\n";
 echo "<div class=\"right\" id=\"right\">\n";
 
 ?>
 
 <div id="message_container">
<div id="success_box" class="alert_box success">
<h1 class="alert_text success_text">
</h1>
</div>
<div id="failure_box" class="alert_box failure">
<h1 class="alert_text failure_text" id="text_failure">
</h1>
</div>
</div>
 
 <?php 
 echo "</div>\n";
 		
 HTML_End();

?>

