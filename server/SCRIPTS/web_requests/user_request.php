<?php

session_start();

require_once '../accessors/access_users.inc';
require_once '../utilities/get_permissions.inc';
require_once '../utilities/database_connection.inc';
require_once '../update_factory/update_factory.inc';

if(isset($_POST["userupdaterequest"])){

	$conn = DBConnect();

	if($conn == false){
		echo "Unable to Connect to Database.";
		return;
	}

	if(getPermissions($conn) == false){
		echo "Unable to retrieve permissions.";
		DBClose($conn);
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
	if($type == 1){
	
		$conn = DBConnect();
	
		if($conn == false){
			echo "Could not connect to database.";
			exit;
		}
	
		$school_email = "";
		$user_fname = "";
		$user_lname = "";
		$user_isactive = "";
		
	
	
		$school_email = removeslashes($_POST["school_email"]);
	
		if(strlen(trim($school_email)) < 1){
			echo "School Email is blank.";
			DBClose($conn);
			die();
		}
	
		$user_fname = mysqli_real_escape_string($conn, removeslashes($_POST["user_fname"]));
	
		if(strlen(trim($user_fname)) < 1){
			echo "First Name is blank.";
			DBClose($conn);
			die();
		}
	
		$user_lname = mysqli_real_escape_string($conn, removeslashes($_POST["user_lname"]));
	
		if(strlen(trim($user_lname)) < 1){
			echo "Last Name is blank.";
			DBClose($conn);
			die();
		}
		
		$user_isactive = removeslashes($_POST["user_isactive"]);
	
		if(strlen(trim($user_isactive . "")) < 1){
			echo "Active Status is blank.";
			DBClose($conn);
			die();
		}
	
		$result = addUser($school_email, $user_fname, $user_lname,
				$user_isactive, $conn);
	
		DBClose($conn);
	
		if($result === true){
			echo "success";
		} else {
			echo $result;
		}
	
		exit;
	}
	
	//Delete
	if($opcode == 2){
		
		$user_id = 0;
		
		if(isset($_POST["user_id"])){
			$user_id = intval(removeslashes($_POST["user_id"]));
		
			if($user_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
		} else {
			echo "User ID not set.";
			DBClose($conn);
			return;
		}
		
		
		$result = deleteUser($user_id, $conn);
		
		if($result === true){
			echo "success";
		} else {
			echo $result;
		}
		
		DBClose($conn);
		return;
		
	}
	
	
	
	//Update
	if($opcode == 3){
		
		if(($_SESSION["permissions"][0] == 1) == false){
			echo "You do not have permission to update Capstones.";
		}
		
		$user_id = 0;
		$user_username = "";
		$user_fname = "";
		$user_lname = "";
		$user_isactive = 0;
		
		$where = "user_id = ";
		$sets = array();
		
		if(isset($_POST["user_id"])){
			$user_id = intval(removeslashes($_POST["user_id"]));
		
			if($user_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
			
			$where = $where . $user_id;
			
		} else {
			echo "Call ID not set.";
			DBClose($conn);
			return;
		}
		
		if(isset($_POST["user_username"])){
			$user_username = mysqli_real_escape_string($conn, removeslashes($_POST["user_username"]));
				
			if(strlen(trim($user_username)) < 1){
				echo "Capstone Description is Blank.";
				DBClose($conn);
				die();
			}
				
			$sets[] = "user_username = '" . $user_username . "'";
				
		}
		
		if(isset($_POST["user_fname"])){
			$user_fname = mysqli_real_escape_string($conn, removeslashes($_POST["user_fname"]));
				
			if(strlen(trim($user_fname)) < 1){
				echo "Capstone Description is Blank.";
				DBClose($conn);
				die();
			}
				
			$sets[] = "user_fname = '" . $user_fname . "'";
				
		}
		
		if(isset($_POST["user_lname"])){
			$user_lname = mysqli_real_escape_string($conn, removeslashes($_POST["user_lname"]));
				
			if(strlen(trim($user_lname)) < 1){
				echo "Capstone Description is Blank.";
				DBClose($conn);
				die();
			}
				
			$sets[] = "user_lname = '" . $user_lname . "'";
				
		}
		
		if(isset($_POST["user_isactive"])){
			$user_isactive = intval(removeslashes($_POST["user_isactive"]));
			
			if($user_isactive == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
			
			$sets[] = "user_isactive = $user_isactive";
			
		} 
		
		
		
		if(count($sets) < 1){
			echo "Nothing to update";
			DBClose($conn);
			return;
		}
		
		$result = update("Users", $sets, $where, 2, $conn);
		
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