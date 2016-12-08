<?php

require_once '../utilities/get_permissions.inc';

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





function deleteEndUser($end_user_id, $conn){
	
	$sql = "delete from EndUsers where ";
	
	if (getPermissions($conn) == false){
		return "Unable to get Permissions";
	}
	
if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][2] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Users";
	}
	
	$found_val = false;
	
	if(intval($end_user_id) != 0){
		$found_val = true;
		$sql = $sql . "end_user_id = $end_user_id";
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