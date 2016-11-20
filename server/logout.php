<?php
/*	
*	logout.php
*
*	Created by: William Grove:
*	For the global honors program
*	at Lock Haven University of Pennsylvania.
*
*	Created on: 5/18/2016
*/


        session_start();

        if(!isset($_SESSION['username'])){
                header("Location: index.php");
        }

        if(isset($_SESSION['username'])) {
      
                unset($_SESSION['username']);
				unset($_SESSION['name']);
				unset($_SESSION['permission']);
				session_destroy();
                header("Location: login.php");
        }

?>
     
