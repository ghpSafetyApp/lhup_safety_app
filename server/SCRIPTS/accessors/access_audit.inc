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

function insertAuditEntry ($name, $image, $conn){

	getPermissions($conn);
	
	if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][6] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Audit Entries";
	}
	
	$sql = "Insert into Audit values (null, $user_id, $aud_code, '$aud_data', NOW())";

	$query = mysqli_query($conn, $sql);
	
	if($query == false){
	
		return "Unable to add entry";
	} else {
		return true;
	}
	
}

function deleteAuditEntry($aud_id, $conn){
	
	$sql = "delete from Audit where ";
	
	if (getPermissions($conn) == false){
		return "Unable to get Permissions";
	}
	
if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][5] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Audit";
	}
	
	$found_val = false;
	
	if(intval($aud_id) != 0){
		$found_val = true;
		$sql = $sql . "aud_id = $aud_id";
	}
	
	else {
		return "All values are empty.";
	}
	
	$query = mysqli_query($conn, $sql);
	
	if($query == false){
		return "Failed to delete entry. Check to see if entry exists.";
	} else {
		
		return;
	}
	
}


?>