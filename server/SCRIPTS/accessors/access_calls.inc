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

require_once "../utilities/get_permissions.inc";

function deleteCall($call_id, $conn){
	
	$sql = "delete from Calls where ";
	
	if (getPermissions($conn) == false){
		return "Unable to get Permissions";
	}
	
if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][3] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Calls";
	}
	
	$found_val = false;
	
	if(intval($call_id) != 0){
		$found_val = true;
		$sql = $sql . "call_id = $call_id";
	}
	
	else {
		return "All values are empty.";
	}
	
	$query = mysqli_query($conn, $sql);
	
	if($query == false){
		return "Failed to delete call. Check to see if call exists.";
	} else {
		
		return;
	}
	
}
?>