<?php
/*
 *  login.php   
 *
 *  Created By: William Grove
 *
 *  Created On: 10/10/2016
 *
 */
 session_start();
 require ('template.inc');
 include ('SCRIPTS/utilities/login.inc');
 
 /*
if(isset($_SESSION['username'])){
        header("location: index.php");
}
*/

 
 

 HTML_StartHead();
 
 AddTitle("Login");

 AddCSS( "login.css" );
 
 AddCSS( "all.css" );
 
 
 HTML_EndHead();
 
 HTML_StartBody();

 Body_CreateSideNav();
 
 Body_CreateHeader( "Login" );
 
 Body_CreateStickyNav();
?>


<div class="login-block">

	<form class="inside"  action="" method="post">
    <h1>Login</h1>
	<p class="warning"><?php echo $error; ?></p>
    <input class="text-box" type="text" value="" placeholder="Username" id="username" name="username" />
    <input class="text-box" type="password" value="" placeholder="Password" id="password" name="password" />
    <input class="submit" type="submit" name="submit" value="Login">
	</form>
	
</div>
<?php

 Body_AddScript( "jquery-1.12.3.min.js" );
 Body_AddScript( "jquery.cycle2.min.js" );
 Body_AddScript( "bootstrap.min.js" );
 Body_AddScript( "all.js" );

 HTML_End();
?>
