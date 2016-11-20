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


function deleteDevice($device_id, $conn){
	
	$sql = "delete from Devices where ";
	
	if (getPermissions($conn) == false){
		return "Unable to get Permissions";
	}
	
if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][5] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Devices";
	}
	
	$found_val = false;
	
	if(intval($device_id) != 0){
		$found_val = true;
		$sql = $sql . "device_id = $device_id";
	}
	
	else {
		return "All values are empty.";
	}
	
	$query = mysqli_query($conn, $sql);
	
	if($query == false){
		return "Failed to delete device. Check to see if user exists.";
	} else {
		
		return;
	}
	
}


?>
