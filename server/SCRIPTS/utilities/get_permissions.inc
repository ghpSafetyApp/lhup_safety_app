<?php
/*
 * get_permissions.inc
 * 
 * Created By: William Grove
 * 
 * Date: 6/16/2016
 * 
 * Sets the permissions of the current user.
 * 
 */

function getPermissions($conn){
	
	$sql = "Select perm_admin, perm_users, perm_end_users, perm_calls, perm_messages, perm_devices, perm_audit FROM Permissions WHERE user_id =" .  $_SESSION["userid"];
	
	$permissions = array();
	
	$query = mysqli_query($conn, $sql);
	
	if($query == false){
		
		return false;
	}
	
	while ($row = mysqli_fetch_row($query)){
		for ($r = 0; $r < count($row); $r++){
			$permissions[] = $row[$r];
		}
	}
	
	$_SESSION["permissions"] = $permissions;
	
	return true;
}


?>