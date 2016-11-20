<?php

session_start();

require_once '../accessors/access_calls.inc';
require_once '../utilities/get_permissions.inc';
require_once '../utilities/database_connection.inc';
require_once '../update_factory/update_factory.inc';

if(isset($_POST["callsupdaterequest"])){

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


	
	//Delete
	if($opcode == 2){
		
		$call_id = 0;
		
		if(isset($_POST["call_id"])){
			$call_id = intval(removeslashes($_POST["call_id"]));
		
			if($call_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
		} else {
			echo "Call ID not set.";
			DBClose($conn);
			return;
		}
		
		
		$result = deleteCall($call_id, $conn);
		
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
		
		if(($_SESSION["permissions"][0] == 1) == false){
			echo "You do not have permission to update Capstones.";
		}
		
		$call_id = 0;
		
		$call_comments = "";
		
		$where = "call_id = ";
		$sets = array();
		
		if(isset($_POST["call_id"])){
			$call_id = intval(removeslashes($_POST["call_id"]));
		
			if($call_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
			
			$where = $where . $call_id;
			
		} else {
			echo "Call ID not set.";
			DBClose($conn);
			return;
		}
		
		
		if(isset($_POST["call_comments"])){
			$call_comments = mysqli_real_escape_string($conn, removeslashes($_POST["call_comments"]));
			
			if(strlen(trim($call_comments)) < 1){
				echo "Call Comments is Blank.";
				DBClose($conn);
				die();
			}
			
			$sets[] = "call_comments = '" . $call_comments . "'";
			
		} 
		
		
		
		if(count($sets) < 1){
			echo "Nothing to update";
			DBClose($conn);
			return;
		}
		
		$result = update("Calls", $sets, $where, 2, $conn);
		
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