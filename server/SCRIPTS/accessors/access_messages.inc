<?php
/*
 * 	modify_users.inc
 * 
 *  Created By: William Charles Grove
 *  
 *  Date: 11/18/16
 *  
 *  Contains functions to add and
 *  delete users.
 *  
 * 
 */


/*
 * User user_isactivees:
 * 
 * 1 - Pending
 * 2 - Active
 * 3 - Inactive
 * 
 */

require_once "../utilities/get_permissions.inc";


function deleteMessage($msg_id, $conn){
	
	$sql = "delete from Messages where ";
	
	if (getPermissions($conn) == false){
		return "Unable to get Permissions";
	}
	
if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][4] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Users";
	}
	
	$found_val = false;
	
	if(intval($msg_id) != 0){
		$found_val = true;
		$sql = $sql . "msg_id = $msg_id";
	}
	
	else {
		return "All values are empty.";
	}
	
	$query = mysqli_query($conn, $sql);
	
	if($query == false){
		return "Failed to delete user. Check to see if user exists.";
	} else {
		
		return;
	}
	
}


?>
