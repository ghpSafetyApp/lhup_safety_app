<?php

session_start();

require_once '../utilities/get_permissions.inc';
include_once '../utilities/database_connection.inc';
require_once '../update_factory/update_factory.inc';


if(isset($_POST["permissionchangerequest"])){
	
	$conn = DBConnect();
	
	if($conn == false){
		echo "Could not connect to database.";
		return;
	}
	
	if(getPermissions($conn) == false){
		echo "Could not update permissions.";
		DBClose($conn);
		return;
		
	}
	
	if($_SESSION["permissions"][0] != 1){
		echo "You do not have permission to change permissions (Irony).";
		DBClose($conn);
		return;
	}
	
	$opcode = intval(removeslashes($_POST["opcode"]));
	
	if($opcode == 0){
		echo "Incorrect operations code.";
		DBClose($conn);
		return;
	}
	
	//Update
	if($opcode == 1){
		
		$set = array();
		$where = "perm_id = ";
		
		if(isset($_POST["perm_id"])){
			
			if(intval(removeslashes($_POST["perm_id"])) == 0){
				echo "Invalid user id passed";
				DBClose($conn);
				return;
			}
			
			$where = $where . intval(removeslashes($_POST["perm_id"]));
		} else {
			echo "No perm id found.";
			DBClose($conn);
			return;
		}
		
		if(isset($_POST["perm_users"])){
			$set[] = "perm_users = " . intval(removeslashes($_POST["perm_users"]));
		}
		
		if(isset($_POST["perm_end_users"])){
			$set[] = "perm_end_users = " . intval(removeslashes($_POST["perm_end_users"]));
		}
		
		if(isset($_POST["perm_calls"])){
			$set[] = "perm_calls = " . intval(removeslashes($_POST["perm_calls"]));
		}
		
		if(isset($_POST["perm_messages"])){
			$set[] = "perm_messages = " . intval(removeslashes($_POST["perm_messages"]));
		}
		
		if(isset($_POST["perm_devices"])){
			$set[] = "perm_devices = " . intval(removeslashes($_POST["perm_devices"]));
		}
		
		if(isset($_POST["perm_audit"])){
			$set[] = "perm_audit = " . intval(removeslashes($_POST["perm_audit"]));
		}
		
		if(count($set) == 0){
			echo "Nothing to update";
			DBClose($conn);
			return;
		}
		
		
		$result = update("Permissions", $set, $where, 2,$conn);
		
		if($result === true){
			echo "success";
			DBClose($conn);
			return;
		} else {
			echo "Update Failed.";
			DBClose($conn);
			return;
		}
		
	} else {
		echo "Malformed Change Request.";
		DBClose($conn);
		return;
	}
	
	
	
}

?>

