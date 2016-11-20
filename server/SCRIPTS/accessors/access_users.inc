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

function addUser($school_email, $user_fname, $user_lname, $user_isactive, $conn){
	
	if (getPermissions($conn) == false){
		return "Unable to get Permissions";
	}
	
	if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][1] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Users";
	}
	
	$email_pieces = explode("@", $school_email);
	
	if (count($email_pieces) == 2){
		if(strcmp($email_pieces[1], "lhup.edu") != 0){
			return "Invalid school email address, bad domain: " . $email_pieces[1];
		}
	} else {
		return "Invalid university email address";
	}
	
	$username = $email_pieces[0];
	
	$user_password = "temp!" . $school_id;
	
	$password = crypt($user_password, '$2a$10$leskfiqamdhjthrjwsksdidfhrjrkdlsldlkfjjgird$');
	
	$sql = "insert into Users values (null, '$username', '$user_fname', '$user_lname', 1, '$password')";
	
	$query = mysqli_query($conn, $sql);
	
	if($query == false){
		return "Failed to insert user $username. Check to see if user exists.";
	} 
		
	$user_id = 0;
	
	$sql = "SELECT MAX(user_id) FROM Users";
		
		$result = mysqli_query($conn, $sql);
		
		
		
		if($result == false){
			return "Failed to write permissions";
		} 
			if(mysqli_num_rows($result) < 1){
				return "No user with the id.";
			}
			
			while($row = mysqli_fetch_row($result)){
				$user_id = intval($row[0]);
			}
			
			
			$stmnt = "insert into permissions values (null, $user_id, 0, 0, 0, 0, 0, 0, 0)";

			$result = mysqli_query($conn, $stmnt);
		
			if($result == false){
				return "Unable to add user permissions.";
			}
		
		return true;
	}
	
	



function deleteUser($user_id, $conn){
	
	$sql = "delete from Users where ";
	
	if (getPermissions($conn) == false){
		return "Unable to get Permissions";
	}
	
if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][1] == 1) == false){
		return "User Not Permitted to Add, Modify, or Delete Users";
	}
	
	$found_val = false;
	
if(intval($user_id) === 1){
		return "You cannot Delete the Admin. Request Refused.";
	}
	
	if(intval($user_id) != 0){
		$found_val = true;
		$sql = $sql . "user_id = $user_id";
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