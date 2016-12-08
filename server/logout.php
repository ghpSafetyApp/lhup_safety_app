<?php
/*	
*	logout.php
*
*	Created by: William Grove:
*
*	Created on: 10/10/2016
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
     
