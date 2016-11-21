<?php

session_start();

require_once '../accessors/access_end_users.inc';
require_once '../utilities/get_permissions.inc';
require_once '../utilities/database_connection.inc';
require_once '../update_factory/update_factory.inc';
include_once 'register_request.inc';

if(isset($_POST["enduserupdaterequest"])){

	$conn = DBConnect();

	if($conn == false){
		echo "Unable to Connect to Database.";
		return;
	}

	

	$opcode = 0;

	if(isset($_POST["opcode"])){
		$opcode = intval(removeslashes($_POST["opcode"]));

		if($opcode == 0){
			echo "Malformed Operation.";
			DBClose($conn);
			return;
		}
	} else {
		echo "Opcode not set.";
		DBClose($conn);
		return;
	}

	//Add
	if($opcode == 3){
		
		$user_username = "";
		$fname="";
		$lname="";
		$password="";
		$confirm_password="";
		
		if(isset($_POST["user_username"])){
			$user_username = mysqli_real_escape_string($conn, removeslashes($_POST["user_username"]));
		
			if(strlen($user_username) == 0){
				echo "Email is blank.";
				DBClose($conn);
				return;
			}
		}
		
		if(isset($_POST["fname"])){
			$fname = mysqli_real_escape_string($conn, removeslashes($_POST["fname"]));
		
			if(strlen($fname) == 0){
				echo "First name is blank.";
				DBClose($conn);
				return;
			}
		}
		
		if(isset($_POST["lname"])){
			$lname = mysqli_real_escape_string($conn, removeslashes($_POST["lname"]));
		
			if(strlen($lname) == 0){
				echo "Last Name is blank.";
				DBClose($conn);
				return;
			}
		}
		
		if(isset($_POST["password"])){
			$password = mysqli_real_escape_string($conn, removeslashes($_POST["password"]));
		
			if(strlen($password) == 0){
				echo "Password is blank.";
				DBClose($conn);
				return;
			}
		}
		
		if(isset($_POST["confirm_password"])){
			$confirm_password = mysqli_real_escape_string($conn, removeslashes($_POST["confirm_password"]));
		
			if(strlen($confirm_password) == ""){
				echo "Confirm Password Is Blank.";
				DBClose($conn);
				return;
			}
		}
		
		register_request($user_username, $fname, $lname, $password, $confirm_password);
		
	}
	
	//Delete
	if($opcode == 2){
		
		if(getPermissions($conn) == false){
			echo "Unable to retrieve permissions.";
			DBClose($conn);
			return;
		}
		
		$end_user_id = 0;
		
		if(isset($_POST["end_user_id"])){
			$end_user_id = intval(removeslashes($_POST["end_user_id"]));
		
			if($end_user_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
		} else {
			echo "Call ID not set.";
			DBClose($conn);
			return;
		}
		
		
		$result = deleteEndUser($end_user_id, $conn);
		
		if($result === true){
			echo "success";
		} else {
			echo $result;
		}
		
		DBClose($conn);
		return;
		
	}
	
	
	
	//Update
	if($opcode == 1){
		
		if(getPermissions($conn) == false){
			echo "Unable to retrieve permissions.";
			DBClose($conn);
			return;
		}
		
		if(($_SESSION["permissions"][0] == 1) == false){
			echo "You do not have permission to update Capstones.";
		}
		
		$end_user_id = 0;
		
		
		
		$where = "end_user_id = ";
		$sets = array();
		
		if(isset($_POST["end_user_id"])){
			$end_user_id = intval(removeslashes($_POST["end_user_id"]));
		
			if($end_user_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
			
			$where = $where . $end_user_id;
			
		} else {
			echo "Call ID not set.";
			DBClose($conn);
			return;
		}
		
		if(isset($_POST["end_user_username"])){
			$end_user_username = mysqli_real_escape_string($conn, removeslashes($_POST["end_user_username"]));
				
			if(strlen(trim($end_user_username)) < 1){
				echo "Capstone Description is Blank.";
				DBClose($conn);
				die();
			}
				
			$sets[] = "end_user_username = '" . $end_user_username . "'";
				
		}
		
		if(isset($_POST["end_user_fname"])){
			$end_user_fname = mysqli_real_escape_string($conn, removeslashes($_POST["end_user_fname"]));
				
			if(strlen(trim($end_user_fname)) < 1){
				echo "Capstone Description is Blank.";
				DBClose($conn);
				die();
			}
				
			$sets[] = "end_user_fname = '" . $end_user_fname . "'";
				
		}
		
		if(isset($_POST["end_user_lname"])){
			$end_user_lname = mysqli_real_escape_string($conn, removeslashes($_POST["end_user_lname"]));
				
			if(strlen(trim($end_user_lname)) < 1){
				echo "Capstone Description is Blank.";
				DBClose($conn);
				die();
			}
				
			$sets[] = "end_user_lname = '" . $end_user_lname . "'";
				
		}
		
		if(isset($_POST["end_user_hash"])){
			$end_user_hash = mysqli_real_escape_string($conn, removeslashes($_POST["end_user_hash"]));
				
			if(strlen(trim($end_user_hash)) < 1){
				echo "Capstone Description is Blank.";
				DBClose($conn);
				die();
			}
				
			$sets[] = "end_user_hash = '" . $end_user_hash . "'";
				
		}
		
		if(isset($_POST["end_user_status"])){
			$end_user_status = intval(removeslashes($_POST["end_user_status"]));
			
			if($end_user_status == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
			
			$sets[] = "end_user_status = $end_user_status";
			
		} 
		
		
		
		if(count($sets) < 1){
			echo "Nothing to update";
			DBClose($conn);
			return;
		}
		
		$result = update("EndUsers", $sets, $where, 2, $conn);
		
		if($result === true){
			echo "success";
		} else {
			echo $result;
		}
		
		DBClose($conn);
		return;
		
	}
	
} else {
	echo "Invalid request";
	return;
}
